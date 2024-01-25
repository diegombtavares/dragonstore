@extends('TemplateAdmin.index')

@section('contents')

@php
    $titulo = "Inclusão de uma nova cor";
    $endpoint = "/cor/novo";
    $input_cor = "";
    $input_fantasia = "";
    $input_id = "";
    $input_situacao = "";

    if (isset($cor)) {
        $titulo = "Alteração de cor";
        $endpoint = "/cor/update";
        $input_cor = $cor['cor'];
        $input_id = $cor["id"];
        $input_situacao = $cor["situacao"];
    }
@endphp

<h1 class="h3 mb-4 text-gray-800">{{$titulo}}</h1>
<div class="card">
    <div class="card-header">
        Criar nova cor
    </div>
    <div class="card-body">
        <form method="POST" action="{{$endpoint}}">
            @CSRF
            <input type="hidden" name="id" value="{{$input_id}}">

            <label class="form-label">Nome da cor</label>
            <input class="form-control" name="cor" placeholder="Cor" value="{{$input_cor}}">

            <label class="form-label">Situação</label>
            <select class="form-control" name="situacao">
                <option value="1" {{ $input_situacao == 1 ? 'selected' : '' }}>ATIVO</option>
                <option value="0" {{ $input_situacao == 0 ? 'selected' : '' }}>INATIVO</option>
            </select>

            <br/>
            <input type="submit" class="btn btn-success" value="SALVAR"/>
        </form>
    </div>
</div>
@endsection
