@extends('layouts.app')

@section('content')
    <div class="card-glass">
        <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb d-flex justify-content-center">
                <div class="pull-left">
                    <h2>Adicionar Nova Ordem de Serviço</h2>
                </div>
            </div>
        </div>

        <form action="{{ route('ordens.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <strong>Cliente</strong>
                        <input class="form-control @error('cliente_id') is-invalid @enderror @error('clienteNome') is-invalid @enderror" name="clienteNome" id="clienteAutoComplete" type="text" value="{{ old('clienteNome') }}" placeholder="Digite o Nome ou o CPF do Cliente">
                        <input type="hidden" name="cliente_id" id="cliente_id" value="{{ old('cliente_id') }}">
                        @error('cliente_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('clienteNome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <strong>Marca</strong>
                        <input class="form-control @error('marca_id') is-invalid @enderror @error('marcaDescricao') is-invalid @enderror" name="marcaDescricao" id="marcaAutoComplete" type="text" value="{{ old('marcaDescricao') }}" placeholder="Digite o Nome da Marca">
                        <input type="hidden" name="marca_id" id="marca_id" value="{{ old('marca_id') }}">
                        @error('marca_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('marcaDescricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 mb-2">
                    <div class="form-group">
                        <strong>Tipo de Aparelho</strong>
                        <input type="text" name="tipo_aparelho" class="form-control @error('tipo_aparelho') is-invalid @enderror" placeholder="Tipo de Aparelho" value="{{ old('tipo_aparelho') }}">
                        @error('tipo_aparelho')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 mb-2">
                    <div class="form-group">
                        <strong>Modelo</strong>
                        <input type="text" name="modelo" class="form-control @error('modelo') is-invalid @enderror" placeholder="Modelo" value="{{ old('modelo') }}">
                        @error('modelo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 mb-2">
                    <div class="form-group">
                        <strong>Estado do Aparelho</strong>
                        <input type="text" name="estado_aparelho" class="form-control @error('estado_aparelho') is-invalid @enderror" placeholder="Estado do Aparelho" value="{{ old('estado_aparelho') }}">
                        @error('estado_aparelho')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                    <div class="form-group">
                        <strong>Acessórios</strong>
                        <textarea name="acessorios" class="form-control @error('acessorios') is-invalid @enderror">{{ old('acessorios') }}</textarea>
                        @error('acessorios')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                    <div class="form-group">
                        <strong>Defeito Alegado</strong>
                        <input type="text" name="defeito_alegado" class="form-control @error('defeito_alegado') is-invalid @enderror" placeholder="Defeito Alegado" value="{{ old('defeito_alegado') }}">
                        @error('defeito_alegado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div> --}}
                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                    <div class="form-group">
                        <strong>Defeito Alegado</strong>
                        <textarea name="defeito_alegado" class="form-control @error('defeito_alegado') is-invalid @enderror">{{ old('defeito_alegado') }}</textarea>
                        @error('defeito_alegado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 mb-2">
                    <div class="form-group">
                        <strong>Valor do Serviço</strong>
                        <input type="text" id="valor_servico" name="valor_servico" class="form-control @error('valor_servico') is-invalid @enderror" placeholder="Valor Servico" value="{{ old('valor_servico') }}">
                        @error('valor_servico')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 mb-2">
                    <div class="form-group">
                        <strong>Status</strong>
                        <select name="status_id" class="form-control @error('status_id') is-invalid @enderror">
                            <option selected disabled>Selecione a status</option>
                            @if ($status)

                            @foreach ( $status as $status)

                            <option value="{{ $status->id }}" @if (old('status_id')  == $status->id) selected @endif>{{ $status->descricao }}</option>

                            @endforeach

                            @endif
                          </select>
                        @error('status_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                    <div class="form-group">
                        <strong>Laudo Técnico</strong>
                        <textarea name="laudo_tecnico" class="form-control @error('laudo_tecnico') is-invalid @enderror">{{ old('laudo_tecnico') }}</textarea>
                        @error('laudo_tecnico')
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
                    <a class="btn btn-primary d-flex-inline" href="{{ route('ordens.index') }}"><i class="icofont-arrow-left"></i> Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>
{{--     <script>
         $(document).ready(function() {
            $("[name='cliente_id']").select2();
            $("[name='marca_id']").select2();
         });
    </script> --}}
    <script type="text/javascript">
        var path = "{{ route('autocompletecliente') }}";
        $( "#clienteAutoComplete" ).autocomplete({
            source: function( request, response ) {
              $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                data: {
                   search: request.term
                },
                success: function( data ) {
                   response( data );
                }
              });
            },
            select: function (event, ui) {
               $('#clienteAutoComplete').val(ui.item.label);
               $("#cliente_id").val(ui.item.id);

               return false;
            }
          });

          var path1 = "{{ route('autocompletemarca') }}";
        $( "#marcaAutoComplete" ).autocomplete({
            source: function( request, response ) {
              $.ajax({
                url: path1,
                type: 'GET',
                dataType: "json",
                data: {
                   search: request.term
                },
                success: function( data ) {
                   response( data );
                }
              });
            },
            select: function (event, ui) {
               $('#marcaAutoComplete').val(ui.item.label);
               $("#marca_id").val(ui.item.id);

               return false;
            }
          });
    </script>
@endsection
