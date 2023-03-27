<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarcaController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('marca.index', [
            'marcas' => Marca::all()
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
        return view('marca.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $descricaoPOST = $request->descricao;

        $request->validate([
            'descricao' => 'required|max:255|unique:marcas'
        ]);

        $descricao = $request->old('descricao');

        try {
            Marca::create($request->all());
            $message = [
                "type" => "success",
                "message" => "Marca $descricaoPOST criada com sucesso!!!."
            ];
        } catch (Exception $e) {
            $message = [
                "type" => "error",
                "message" => $e->getMessage()
            ];
        }

        return redirect()->route('marcas.index')
                        ->with('message',$message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function show(Marca $marca)
    {
        return view('marca.show',compact('marca'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        return view('marca.edit',compact('marca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marca $marca)
    {

        $request->validate([
            'descricao' => "required|max:255|unique:marcas,descricao,$marca->id,id",
        ]);

        $descricao = $request->old('descricao');

        $descricaoPOST = $request->descricao;

        try {
            $marca->update($request->all());
            $message = [
                "type" => "success",
                "message" => "Marca $descricaoPOST atualizada com sucesso!!!"
            ];
        } catch (Exception $e) {
            $message = [
                "type" => "error",
                "message" => $e->getMessage()
            ];
        }

        return redirect()->route('marcas.index')
                        ->with('message',$message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marca $marca)
    {
        if (Auth::user()->is_admin){
            $descricao = $marca->descricao;

            try{
                $marca->delete();
                $message = [
                    "type" => "success",
                    "message" => "Marca $descricao apagada com sucesso!!!"
                ];
            } catch (Exception $e) {
                if(stripos($e->getMessage(), 'FOREIGN KEY')) {
                    $message = [
                        "type" => "error",
                        "message" => "Não é possível excluir marca usada em Ordem de Serviço!!!"
                    ];
                } else {
                    $message = [
                        "type" => "error",
                        "message" => $e->getMessage()
                    ];
                }
            }

            return redirect()->route('marcas.index')
                            ->with('message', $message);
        } else {
            $message = [
                "type" => "error",
                "message" => "Você não pode apagar marcas!!!"
            ];
            return redirect()->route('marcas.index')
                            ->with('message', $message);
        }
    }

    public function autocomplete(Request $request)
    {
        $data = Marca::select("descricao as value", "id")
                ->where('descricao', 'LIKE', '%'. $request->get('search'). '%')
                ->get();

        return response()->json($data);
    }
}
