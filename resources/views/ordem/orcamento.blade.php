@extends('layouts.app')

@section('content')
    <div class="card-glass">
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
                    <div style="white-space: pre-wrap;">{{ $ordem->defeito_alegado }}</div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Laudo Técnico:</strong>
                    <div style="white-space: pre-wrap;">{{ $ordem->laudo_tecnico }}</div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Acessórios:</strong>
                    <div style="white-space: pre-wrap;">{{ $ordem->acessorios }}</div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Garantia:</strong>
                    {{ $ordem->garantia }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Status:</strong>
                    {{ $ordem->status->descricao }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <form action="{{ route('ordens.orcamentoStore', $ordem->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $ordem->id }}">
                    <div class="d-flex align-items-center">
                        <label class="me-2">
                            <strong>Valor do Serviço</strong>
                        </label>
                        <div>
                            <input type="text" name="valor_servico" id="valor_servico"
                                class="form-control @error('valor_servico') is-invalid @enderror"
                                placeholder="Valor Servico"
                                value="{{ old('valor_servico') ? old('valor_servico') : $ordem->valor_servico }}" autofocus>
                            @error('valor_servico')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
            </div>
            <hr class="mt-2">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="row mb-3">
                    <label for="email" class="mb-2">{{ __('Email Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="mb-2">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mb-2 text-center d-flex justify-content-center">
                <button type="submit" class="btn btn-primary d-flex-inline"><i class="icofont-save"></i> Atualizar</button>
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
@endsection
