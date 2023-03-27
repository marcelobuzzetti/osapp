<?php

namespace App\Http\Controllers;

use App\Events\AtualizacaoOrdem;
use App\Mail\OrdemServico;
use App\Models\Os;
use App\Models\Cliente;
use App\Models\Marca;
use App\Models\Status;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class OsController extends Controller
{
            /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $ordens = Os::osMarcaCliente(); */
        $ordem = new Os;
        $ordens = $ordem->WhereNull('is_arquivado')->orWhere('is_arquivado', '=', false)->get();

        return view('ordem.index', [
            'ordens' => $ordens
        ]);

        /*
        Com paginação

        $clientes = Cliente::latest()->paginate(5);

        return view('cliente.index',compact('clientes'))
            ->with('i', (request()->input('page', 1) - 1) * 5); */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $os = new Os;

        return view('ordem.create', [
            'marcas' => Marca::all(),
            'clientes' => Cliente::all(),
            'status' => Status::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->valor_servico ? $request['is_orcado'] = TRUE : $request['is_orcado'] = FALSE;

/*         $request->valor_servico ? $request['valor_servico'] = Os::currencyToDecimal($request->valor_servico) : null; */

        $request->validate([
            'clienteNome' => 'required|exists:clientes,nome',
            'marcaDescricao' => 'required|exists:marcas,descricao',
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_aparelho' => 'required',
            'marca_id' => 'required|exists:marcas,id',
            'status_id' => 'required|exists:status,id',
            'modelo' => 'required',
            'estado_aparelho' => 'required',
            'defeito_alegado' => 'required',
        ]);

        $clienteNome = $request->old('clienteNome');
        $marcaDescricao = $request->old('marcaDescricao');
        $cliente_id = $request->old('cliente_id');
        $tipo_aparelho = $request->old('tipo_aparelho');
        $marca_id = $request->old('marca_id');
        $status_id = $request->old('status_id');
        $modelo = $request->old('modelo');
        $estado_aparelho = $request->old('estado_aparelho');
        $defeito_alegado = $request->old('defeito_alegado');
        $acessorios = $request->old('acessorios');
        $laudo_tecnico = $request->old('laudo_tecnico');

        try {
            $os = Os::create($request->all());
            $osId = $os->id;
            $message = [
                "type" => "success",
                "message" => "Ordem de Serviço nº $osId foi criada com sucesso!!!."
            ];
        } catch (\Throwable $e) {
            $message = [
                "type" => "error",
                "message" => $e->getMessage()
            ];
        }

        $ordem = Os::findOrFail($osId);
        $email = false;

        /*try {
            Mail::to($ordem->cliente->email, $ordem->cliente->nome)->send(new OrdemServico('Cadastro na Help Reparos', $ordem));
        } catch (\Throwable $e) {
            $email = "Email não enviado, verifique suas configurações de Email";
        }*/

        return redirect()->route('ordens.show', $osId)
                        ->with([
                            'message' => $message,
           /*                 'email' => $email*/
                        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Os  $ordem
     * @return \Illuminate\Http\Response
     */
    public function show($os)
    {
        $ordem = new Os;
        $ordem = $ordem->findOrFail($os);
        $total = 0;
        foreach($ordem->pecas as $peca){
            $total += $peca->valor;
        }

        if($ordem->is_arquivado) {
            $message = [
                "type" => "error",
                "message" => "OS nº $ordem->id está arquivada!!!<br></div><strong>Desarquive a OS clicando <br><div><a class='btn btn-dark' href=". url("/desarquivarOS?id=$ordem->id") .">AQUI</a>!!!</strong>"
            ];
            return redirect()->route('home')
                        ->with('message',$message);
        } else {
            return view('ordem.show',[
                'ordem' => $ordem,
                'total' => $total
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Os  $ordem
     * @return \Illuminate\Http\Response
     */
    public function edit($os)
    {
        $ordem = new Os;
        $ordem = $ordem->findOrFail($os);
        /* $ordem->valor_servico ? $ordem->valor_servico = Os::decimalToCurrency($ordem->valor_servico) : null; */

        $clientes = Cliente::all();
        $marcas = Marca::all();
        $status = Status::all();
        return view('ordem.edit',[
            'ordem' => $ordem,
            'clientes' => $clientes,
            'marcas' => $marcas,
            'status' => $status
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Os  $ordem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $os = new Os;
        $os = $os->findOrFail($request->id);
        $email = false;
        $socket = false;

        if(!$os->is_orcado){
            $request->valor_servico ? $request['is_orcado'] = TRUE : $request['is_orcado'] = FALSE;
        }

        /* $request->valor_servico ? $request['valor_servico'] = Os::currencyToDecimal($request->valor_servico) : null; */

        $request->validate([
            'clienteNome' => 'required|exists:clientes,nome',
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_aparelho' => 'required',
            'marcaDescricao' => 'required|exists:marcas,descricao',
            'marca_id' => 'required|exists:marcas,id',
            'status_id' => 'required|exists:status,id',
            'modelo' => 'required',
            'estado_aparelho' => 'required',
            'defeito_alegado' => 'required',
        ]);


        $cliente_id = $request->old('cliente_id');
        $tipo_aparelho = $request->old('tipo_aparelho');
        $marca_id = $request->old('marca_id');
        $status_id = $request->old('status_id');
        $modelo = $request->old('modelo');
        $estado_aparelho = $request->old('estado_aparelho');
        $defeito_alegado = $request->old('defeito_alegado');
        $acessorios = $request->old('acessorios');
        $valor_servico = $request->old('valor_servico');
        $laudo_tecnico = $request->old('laudo_tecnico');


        try {
            $os->update($request->all());
            $message = [
                "type" => "success",
                "message" => "OS Nº $request->id atualizada com sucesso!!!"
            ];
        } catch (\Throwable $e) {
            $message = [
                "type" => "error",
                "message" => $e->getMessage()
            ];
        }

        $ordem = Os::findOrFail($os->id);

        /*try {
            Mail::to($ordem->cliente->email, $ordem->cliente->nome)->send(new OrdemServico('Atualização na Ordem de Serviço', $ordem));
        } catch (\Throwable $e) {
            $email = "Email não enviado, verifique suas configurações de Email";
        }*/
        /*if($message["type"] == "success") event(new AtualizacaoOrdem($ordem));*/

        try{
            Http::get(config('broadcasting.connections.socket-io.url'), [
                'id' => $ordem->id
            ]);
        } catch (\Throwable $e) {
            $socket = "Erro ao enviar para o Socket";
        }

        return redirect()->route('ordens.show', $os->id)
            ->with([
                'message' => $message,
           /*     'email' => $email,
                '$socket' => $socket,*/
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Os  $ordem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->is_admin){
            $ordem = new Os;

            try{
                $ordem::where('id', $id)->delete();
                $message = [
                    "type" => "success",
                    "message" => "Ordem Nº $id foi apagada com sucesso!!!"
                ];
            } catch (\Throwable $e) {
                if(stripos($e->getMessage(), 'FOREIGN KEY')) {
                    $message = [
                        "type" => "error",
                        "message" => "Não é possível excluir a Ordem de Serviço!!!"
                    ];
                } else {
                    $message = [
                        "type" => "error",
                        "message" => $e->getMessage()
                    ];
                }
            }

            return redirect()->route('ordens.index')
                            ->with('message', $message);
        } else {
            $message = [
                "type" => "error",
                "message" => "Você não pode apagar Ordens de Serviço!!!"
            ];
            return redirect()->route('ordens.index')
                                ->with('message', $message);
        }
    }

    public function entregaShow($id)
    {
        $ordem = new Os;
        $ordem = $ordem->findOrFail($id);
        $clientes = Cliente::all();
        $marcas = Marca::all();
        $status = Status::all();
        return view('ordem.entrega',[
            'ordem' => $ordem,
            'status' => $status
        ]);
    }

    public function recusouShow($id)
    {
        $ordem = new Os;
        $ordem = $ordem->findOrFail($id);
        $clientes = Cliente::all();
        $marcas = Marca::all();
        $status = Status::all();
        return view('ordem.recusou',[
            'ordem' => $ordem,
            'status' => $status
        ]);
    }

    public function orcamento($os)
    {
        $ordem = new Os;
        $ordem = $ordem->findOrFail($os);

        return view('ordem.orcamento',[
            'ordem' => $ordem,
        ]);
    }

    public function orcamentoStore(Request $request)
    {
        /* $request['valor_servico'] = floatval(preg_replace('/[^\d\.]/', '', $request->valor_servico)); */

        $request->validate([
            'id' => 'required|exists:ordens,id',
            'valor_servico' => 'required',
            'email' => 'required|exists:users,email',
            'password' => 'required',

        ]);

        $valor_servico = $request->old('valor_servico');

        $user = User::where('email', $request['email'])
        ->where('is_admin', 1)
        ->first();

        $user ? $validCredentials = Hash::check($request['password'], $user->getAuthPassword()) : $validCredentials = FALSE;

        if ($validCredentials)
        {

            $ordem = new Os;
            $ordem = $ordem->findOrFail($request->id);

            try {
                $ordem->update($request->all());
                $message = [
                    "type" => "success",
                    "message" => "Ordem de Serviço nº $request->id foi Orçada!!!."
                ];
            } catch (\Throwable $e) {
                $message = [
                    "type" => "error",
                    "message" => $e->getMessage()
                ];
            }

            return redirect()->route('ordens.index')
                            ->with('message', $message);

        } else  {

            return back()->withErrors([
                'email' => 'Usuário e/ou Senha errados',
                'password' => 'Usuário e/ou Senha errados'
            ]);

        }


    }

    public function entrega(Request $request)
    {


        $request->validate([
            'id' => 'required|exists:ordens,id',
            'entregue_para' => 'required',
            'status_id' => 'required|',Rule::in([5, 7]),
        ]);

        $entregue_para = $request->old('entregue_para');
        $status_id = $request->old('status_id');
        $data = $request->all();
        /* $ordem = new Os;
        $ordem = $ordem->findOrFail($request->id); */

        $ordem = Os::findOrFail($request->id);

        /*Mail::to($ordem->cliente->email, $ordem->cliente->nome)->send(new OrdemServico('Atualização na Ordem de Serviço', $ordem));*/

        $date = date('Y-m-d');

        /* $ordem->update($data); */

        try {
            DB::table('ordens')
              ->where('id', $data['id'])
              ->update(['entregue_para' => $data['entregue_para'],
            'status_id' => $data['status_id'],
            'retirada' => $date,
            /* 'status_id' => 5 */
        ]   );
            $message = [
                "type" => "success",
                "message" => "Ordem de Serviço nº $request->id entregue para $request->entregue_para!!!."
            ];
        } catch (\Throwable $e) {
            $message = [
                "type" => "error",
                "message" => $e->getMessage()
            ];
        }

        /*return redirect()->route('ordens.index')
                        ->with('message', $message);*/

        return redirect()->route('imprimirOs', ['id' => $ordem->id])
            ->with([
                /*'message' => $message,*/
                'print' => TRUE
                /*                 'email' => $email*/
            ]);
    }

    public function recusou(Request $request)
    {


        $request->validate([
            'id' => 'required|exists:ordens,id',
            'entregue_para' => 'required',
     /*        'status_id' => 'required|exists:status,id', */
        ]);

        $entregue_para = $request->old('entregue_para');
        $status_id = $request->old('status_id');
        $data = $request->all();
        /* $ordem = new Os;
        $ordem = $ordem->findOrFail($request->id); */

        $date = date('Y-m-d');

        /* $ordem->update($data); */

        try {
            DB::table('ordens')
              ->where('id', $data['id'])
              ->update(['entregue_para' => $data['entregue_para'],
            /* 'status_id' => $data['status_id'], */
            'retirada' => $date,
            'status_id' => 7
        ]   );
            $message = [
                "type" => "success",
                "message" => "Ordem de Serviço nº $request->id entregue para $request->entregue_para!!!."
            ];
        } catch (\Throwable $e) {
            $message = [
                "type" => "error",
                "message" => $e->getMessage()
            ];
        }

        return redirect()->route('ordens.index')
                        ->with('message', $message);
    }

    /* public function showTeste($id)
    {
        $ordem = json_decode(json_encode(Os::osId($id)), true);
        return view('ordem.show',[
            'ordem' => $ordem
        ]);
    }

    public function editTeste($id)
    {
        $ordem = json_decode(json_encode(Os::osId($id)), true);
        $clientes = Cliente::all();
        $marcas = Marca::all();
        return view('ordem.edit',[
            'ordem' => $ordem,
            'clientes' => $clientes,
            'marcas' => $marcas
        ]);
    }

    public function destroyTeste($id)
    {
        $ordem = Os::find($id);
        $id = $ordem->id;
        $ordem->delete();

        return redirect()->route('ordens.index')
        ->with('success',"OS Nº $id apagada com sucesso!!!");
    } */

    public function buscarOs(Request $request)
    {
        $request->validate([
            'buscaOS' => 'required|exists:ordens,id',
        ]);

        $buscaOS = $request->old('buscaOS');

        return redirect()->route('ordens.show', $request->buscaOS);
    }

    public function imprimirOs(Request $request)
    {
        $ordem = new Os;
        $ordem = $ordem->findOrFail($request->id);
        $total = 0;
        foreach($ordem->pecas as $peca){
            $total += $peca->valor;
        }
        return view('ordem.show',[
            'ordem' => $ordem,
            'total' => $total,
            'print' => TRUE
        ]);
        /* return view('ordem.show',compact('ordem'))->with('print', TRUE); */
    }

    public function retornoEmGarantia(Request $request)
    {
        $os = new Os;
        $os = $os->findOrFail($request->id);
        $os->status_id = 6;
        $os->retirada = null;
        $os->entregue_para = null;

        try {
            $os->update($request->all());
            $message = [
                "type" => "success",
                "message" => "OS Nº $request->id retornou com sucesso!!!"
            ];
        } catch (\Throwable $e) {
            $message = [
                "type" => "error",
                "message" => $e->getMessage()
            ];
        }

        return redirect()->route('ordens.show', $os->id)
                        ->with('message',$message);
    }

    public function arquivarOS(Request $request)
    {
        $os = new Os;
        $os = $os->findOrFail($request->id);
        $os->is_arquivado = true;

        try {
            $os->update($request->all());
            $message = [
                "type" => "success",
                "message" => "OS Nº $request->id arquivada com sucesso!!!"
            ];
        } catch (\Throwable $e) {
            $message = [
                "type" => "error",
                "message" => $e->getMessage()
            ];
        }

        return redirect()->route('ordens.index')
                        ->with('message',$message);
    }

    public function desarquivarOS(Request $request)
    {
        $os = new Os;
        $os = $os->findOrFail($request->id);
        $os->is_arquivado = false;

        try {
            $os->update($request->all());
            $message = [
                "type" => "success",
                "message" => "OS Nº $request->id desarquivada com sucesso!!!"
            ];
        } catch (\Throwable $e) {
            $message = [
                "type" => "error",
                "message" => $e->getMessage()
            ];
        }

        return redirect()->route('ordens.index')
                        ->with('message',$message);
    }

                /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function arquivadas()
    {
        /* $ordens = Os::osMarcaCliente(); */
        $ordem = new Os;
        $ordens = $ordem->where('is_arquivado', '=', 1)->get();

        return view('ordem.index', [
            'ordens' => $ordens
        ]);

        /*
        Com paginação

        $clientes = Cliente::latest()->paginate(5);

        return view('cliente.index',compact('clientes'))
            ->with('i', (request()->input('page', 1) - 1) * 5); */
    }

}
