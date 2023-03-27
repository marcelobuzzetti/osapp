<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cliente.index', [
            'clientes' => Cliente::all()
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
        return view('cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nomePOST = $request->nome;

        $request->validate([
            'nome' => 'required|max:255|min:3',
            'telefone' => 'required|numeric',
            'endereco' => 'required|min:10',
        ]);

        $nome = $request->old('nome');
        $telefone = $request->old('telefone');
        $rg = $request->old('rg');
        $cpf = $request->old('cpf');
        $email = $request->old('email');
        $endereco = $request->old('endereco');

        try {
            $cliente = Cliente::create($request->all());
            $message = [
                "type" => "success",
                "message" => "Cliente $nomePOST criado com sucesso!!!."
            ];
        } catch (Exception $e) {
            $message = [
                "type" => "error",
                "message" => $e->getMessage()
            ];
        }

        return redirect()->route('clientes.show', $cliente->id)
            ->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        return view('cliente.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        return view('cliente.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nome' => 'required|max:255|min:3',
            'telefone' => 'required|numeric',
            'endereco' => 'required|min:10',
        ]);

        $nome = $request->old('nome');
        $telefone = $request->old('telefone');
        $rg = $request->old('rg');
        $cpf = $request->old('cpf');
        $email = $request->old('email');
        $endereco = $request->old('endereco');

        $nomePOST = $request->nome;


        try {
            $cliente->update($request->all());
            $message = [
                "type" => "success",
                "message" => "Cliente $nomePOST atualizado com sucesso!!!"
            ];
        } catch (Exception $e) {
            $message = [
                "type" => "error",
                "message" => $e->getMessage()
            ];
        }

        return redirect()->route('clientes.show', $cliente->id)
            ->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        if (Auth::user()->is_admin){
            $nome = $cliente->nome;
            $message = [];
            try {
                $cliente->delete();
                $message = [
                    "type" => "success",
                    "message" => "Cliente $nome apagado com sucesso!!!"
                ];
            } catch (Exception $e) {
                if (stripos($e->getMessage(), 'FOREIGN KEY')) {
                    $message = [
                        "type" => "error",
                        "message" => "Não é possível excluir cliente com Ordem de Serviço cadastrada!!!"
                    ];
                } else {
                    $message = [
                        "type" => "error",
                        "message" => $e->getMessage()
                    ];
                }
            }

            return redirect()->route('clientes.index')
                ->with('message', $message);
        } else {
            $message = [
                "type" => "error",
                "message" => "Você não pode excluir Clientes!!!"
            ];
            return redirect()->route('clientes.index')
            ->with('message', $message);
        }
    }

    public function autocomplete(Request $request)
    {
        $data = Cliente::select("nome as value", "id")
                ->where('nome', 'LIKE', '%'. $request->get('search'). '%')
                ->orWhere('CPF', 'LIKE', '%'. $request->get('search'). '%')
                ->get();

        return response()->json($data);
    }
}
