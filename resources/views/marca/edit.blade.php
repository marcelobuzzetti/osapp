@extends('layouts.app')

@section('content')
    <div class="card-glass">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left d-flex justify-content-center">
                        <h2>Editar Marca {{ $marca->descricao }}</h2>
                    </div>
                </div>
            </div>
        <form action="{{ route('marcas.update', $marca->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                    <div class="form-group">
                        <strong>Descrição</strong>
                        <input type="text" name="descricao" class="form-control @error('descricao') is-invalid @enderror"
                            placeholder="Descricao" value="{{ old('descricao') ? old('descricao') : $marca->descricao }}">
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-2 text-center d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary d-flex-inline"><i class="icofont-save"></i> Atualizar</button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right d-flex">
                        <a class="btn btn-primary d-flex-inline" href="{{ route('marcas.index') }}"><i class="icofont-arrow-left"></i> Voltar</a>
                    </div>
                </div>
            </div>
    </div>
@endsection
