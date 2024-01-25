@extends('TemplateAdmin.index')

@section('contents')
    <div class="container mt-5">
        <h1 class="mb-4">Histórico de Pedidos</h1>

        <ul class="list-group">
            @foreach ($pedidos as $pedido)
                <li class="list-group-item mb-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-1">Pedido #{{ $pedido->id }}</h5>
                            <p class="mb-1">Cliente: {{ $pedido->nome_cliente }}</p>
                            <p class="mb-1">Email: {{ $pedido->email_cliente }}</p>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detalhesPedido{{ $pedido->id }}">
                            Detalhes
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="detalhesPedido{{ $pedido->id }}" tabindex="-1" role="dialog" aria-labelledby="detalhesPedido{{ $pedido->id }}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detalhesPedido{{ $pedido->id }}Label">Detalhes do Pedido #{{ $pedido->id }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>ID do Pedido:</strong> {{ $pedido->id }}</p>
                                    <p><strong>Nome do Cliente:</strong> {{ $pedido->nome_cliente }}</p>
                                    <p><strong>Email do Cliente:</strong> {{ $pedido->email_cliente }}</p>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Produto</th>
                                                <th scope="col">Quantidade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(json_decode($pedido->produto_ids) as $key => $produtoId)
                                                <tr>
                                                    <td>{{ \App\Models\Produto::find($produtoId)->nome }}</td>
                                                    <td>{{ json_decode($pedido->quantidades)[$key] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <p><strong>Total do Pedido:</strong> R$ {{ number_format($pedido->total, 2, ',', '.') }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
