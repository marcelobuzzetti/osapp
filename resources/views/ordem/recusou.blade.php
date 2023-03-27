@extends('layouts.app')

@section('content')
    <div class="card-glass">
        <div class="container">
        <div class="row">
            <div class="pull-left d-flex justify-content-center">
                <h2>OS Nº {{ $ordem->id }}</h2>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Status:</strong>
                    {{ $ordem->status->descricao }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Entrada:</strong>
                    {{ date('d/m/Y', strtotime($ordem->entrada)) }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Cliente:</strong>
                    {{ $ordem->cliente->nome }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Marca:</strong>
                    {{ $ordem->marca->descricao }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Modelo:</strong>
                    {{ $ordem->modelo }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Tipo do Aparelho:</strong>
                    {{ $ordem->tipo_aparelho }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Estado do Aparelho:</strong>
                    {{ $ordem->estado_aparelho }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Defeito Alegado:</strong>
                    {{ $ordem->defeito_alegado }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Valor do Servico:</strong>
                    {{ "R$ " . $ordem->valor_servico/* number_format($ordem->valor_servico,2,',','.') */ }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Garantia:</strong>
                    {{ $empresa->garantia . " Dias"}}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <form action="{{ route('ordens.recusouOrcamento', $ordem->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $ordem->id }}">
                    <div class="d-flex align-items-center">
                        <label class="me-2">
                            <strong>Entregue por recusa de orçamento para</strong>
                        </label>
                        <div>
                            <input type="text" name="entregue_para" class="form-control @error('entregue_para') is-invalid @enderror" placeholder="Entregue para?"
                                value="{{ old('entregue_para') ? old('entregue_para') : $ordem->entregue_para }}">
                            @error('entregue_para')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
            </div>
            {{-- <div class="col-xs-12 col-sm-12 col-md-12 mb-2 mt-2">
                <div class="d-flex align-items-center">
                    <label class="me-2">
                        <strong>Status</strong>
                    </label>
                    <div>
                    <select name="status_id" class="form-control @error('status_id') is-invalid @enderror">
                        <option selected disabled>Selecione a status</option>
                        @if ($status)

                        @foreach ( $status as $status)

                        <option value="{{ $status->id }}" @if (old('status_id')  == $status->id) selected @endif @if ($ordem->status_id  == $status->id) selected @endif>{{ $status->descricao }}</option>

                        @endforeach

                        @endif
                      </select>
                    @error('status_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                </div>
            </div> --}}
            <div class="col-xs-12 col-sm-12 col-md-12 mb-2 text-center d-flex justify-content-center">
                <button type="submit" class="btn btn-success d-flex-inline"><i class="icofont-exit"></i> Registrar Retirada</button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right d-flex">
                    <a class="btn btn-primary d-flex-inline" href="{{ route('ordens.index') }}"><i
                            class="icofont-arrow-left"></i> Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
