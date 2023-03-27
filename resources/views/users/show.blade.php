@extends('layouts.app')
@section('content')
    <div class="card-glass">
        <div class="container">
            <div class="row">
                <div class="pull-left">
                    <h2>Mostrar Usuário</h2>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nome:</strong>
                        {{ $usuario->name }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        {{ $usuario->email }}
                    </div>
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
    @endsection
