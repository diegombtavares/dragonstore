@extends('TemplateAdmin.index')

@section('contents')
    <h1 class="h3 mb-4 text-gray-800">Cadastro de produtos</h1>

    <div class="card">
        <div class="card-header">
            Lista de produtos
        </div>
        <div class="card-body">
            <a href='/produto/novo' class="btn btn-success">
                Novo
            </a>

            <table class="table table-bordered dataTable">
                <thead>
                    <td>ID</td>
                    <td>Nome</td>
                    <td>Marca</td>
                    <td>Categoria</td>
                    <td>Preço</td>
                    <td>Quantidade</td>
                    <td>Cor</td>
                    <td>Descrição</td>
                    <td>Opções</td>
                </thead>
                <tbody>

                    @foreach($produtos as $linha)
                        <tr>
                            <td>{{$linha['id']}}</td>
                            <td>{{$linha['nome']}}</td>
                            <td>{{$linha['marcaNome']}}</td>
                            <td>{{$linha['categoriaNome']}}</td>
                            <td>{{$linha['preco']}}</td>
                            <td>{{$linha['quantidade']}}</td>
                            <td>{{$linha['corNome']}}</td>
                            <td>{!!$linha['descricao']!!}</td>
                            <td>
                                <a href="/produto/update/{{$linha['id']}}" class="btn btn-success">
                                    <li class="fa fa-edit"></li>
                                </a>
                                <a href="/produto/excluir/{{$linha['id']}}" class="btn btn-danger">
                                    <li class="fa fa-trash"></li>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
