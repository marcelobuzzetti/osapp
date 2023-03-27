@extends('layouts.app')

@section('content')
    <div class="card-glass">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 margin-tb d-flex justify-content-center">
                    <div class="pull-left">
                        <h2>Adicionar Peças a Ordem de Serviço nº {{ $ordem_id }}</h2>
                    </div>
                </div>
            </div>

            <form action="{{ route('pecas.store') }}" method="POST" id="form_pecas">
                @csrf
                <input type="hidden" name="ordem_id" value="{{ $ordem_id }}">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
                        <div class="form-group">
                            <strong>Descricao</strong>
                            <input class="form-control @error('descricao') is-invalid @enderror"
                                name="descricao" type="text" value="{{ old('descricao') }}"
                                placeholder="Digite o Nome da Peça">
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 mb-2">
                        <div class="form-group">
                            <strong>Valor da Peça</strong>
                            <input type="text" name="valor" id="valor"
                                class="form-control @error('valor') is-invalid @enderror" placeholder="Valor da Peça"
                                value="{{ old('valor') }}">
                            @error('valor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2 text-center d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary d-flex-inline btn-submit"><i class="icofont-save"></i>
                            Cadastrar</button>
                    </div>
                </div>
            </form>
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <td>Id</td>
                        <td>Descrição</td>
                        <td>Valor</td>
                        @if (Auth::user()->is_admin)
                            <td>Ações</td>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pecas as $peca)
                        <tr>
                            <td>{{ $peca->id }}</td>
                            <td>{{ $peca->descricao }}</td>
                            <td>{{ $peca->valor }}</td>
                            @if (Auth::user()->is_admin)
                                <td>
                                    <div class="d-flex flex-wrap justify-content-evenly">
                                            <button class="btn btn-danger flex-inline" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal" data-bs-nome="{{ $peca->id }}"
                                                data-bs-id="{{ $peca->id }}" data-bs-custom-class="custom-tooltip-danger"
                                                data-toggle="tooltip" title="Apagar"><i class="icofont-ui-delete"></i></button>
                                            </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>Id</td>
                        <td>Descrição</td>
                        <td>Valor</td>
                        @if (Auth::user()->is_admin)
                            <td>Ações</td>
                        @endif
                    </tr>
                </tfoot>
            </table>
            <div class="row mt-2">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right d-flex">
                        <a class="btn btn-primary d-flex-inline" href="{{ route('ordens.show', $ordem_id) }}"><i
                                class="icofont-arrow-left"></i> Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="apagarCliente" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="mb-3">
                            <p>Tem certeza que deseja apagar a Peca nº <strong class="fs-3"><span
                                        id="nomeClienteModal"></span></strong>?</p>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary d-flex-inline" data-bs-dismiss="modal"><i
                            class="icofont-close"></i> Fechar</button>
                    <button type="submit" class="btn btn-danger d-flex-inline"><i class="icofont-ui-delete"></i>
                        Apagar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            $('#example').DataTable({
                responsive: true,
                columnDefs: [{
                        type: 'date-euro',
                        targets: 2
                    },
                    {
                        "className": "align-middle",
                        "targets": "_all"
                    }
                ],
                fixedHeader: {
                    headerOffset: 60
                },
                "order": [0, 'desc'],
                dom: 'Bfrtip',
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 linhas', '25 linhas', '50 linhas', 'Mostrar tudo']
                ],
                language: {
                    buttons: {
                        pageLength: {
                            _: "Mostrar %d linhas",
                            '-1': "Mostrar todos"
                        }
                    }
                },
                buttons: [
                    "pageLength",
                ],
                /* buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ], */
                "oLanguage": {
                    "sSearch": "Buscar: ",
                    "sProcessing": "Aguarde enquanto os dados são carregados ...",
                    "sLengthMenu": "Mostrar _MENU_ registros por pagina",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sInfoEmtpy": "Exibindo 0 a 0 de 0 registros",
                    "sInfo": "Exibindo de _START_ a _END_ de _TOTAL_ registros",
                    "sInfoFiltered": "",
                    "oPaginate": {
                        "sFirst": "Primeiro",
                        "sPrevious": "Anterior",
                        "sNext": "Próximo",
                        "sLast": "Último"
                    }
                }
            });

        })

        const exampleModal = document.getElementById('exampleModal')
            exampleModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const nome = button.getAttribute('data-bs-nome')
                const id = button.getAttribute('data-bs-id')
                // If necessary, you could initiate an AJAX request here
                // and then do the updating in a callback.
                //
                // Update the modal's content.
                const modalTitle = exampleModal.querySelector('.modal-title')
                const modalBodyForm = document.getElementById('apagarCliente')
                const modalBodyNomeCliente = document.getElementById('nomeClienteModal')

                modalTitle.textContent = `Apagar OS nº ${nome}`
                modalBodyNomeCliente.textContent = nome
                modalBodyForm.action = `<?php echo env('APP_URL'); ?>/pecas/${id}`
            })
    </script>
@endsection
