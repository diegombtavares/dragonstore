@extends('TemplateLoja.index')

@section('contents')

<h1 class="h3 mb-4 text-gray-800">MarketPlace</h1>

<form method="GET" action="{{ route('loja.filtrar') }}">
    <div class="row mb-4">
        <!-- Caixa de seleção para Categoria -->
        <div class="col-md-4">
            <label for="id_categoria">Categoria:</label>
            <select class="form-control" id="id_categoria" name="id_categoria">
                <option value="">Todas as categorias</option>
                @foreach($categorias as $dado)
                    <option value="{{$dado['id']}}" @if(request('id_categoria') == $dado['id']) selected @endif>{{$dado['nome']}}</option>
                @endforeach
            </select>
        </div>

        <!-- Caixa de seleção para Marca -->
        <div class="col-md-4">
            <label for="id_marca">Marca:</label>
            <select class="form-control" id="id_marca" name="id_marca">
                <option value="">Todas as marcas</option>
                @foreach($marcas as $dado)
                    <option value="{{$dado['id']}}" @if(request('id_marca') == $dado['id']) selected @endif>{{$dado['nome']}}</option>
                @endforeach
            </select>
        </div>

        <!-- Caixa de seleção para Cor -->
        <div class="col-md-4">
            <label for="id_cor">Cor:</label>
            <select class="form-control" id="id_cor" name="id_cor">
                <option value="">Todas as cores</option>
                @foreach($cores as $dado)
                    <option value="{{$dado['id']}}" @if(request('id_cor') == $dado['id']) selected @endif>{{$dado['cor']}}</option>
                @endforeach
            </select>
        </div>

        <!-- Botões de Filtrar e Limpar Filtros -->
        <div class="col-md-12 mt-2">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('loja.index') }}" class="btn btn-secondary">Limpar Filtro</a>
        </div>
    </div>
</form>

<div class="card col-md-12">
    <div class="card-header">
        Produtos disponíveis
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($lojas as $linha)
                <div class="col-md-3 mb-3">
                    <div class="card produto-card" style="border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease-in-out;">
                        @if($linha['marcaNome'] == 'Apple')
                            <img src="{{ asset('img/celular.png') }}" class="card-img-top" width="200">
                        @elseif ($linha['marcaNome'] == 'Sansung')
                            <img src="{{ asset('img/samsung.png') }}" class="card-img-top" width="200">
                        @elseif ($linha['marcaNome'] == 'Xiomi')
                            <img src="{{ asset('img/xiomi.png') }}" class="card-img-top" width="200">
                        @elseif ($linha['marcaNome'] == 'Asus')
                            <img src="{{ asset('img/asus.png') }}" class="card-img-top" width="200">
                        @endif
                        <div class="card-body text-left">
                            <h5 class="card-title">{{$linha['nome']}}</h5>
                            <p class="card-text">{!!$linha['descricao']!!}</p>
                            <p class="card-text">Marca: {{$linha['marcaNome']}}</p>
                            <p class="card-text">Categoria: {{$linha['categoriaNome']}}</p>
                            <p class="card-text">Preço: {{$linha['preco']}}</p>
                            <p class="card-text">Estoque: {{$linha['quantidade']}}</p>
                            <p class="card-text">Cor: {{$linha['corNome']}}</p>
                            <p class="card-text">Quantidade: {{$linha['quantidade']}}</p> <!-- Adicionando a linha para exibir a quantidade -->
                            <form id="adicionarAoCarrinhoForm{{$linha['id']}}" action="{{ route('carrinho.adicionar', ['id' => $linha['id']]) }}" method="POST">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="quantidade" placeholder="Quantidade" min="1" max="{{$linha['quantidade']}}" value="1">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-warning" onclick="adicionarAoCarrinho({{$linha['id']}}, '{{$linha['nome']}}', {{$linha['quantidade']}}, $('#quantidadeSelecionada{{$linha['id']}}').val())">Adicionar ao carrinho</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
 function adicionarAoCarrinho(produtoId, nomeProduto, quantidadeDisponivel) {
    var quantidadeInput = $('#adicionarAoCarrinhoForm' + produtoId + ' input[name="quantidade"]');
    var quantidade = parseInt(quantidadeInput.val());

    if (isNaN(quantidade) || quantidade <= 0 || quantidade > quantidadeDisponivel) {
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: 'A quantidade selecionada deve ser maior que 0 e no máximo igual ao estoque disponível.',
            showConfirmButton: false,
            timer: 1500
        });
        quantidadeInput.val(1); // Define a quantidade de volta para 1 em caso de erro
        return;
    }

    $.ajax({
        url: $('#adicionarAoCarrinhoForm' + produtoId).attr('action'),
        method: 'POST',
        data: $('#adicionarAoCarrinhoForm' + produtoId).serialize(),
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Produto Adicionado!',
                text: nomeProduto + ' foi adicionado ao carrinho. Quantidade: ' + quantidade,
                showConfirmButton: false,
                timer: 1500
            });
        },
        error: function(error) {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'Ocorreu um erro ao adicionar o produto ao carrinho.',
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}
</script>

<style>
    .produto-card:hover {
        transform: scale(1.05);
    }

    .produto-card .card-img-top {
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .produto-card .card-body {
        padding: 15px;
    }

    .produto-card .card-title {
        font-size: 18px;
        font-weight: bold;
    }

    .produto-card .card-text {
        font-size: 14px;
        color: #555;
    }

    .produto-card .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #333;
    }

    .produto-card .btn-warning:hover {
        background-color: #ffca2c;
        border-color: #ffca2c;
        color: #333;
    }
</style>

@endsection
