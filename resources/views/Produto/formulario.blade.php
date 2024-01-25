@extends('TemplateAdmin.index')

@section('contents')

@php
    $titulo = "Inclusão de um novo produto";
    $endpoint = "/produto/novo";
    $input_nome = "";
    $input_preco = "";
    $input_quantidade = "";
    $input_descricao = "";
    $input_id_categoria = "";
    $input_id_cor = "";
    $input_id_marca = "";
    $input_id = "";

    if (isset($produto)) {
        $titulo = "Alteração de produto";
        $endpoint = "/produto/update";
        $input_nome = $produto['nome'];
        $input_preco = $produto['preco'];
        $input_quantidade = $produto['quantidade'];
        $input_descricao = $produto['descricao'];
        $input_id_categoria = $produto['id_categoria'];
        $input_id_cor = $produto['id_cor'];
        $input_id_marca = $produto['id_marca'];
        $input_id = $produto["id"];
    }
@endphp

<h1 class="h3 mb-4 text-gray-800">{{$titulo}}</h1>
<div class="card">
    <div class="card-header">
        Criar novo produto
    </div>
    <div class="card-body">
        <form method="POST" action="{{$endpoint}}">
            @CSRF
            <input type="hidden" name="id" value="{{$input_id}}">

            <label class="form-label">Nome</label>
            <input class="form-control" name="nome" placeholder="Nome" value="{{$input_nome}}">

            <label class="form-label">Preço</label>
            <input class="form-control" name="preco" placeholder="Preço" value="{{$input_preco}}">

            <label class="form-label">Quantidade</label>
            <input class="form-control" name="quantidade" placeholder="Quantidade" value="{{$input_quantidade}}">

            <label class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" placeholder="Descrição">{{$input_descricao}}</textarea>

            <label class="form-label">Categoria</label>
            <select class="form-control" name="id_categoria">
                @foreach ($categorias as $dado)
                    <option value="{{$dado['id']}}" {{$input_id_categoria == $dado['id'] ? 'selected' : ''}}>{{$dado['nome']}}</option>
                @endforeach
            </select>

            <label class="form-label">Cor</label>
            <select class="form-control" name="id_cor">
                @foreach ($cores as $dado)
                    <option value="{{$dado['id']}}" {{$input_id_cor == $dado['id'] ? 'selected' : ''}}>{{$dado['cor']}}</option>
                @endforeach
            </select>

            <label class="form-label">Marca</label>
            <select class="form-control" name="id_marca">
                @foreach ($marcas as $dado)
                    <option value="{{$dado['id']}}" {{$input_id_marca == $dado['id'] ? 'selected' : ''}}>{{$dado['nome']}}</option>
                @endforeach
            </select>

            <br/>
            <input type="submit" class="btn btn-success" value="SALVAR"/>
        </form>
    </div>
</div>

<script>
    ClassicEditor
        .create(document.querySelector('#descricao'))
        .catch(error => {
            console.error(error);
        });
</script>

@endsection
