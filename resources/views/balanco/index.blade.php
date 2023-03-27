@extends('layouts.app')

@section('content')
    <div class="card-glass">
        <div class="text-center">
            <h2>Balanço do corrente mês ({{ Str::upper($data) }})</h2>
            <h4 class="text-success">Recebido R${{ sprintf('%0.2f', $totalOrcamentos) }} <i class="icofont-arrow-up"></i></h4>
            <h4 class="text-danger">Despesas R${{ sprintf('%0.2f', $totalPecas) }} <i class="icofont-arrow-down"></i></h4>
            <h4 class="text-success">Total</h4>
            <h3 class="text-success"><i class="icofont-bank"></i> R${{ sprintf('%0.2f', $balanco) }} <i class="icofont-bank"></i></h3>
        </div>
        <hr>
        <form action="{{ route('relatorio') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <strong>Data de Início</strong>
                        <input type="date" id="start_date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text">Formato da data dd/mm/aaaa, ex. 01/01/2023</div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <strong>Data Fim</strong>
                        <input type="date" id="end_date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text">Formato da data dd/mm/aaaa, ex. 01/01/2023</div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mb-2 text-center d-flex justify-content-center">
                <button type="submit" class="btn btn-primary d-flex-inline"><i class="icofont-ui-calendar"></i> Gerar</button>
            </div>
        </form>
    </div>
@endsection
