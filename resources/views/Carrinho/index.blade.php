@extends('TemplateLoja.index')

@section('contents')

<style>
    /* Adicione este estilo para criar espaço entre os produtos no carrinho */
    .list-group-item {
        margin-bottom: 15px;
    }
</style>

<div class="container">
    <h1 class="my-4">Carrinho de Compras</h1>

    <div class="row">
        <div class="col-md-8">
            @php
            $subtotal = 0;
            @endphp

            @if ($carrinho->isEmpty())
            <div class="alert alert-info">
                Seu carrinho está vazio.
            </div>
            @else
            <ul class="list-group">
                @foreach($carrinho as $produto)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-2">
                            @php
                            $imagemPath = '';
                            switch ($produto->nome) {
                                case 'Iphone 15':
                                $imagemPath = asset('img/celular.png');
                                break;
                                case 'Sansung S23':
                                $imagemPath = asset('img/samsung.png');
                                break;
                                case 'Redmi Note 12 Pro':
                                $imagemPath = asset('img/xiomi.png');
                                break;
                                case 'Zenfone 7':
                                $imagemPath = asset('img/asus.png');
                                break;
                                // Adicione mais casos para outros nomes de produtos, se necessário
                                default:
                                $imagemPath = asset('img/default.png'); // Imagem padrão se não houver correspondência
                                break;
                            }
                            @endphp
                            <img src="{{ $imagemPath }}" alt="Imagem do produto" class="img-thumbnail" width="100">
                        </div>
                        <div class="col-md-6">
                            <h5>{{ $produto->nome }}</h5>
                            <p>Preço unitário: {{ $produto->preco }}</p>
                            <p>Quantidade: 1</p>
                        </div>
                        <div class="col-md-4">
                            <form id="form-excluir-{{ $produto->id }}" action="{{ route('carrinho.excluir', ['id' => $produto->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger float-right" onclick="excluirProduto({{ $produto->id }})">Excluir</button>
                            </form>
                        </div>
                    </div>
                </li>
                @php
                $subtotal += $produto->preco;
                @endphp
                @endforeach
            </ul>
            <form id="form-limpar-carrinho" action="{{ route('carrinho.limpar') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-warning" onclick="limparCarrinho()">Limpar carrinho</button>
            </form>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Resumo do Pedido</h5>
                    <p class="card-text">Total de itens: {{ count($carrinho) }}</p>
                    <p class="card-text">Subtotal: R$ {{ number_format($subtotal, 2, ',', '.') }}</p>
                    <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#finalizarCompraModal">Finalizar compra</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="finalizarCompraModal" tabindex="-1" role="dialog" aria-labelledby="finalizarCompraModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="finalizarCompraModalLabel">Finalizar Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($carrinho->isEmpty())
                    <p>Seu carrinho está vazio.</p>
                @else
                    <form method="POST" action="{{ route('carrinho.concluir-compra') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nome">Nome:</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
                        </div>

                        <ul class="list-group" style="max-height: 200px; overflow-y: auto;">
                            @foreach($carrinho as $produto)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $produto->nome }}</span>
                                    <span class="badge badge-primary badge-pill">R$ {{ $produto->preco }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="form-group mt-3">
                            <label for="total">Total da Compra:</label>
                            <p class="lead">R$ {{ number_format($subtotal, 2, ',', '.') }}</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary" onclick="exibirMensagemCompraConcluida()">Concluir Compra</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function excluirProduto(id) {
        Swal.fire({
            title: 'Tem certeza?',
            text: 'Você deseja excluir este produto do carrinho?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-excluir-' + id).submit();
            }
        });
    }

    function limparCarrinho() {
        Swal.fire({
            title: 'Tem certeza?',
            text: 'Você deseja limpar todo o carrinho?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, limpar!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-limpar-carrinho').submit();
            }
        });
    }

    // Adicione esta função para exibir a mensagem de sucesso após a conclusão da compra
    function exibirMensagemCompraConcluida() {
        Swal.fire({
            title: 'Compra Concluída!',
            text: 'Sua compra foi realizada com sucesso!',
            icon: 'success'
        });
    }
</script>
@endsection
