@extends('layouts.app')

@section('content')
    <div class="card-glass">
        <div class="row">
            <div class="pull-left">
                <h2>Mostrar Cliente</h2>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nome:</strong>
                    {{ $cliente->nome }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Telefone:</strong>
                    {{ $cliente->telefone }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>RG:</strong>
                    {{ $cliente->rg }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>CPF:</strong>
                    {{ $cliente->cpf }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    {{ $cliente->email }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Endereço:</strong>
                    {{ $cliente->endereco }}
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap justify-content-center">
            <div class="p-2">
                <a class="btn btn-primary flex-inline flex-grow-1" href="{{ route('clientes.edit', $cliente->id) }}"><i
                        class="icofont-ui-edit"></i> Editar</a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right d-flex">
                    <a class="btn btn-primary d-flex-inline" href="{{ route('clientes.index') }}"><i class="icofont-arrow-left"></i> Voltar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
