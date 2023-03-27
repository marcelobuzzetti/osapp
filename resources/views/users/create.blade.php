@extends('layouts.app')
@section('content')
    <div class="card-glass">
        <div class="row">
            <div class="col-lg-12 margin-tb d-flex justify-content-center">
                <div class="pull-left">
                    <h2>Adicionar Novo Usuário</h2>
                </div>
            </div>
        </div>
        <form action="{{ route('usuarios.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nome</strong>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Digite o Nome" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email</strong>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Digite o Email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Senha</strong>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Digite a Senha">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Confirme a Senha</strong>
                        <input type="password" name="confirm-password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Confirme a Senha">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Adminstrador?</strong>
                        <input class="form-check-input @error('is_admin') is-invalid @enderror" type="checkbox" name="is_admin">
                        @error('is_admin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 my-2 text-center d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary d-flex-inline"><i class="icofont-save"></i>
                        Cadastrar</button>
                </div>
            </div>
        </form>
        <div class="row mt-2">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right d-flex">
                    <a class="btn btn-primary d-flex-inline" href="{{ route('clientes.index') }}"><i
                            class="icofont-arrow-left"></i> Voltar</a>
                </div>
            </div>
        </div>
    </div>

@endsection
