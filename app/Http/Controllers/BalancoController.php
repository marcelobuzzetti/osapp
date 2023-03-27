<?php

namespace App\Http\Controllers;

use App\Models\Os;
use App\Models\Peca;
use DateTime;
use Illuminate\Http\Request;
use IntlDateFormatter;

class BalancoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = date('m');
        $f = new IntlDateFormatter(null, null, null, null, null, 'MMMM');
        $data = $f->format(new DateTime(date('Y-m-d')));

        $totalOrcamentos = Os::whereMonth('retirada','=',$date)->where('status_id', '=', 5)->where('is_arquivado', '=', '1')->sum('valor_servico');
        $pecas = Os::with(['Pecas'])->whereMonth('retirada','=',$date)->where('status_id', '=', 5)->where('is_arquivado', '=', '1')->get();
        $totalPecas = 0;

        foreach ($pecas as $peca)
        {
            foreach($peca->pecas as $peca){
                $totalPecas += $peca->valor;
            }
        }

        $balanco = $totalOrcamentos - $totalPecas;

        return view('balanco.index', [
            'balanco' => $balanco,
            'data' => $data,
            'totalOrcamentos' => $totalOrcamentos,
            'totalPecas' => $totalPecas,
        ]);
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
        //
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
        //
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
        //
    }

    public function relatorio(Request $request)
    {
        if(!$request->start_date && !$request->end_date){
            $totalOrcamentosGerado = Os::where('status_id', '=', 5)->where('is_arquivado', '=', '1')->sum('valor_servico');
            $pecas = Os::with(['Pecas'])->where('status_id', '=', 5)->where('is_arquivado', '=', '1')->get();
            $totalPecasGerado = 0;

        foreach ($pecas as $peca)
        {
            foreach($peca->pecas as $peca){
                $totalPecasGerado += $peca->valor;
            }
        }

        $balancoGerado = $totalOrcamentosGerado - $totalPecasGerado;

        return view('balanco.relatorio', [
                'balancoGerado' => $balancoGerado,
                'totalOrcamentosGerado' => $totalOrcamentosGerado,
                'totalPecasGerado' => $totalPecasGerado
            ]);

        }

        $request->validate([
            'start_date' => 'required|date|before:tomorrow',
        ]);

        if($request->end_date){
            $request->validate([
                'end_date'   => 'required|date|after:start_date',
            ]);
            $totalOrcamentosGerado = Os::whereBetween('retirada',[$request->start_date, $request->end_date])->where('status_id', '=', 5)->where('is_arquivado', '=', '1')->sum('valor_servico');
            $pecas = Os::with(['Pecas'])->whereBetween('retirada',[$request->start_date, $request->end_date])->where('status_id', '=', 5)->where('is_arquivado', '=', '1')->get();
            $fim = new IntlDateFormatter(null, null, null, null, null, 'dd/MM/yyyy');
            $dataFim = $fim->format(new DateTime($request->end_date));
        } else {
            $totalOrcamentosGerado = Os::where('retirada', '>=', $request->start_date)->where('status_id', '=', 5)->where('is_arquivado', '=', '1')->sum('valor_servico');
            $pecas = Os::with(['Pecas'])->where('retirada', '>=', $request->start_date)->where('status_id', '=', 5)->where('is_arquivado', '=', '1')->get();
        }

        $start_date = $request->old('start_date');
        $end_date = $request->old('end_date');

        $inicio = new IntlDateFormatter(null, null, null, null, null, 'dd/MM/yyyy');
        $dataInicio = $inicio->format(new DateTime($request->start_date));

        $atual = new IntlDateFormatter(null, null, null, null, null, 'dd/MM/yyyy');
        $dataAtual = $atual->format(new DateTime());

        $totalPecasGerado = 0;

        foreach ($pecas as $peca)
        {
            foreach($peca->pecas as $peca){
                $totalPecasGerado += $peca->valor;
            }
        }

        $balancoGerado = $totalOrcamentosGerado - $totalPecasGerado;

        return view('balanco.relatorio', [
                'balancoGerado' => $balancoGerado,
                'totalOrcamentosGerado' => $totalOrcamentosGerado,
                'totalPecasGerado' => $totalPecasGerado,
                'dataInicio' => $dataInicio,
                'dataFim' => isset($dataFim) ? $dataFim : $dataAtual,
            ]);

    }
}
