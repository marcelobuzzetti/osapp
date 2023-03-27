<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Os;
use App\Models\Peca;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PecaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required',
            'valor' => 'required',
            'ordem_id' => 'required',
        ]);

        $descricao = $request->old('descricao');
        $valor = $request->old('valor');
        $ordem_id = $request->old('ordem_id');

        try {
            $peca = Peca::create($request->all());
            $message = [
                "type" => "success",
                "message" => "Peça adicionada a Ordem de Serviço nº $peca->ordem_id!!!."
            ];
        } catch (Exception $e) {
            $message = [
                "type" => "error",
                "message" => $e->getMessage()
            ];
        }

        return redirect()->route('pecas.edit', $peca->ordem_id)
            ->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pecas = new Peca();
        $pecas = $pecas->where('ordem_id','=', $id)->get();
        return view('peca.create',[
            'ordem_id' => $id,
            'pecas' => $pecas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->is_admin){
            try{
                $peca = Peca::findOrFail($id);
                Peca::where('id', $id)->delete();
                $message = [
                    "type" => "success",
                    "message" => "Peça Nº $id foi apagada com sucesso!!!"
                ];
            } catch (Exception $e) {
                if(stripos($e->getMessage(), 'FOREIGN KEY')) {
                    $message = [
                        "type" => "error",
                        "message" => "Não é possível excluir a Peça!!!"
                    ];
                } else {
                    $message = [
                        "type" => "error",
                        "message" => $e->getMessage()
                    ];
                }
            }

            return redirect()->route('pecas.edit', $peca->ordem_id)
            ->with('message', $message);
        } else {
            $message = [
                "type" => "error",
                "message" => "Você não pode apagar peças!!!"
            ];
            return redirect()->route('ordens.index')
                            ->with('message', $message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPecasOs(Request $request)
    {
        /* $pecas = new Peca();
        $pecas = $pecas->where('ordem_id','=', $id)->get();
        return response()->json($pecas); */

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Peca::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Peca::select('count(*) as allcount')->where('descricao', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = Peca::orderBy($columnName,$columnSortOrder)
          ->where('pecas.descricao', 'like', '%' .$searchValue . '%')
          ->select('pecas.*')
          ->skip($start)
          ->take($rowperpage)
          ->get();

        $data_arr = array();

        foreach($records as $record){
           $id = $record->id;
           $descricao = $record->descricao;
           $valor = $record->valor;

           $data_arr[] = array(
             "id" => $id,
             "descricao" => $descricao,
             "valor" => $valor,
           );
        }

        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr
        );

        dd($response);
        exit;

        echo json_encode($response);
      }
}
