<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
    <style>
        .body {
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr class="body" style="text-align: center;">
            <td>Dados da Ordem de Serviço</td>
        </tr>
        <tr>
            <td>Dados Cadastrados:</td>
        </tr>
        <tr>
            <td>Entrada: {{ date('d/m/Y', strtotime($ordem->entrada)) }}</td>
        </tr>
        <tr>
            <td>Cliente: {{ $ordem->cliente->nome }}</td>
        </tr>
        <tr>
            <td>Tipo de Aparelho: {{ $ordem->tipo_aparelho }} </td>
        </tr>
        <tr>
            <td>Marca: {{ $ordem->marca->descricao }} </td>
        </tr>
        <tr>
            <td>Modelo {{ $ordem->modelo }}</td>
        </tr>
        <tr>
            <td>Estado do Aparelho {{ $ordem->estado_aparelho }}</td>
        </tr>
        <tr>
            <td>Defeito Alegado {{ $ordem->defeito_alegado }}</td>
        </tr>
        <tr>
            <td>Acessórios: {{ $ordem->acessorios ? $ordem->acessorios : 'Sem acessórios'}}</td>
        </tr>
        <tr>
            <td>Valor do Serviço: {{ $ordem->valor_servico ? $ordem->valor_servico : 'Ainda não Orçado'}}</td>
        </tr>
        @if($ordem->laudo_tecnico)
            <tr>
                <td>Laudo Técnico: {{ $ordem->laudo_tecnico }} </td>
            </tr>
        @endif
        <tr>
            <td>Status {{ $ordem->status->descricao }}</td>
        </tr>
        @if($ordem->retirada)
            <tr>
                <td>Retirada: {{ date('d/m/Y', strtotime($ordem->retirada)) }}</td>
            </tr>
            <tr>
                <td>Entregue para: {{ $ordem->entregue_para }} </td>
            </tr>
        @endif
    </table>
</body>

</html>
