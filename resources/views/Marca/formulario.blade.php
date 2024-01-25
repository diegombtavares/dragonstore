@extends('TemplateAdmin.index')

@section('contents')

@php
    $titulo = "Inclusão de uma nova marca";
    $endpoint = "/marca/novo";
    $input_nome = "";
    $input_fantasia = "";
    $input_id = "";
    $input_situacao = "";

    if (isset($marca)) {
        $titulo = "Alteração de marca";
        $endpoint = "/marca/update";
        $input_nome = $marca['nome'];
        $input_fantasia = $marca['nome_fantasia'];
        $input_id = $marca["id"];
        $input_situacao = $marca["situacao"];
    }
@endphp

<h1 class="h3 mb-4 text-gray-800">{{$titulo}}</h1>
<div class="card">
    <div class="card-header">
        Cadastro de Marca
    </div>
    <div class="card-body">
        <form method="POST" action="{{$endpoint}}">
            @CSRF
            <input type="hidden" name="id" value="{{$input_id}}">

            <label class="form-label">Nome da marca</label>
            <input class="form-control" name="nome" placeholder="Nome" value="{{$input_nome}}">

            <label class="form-label">Nome fantasia</label>
            <input class="form-control" name="nome_fantasia" placeholder="Fantasia" value="{{$input_fantasia}}">

            <label class="form-label">Situação</label>
            <select class="form-control" name="situacao">
                <option value="1" {{ $input_situacao == 1 ? 'selected' : '' }} >ATIVO</option>
                <option value="0" {{ $input_situacao == 0 ? 'selected' : '' }} >INATIVO</option>
            </select>

            <br/>
            <input type="submit" class="btn btn-success" value="SALVAR"/>
        </form>
    </div>
</div>
@endsection
