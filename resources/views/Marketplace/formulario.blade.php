@extends('TemplateAdmin.index')

@section('contents')

@php
    $titulo = "Inclusão de uma nova categoria";
    $endpoint = "/categoria/novo";
    $input_nome = "";
    $input_id = "";
    $input_situacao = "";

    if (isset($categoria)) {
        $titulo = "Alteração de categoria";
        $endpoint = "/categoria/update";
        $input_nome = $categoria['nome'];
        $input_id = $categoria["id"];
        $input_situacao = $categoria["situacao"];
    }
@endphp

<h1 class="h3 mb-4 text-gray-800">{{$titulo}}</h1>
<div class="card">
    <div class="card-header">
        Criar nova categoria
    </div>
    <div class="card-body">
        <form method="POST" action="{{$endpoint}}">
            @CSRF
            <input type="hidden" name="id" value="{{$input_id}}">

            <label class="form-label">Nome da categoria</label>
            <input class="form-control" name="nome" placeholder="Nome" value="{{$input_nome}}">

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
