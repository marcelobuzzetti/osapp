@extends('layouts.app')

@section('content')
    <div class="card-glass">
        <div class="row">
            <div class="col-lg-12 margin-tb d-flex justify-content-center">
                <div class="pull-left">
                    <h2>Adicionar Novo Cliente</h2>
                </div>
            </div>
        </div>

        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                    <div class="form-group">
                        <strong>Nome</strong>
                        <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" placeholder="Nome" value="{{ old('nome') }}">
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 mb-2">
                    <div class="form-group">
                        <strong>Telefone</strong>
                        <input type="tel" class="form-control @error('telefone') is-invalid @enderror" name="telefone" placeholder="Telefone" value="{{ old('telefone') }}">
                        <div class="form-text">Digite somente números</div>
                        @error('telefone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 mb-2">
                    <div class="form-group">
                        <strong>RG</strong>
                        <input type="text" class="form-control @error('rg') is-invalid @enderror" name="rg" placeholder="RG" value="{{ old('rg') }}">
                        <div class="form-text">Digite somente números</div>
                        @error('rg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 mb-2">
                    <div class="form-group">
                        <strong>CPF</strong>
                        <input type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" placeholder="CPF" value="{{ old('cpf') }}">
                        <div class="form-text">Digite somente números</div>
                        @error('cpf')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                    <div class="form-group">
                        <strong>Email</strong>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                    <div class="form-group">
                        <strong>Endereço</strong>
                        <input type="text" class="form-control @error('endereco') is-invalid @enderror" name="endereco" placeholder="Endereço" value="{{ old('endereco') }}">
                        @error('endereco')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-2 text-center d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary d-flex-inline"><i class="icofont-save"></i> Cadastrar</button>
                </div>
            </div>
        </form>
        <div class="row mt-2">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right d-flex">
                    <a class="btn btn-primary d-flex-inline" href="{{ route('clientes.index') }}"><i class="icofont-arrow-left"></i> Voltar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
