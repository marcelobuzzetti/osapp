@extends('layouts.app')

@section('content')
    <div class="content-title mb-0" style="display: none">
        <img class="img-print" src="/assets/img/logo.png">
        <div>
            <div>{{ $empresa->nome_empresa }}</div>
            <div><i class="icofont-phone"></i> {{ $empresa->telefone }}</div>
            <div><i class="icofont-google-map"></i> {{ $empresa->endereco }}</div>
            <div><i class="icofont-email"></i> {{ $empresa->email }}</div>
            <div><i class="icofont-facebook"></i> {{ $empresa->facebook }}</div>
            <div><i class="icofont-brand-whatsapp"></i> {{ $empresa->whatsapp }}</div>
        </div>
    </div>
    <div class="card-glass hide">
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
                    <strong>Acessórios:</strong>
                    <div style="white-space: pre-wrap;">{{ $ordem->acessorios ?  $ordem->acessorios : 'Nenhum'}}</div>
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
                    <strong>Observação:</strong>
                    <div style="white-space: pre-wrap;">{{ $empresa->observacao }}</div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Valor do Serviço:</strong>
                    {{ $ordem->valor_servico ? "R$ " . $ordem->valor_servico /* number_format($ordem->valor_servico,2,',','.') */ : 'Não orçado' }}
                </div>
            </div>
            @if (count($ordem->pecas) > 0)
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Peças:</strong>
                        <br>
                        Descricação/Valor
                        @foreach ($ordem->pecas as $pecas)
                        <div class="form-group">
                             {{ $pecas->descricao }} / R${{ $pecas->valor }}
                        </div>
                        @endforeach
                        <div class="form-group">
                            Total das Peças: R${{ $total }}
                        </div>
                    </div>
                </div>
            @endif
            @if ($ordem->status_id == 4 || $ordem->status_id == 5)
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Garantia:</strong>
                    {{ $empresa->garantia ? $empresa->garantia . " Dias" : "Não lançado"}}
                </div>
            </div>
            @endif
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Entregue para:</strong>
                    {{ $ordem->entregue_para && $ordem->retirada ? $ordem->entregue_para . ' em ' . date('d/m/Y', strtotime($ordem->retirada)) : 'Não entregue' }}
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-center">
                <div class="p-2">
                    <a class="btn btn-primary flex-inline flex-grow-1" href="{{ route('ordens.edit', $ordem->id) }}"><i
                            class="icofont-ui-edit"></i> Editar</a>
                </div>
                <div class="p-2">
                    <a class="btn btn-secondary flex-inline" {{-- href="{{ route('imprimirOs', ['id' => $ordem->id]) }}" --}} onclick="imprimir()"><i
                            class="icofont-printer"></i> Imprimir</a>
                </div>
                <div class="p-2">
                <a class="btn btn-blue flex-inline"
                                        href="{{ route('pecas.edit', $ordem->id) }}"
                                        data-bs-custom-class="custom-tooltip-blue" data-toggle="tooltip"
                                        title="Peças"><i class="icofont-plugin"></i>Peças</a>
                </div>
                @if ($ordem->status_id != 5)
                    <div class="p-2">
                        <a class="btn btn-success flex-inline flex-grow-1"
                            href="{{ route('ordens.orcamento', $ordem->id) }}"><i class="icofont-exit"></i> Retirada</a>
                    </div>
                    @if (Auth::user()->is_admin)
                        <div class="p-2">
                            <button class="btn btn-danger flex-inline flex-grow-1" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" data-bs-nome="{{ $ordem->id }}"
                                data-bs-id="{{ $ordem->id }}"><i class="icofont-ui-delete"></i>
                                Apagar</button>
                        </div>
                    @endif
                @endif
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="apagarCliente" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                            <div class="mb-3">
                                <p>Tem certeza que deseja apagar a OS nº <strong class="fs-3"><span
                                            id="nomeClienteModal"></span></strong>?</p>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary d-flex-inline" data-bs-dismiss="modal"><i
                                class="icofont-close"></i> Fechar</button>
                        <button type="submit" class="btn btn-danger d-flex-inline"><i class="icofont-ui-delete"></i>
                            Apagar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="print mt-0">
        <div class="row">
            <div class="pull-left d-flex justify-content-center">
                <h2>OS Nº {{ $ordem->id }}</h2>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="">
                <div class="form-group">
                    <strong>Status:</strong>
                    {{ $ordem->status->descricao }}
                </div>
            </div>
            <div class="">
                <div class="form-group">
                    <strong>Entrada:</strong>
                    {{ date('d/m/Y', strtotime($ordem->entrada)) }}
                </div>
            </div>
            <div class="">
                <div class="form-group">
                    <strong>Cliente:</strong>
                    {{ $ordem->cliente->nome }}
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="">
                <div class="form-group">
                    <strong>Marca:</strong>
                    {{ $ordem->marca->descricao }}
                </div>
            </div>
            <div class="">
                <div class="form-group">
                    <strong>Modelo:</strong>
                    {{ $ordem->modelo }}
                </div>
            </div>
            <div class="">
                <div class="form-group">
                    <strong>Tipo do Aparelho:</strong>
                    {{ $ordem->tipo_aparelho }}
                </div>
            </div>
            <div class="">
                <div class="form-group">
                    <strong>Estado do Aparelho:</strong>
                    {{ $ordem->estado_aparelho }}
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="">
                <div class="form-group">
                    <strong>Defeito Alegado:</strong>
                    <div style="white-space: pre-wrap;">{{ $ordem->defeito_alegado }}</div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="">
                <div class="form-group">
                    <strong>Acessórios:</strong>
                    <div style="white-space: pre-wrap;">{{ $ordem->acessorios ?  $ordem->acessorios : 'Nenhum'}}</div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="">
                <div class="form-group">
                    <strong>Laudo Técnico:</strong>
                    <div style="white-space: pre-wrap;">{{ $ordem->laudo_tecnico }}</div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between flex-wrap">
            <div class="">
                <div class="form-group">
                    <strong>Valor do Serviço:</strong>
                    {{ $ordem->valor_servico ? "R$ " . $ordem->valor_servico /* number_format($ordem->valor_servico,2,',','.') */ : 'Não orçado' }}
                </div>
            </div>
            @if ($ordem->status_id == 4 || $ordem->status_id == 5)
            <div class="">
                <div class="form-group">
                    <strong>Garantia:</strong>
                    {{ $empresa->garantia ? $empresa->garantia . " Dias" : "Não lançado"}}
                </div>
            </div>
            @endif
            <div class="">
                <div class="form-group">
                    <strong>Entregue para:</strong>
                    {{ $ordem->entregue_para && $ordem->retirada ? $ordem->entregue_para . ' em ' . date('d/m/Y', strtotime($ordem->retirada)) : 'Não entregue' }}
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="">
                <div class="form-group">
                    <strong>Observação:</strong>
                    <div style="white-space: pre-wrap;">{{ $empresa->observacao }}</div>
                </div>
            </div>
        </div>
        <div class="dotted">
            <div class="row mt-1">
                <div class="pull-left d-flex justify-content-center">
                    <h2>OS Nº {{ $ordem->id }}</h2>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="">
                    <div class="form-group">
                        <strong>Status:</strong>
                        {{ $ordem->status->descricao }}
                    </div>
                </div>
                <div class="">
                    <div class="form-group">
                        <strong>Entrada:</strong>
                        {{ date('d/m/Y', strtotime($ordem->entrada)) }}
                    </div>
                </div>
                <div class="">
                    <div class="form-group">
                        <strong>Cliente:</strong>
                        {{ $ordem->cliente->nome }}
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="">
                    <div class="form-group">
                        <strong>Marca:</strong>
                        {{ $ordem->marca->descricao }}
                    </div>
                </div>
                <div class="">
                    <div class="form-group">
                        <strong>Modelo:</strong>
                        {{ $ordem->modelo }}
                    </div>
                </div>
                <div class="">
                    <div class="form-group">
                        <strong>Tipo do Aparelho:</strong>
                        {{ $ordem->tipo_aparelho }}
                    </div>
                </div>
                <div class="">
                    <div class="form-group">
                        <strong>Estado do Aparelho:</strong>
                        {{ $ordem->estado_aparelho }}
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="">
                    <div class="form-group">
                        <strong>Defeito Alegado:</strong>
                        <div style="white-space: pre-wrap;">{{ $ordem->defeito_alegado }}</div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="">
                    <div class="form-group">
                        <strong>Acessórios:</strong>
                        <div style="white-space: pre-wrap;">{{ $ordem->acessorios ?  $ordem->acessorios : 'Nenhum'}}</div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="">
                    <div class="form-group">
                        <strong>Laudo Técnico:</strong>
                        <div style="white-space: pre-wrap;">{{ $ordem->laudo_tecnico }}</div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between flex-wrap">
                <div class="">
                    <div class="form-group">
                        <strong>Valor do Serviço:</strong>
                        {{ $ordem->valor_servico ? "R$ " . $ordem->valor_servico /* number_format($ordem->valor_servico,2,',','.') */ : 'Não orçado' }}
                    </div>
                </div>
                @if ($ordem->status_id == 4 || $ordem->status_id == 5)
                <div class="">
                    <div class="form-group">
                        <strong>Garantia:</strong>
                        {{ $empresa->garantia ? $empresa->garantia . " Dias" : "Não lançado"}}
                    </div>
                </div>
                @endif
                <div class="">
                    <div class="form-group">
                        <strong>Entregue para:</strong>
                        {{ $ordem->entregue_para && $ordem->retirada ? $ordem->entregue_para . ' em ' . date('d/m/Y', strtotime($ordem->retirada)) : 'Não entregue' }}
                    </div>
                </div>
            </div>
             <div class="d-flex justify-content-between">
                <div class="">
                    <div class="form-group">
                        <p class="fs-2 text">Eu ______________________________________ declaro estar retirando o aparelho nas condições acima citadas nesta data: ____/____/____.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (isset($print))
        <script type="text/javascript">
            window.print();
        </script>
    @endif
    <script>
        $(document).ready(function() {
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
                modalBodyForm.action = `<?php echo env('APP_URL'); ?>/ordens/${id}`
            })

        });

        function imprimir() {
            window.print();
        }
    </script>
@endsection
