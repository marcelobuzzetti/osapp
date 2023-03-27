@extends('layouts.app')
@section('content')
    <div class="card-glass">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left d-flex justify-content-center">
                        <h2>Editar Usuário {{ $usuario->name }}</h2>
                    </div>
                </div>
            </div>
            <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                @csrf
            @method('PUT')
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="name" value="{{ old('name') ? old('name') : $usuario->name }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email:</strong>
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="email" value="{{ old('email') ? old('email') : $usuario->email }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Senha:</strong>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Digite a Senha">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Confirme Senha:</strong>
                            <input type="password" name="confirma-senha" class="form-control @error('password') is-invalid @enderror" placeholder="Confirme a Senha">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                        <div class="form-group">
                            <strong>Adminstrador?</strong>
                            <input class="form-check-input @error('is_admin') is-invalid @enderror" type="checkbox" name="is_admin" @if ($usuario->is_admin) checked="checked" @endif value="1">
                            @error('is_admin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-2 text-center d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary d-flex-inline"><i class="icofont-save"></i>
                            Atualizar</button>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right d-flex">
                                <a class="btn btn-primary d-flex-inline" href="{{ route('usuarios.index') }}"><i
                                        class="icofont-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
