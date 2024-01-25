@extends('TemplateAdmin.index')

@section('contents')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-shopping-cart fa-lg text-black"></i> MarketPlace
    </h1>
    <div class="card">
        <div class="card-header">
            Lista de produtos
        </div>
        <div class="card-body">
            <a href='/categoria/novo' class="btn btn-success">
                Comprar
            </a>
            <a href='/categoria/novo' class="btn btn-danger">
                Limpar
            </a>
            <br></br>

            <table class="table table-bordered dataTable">
                <thead>
                    <td>Produto</td>
                    <td>Preço</td>
                    <td>Quantidade</td>
                </thead>
                <tbody>

                    @foreach($categorias as $linha)
                        <tr>
                            <td class="{{ $linha['situacao'] == 0 ? 'text-danger' : '' }}">{{$linha['id']}}</td>
                            <td class="{{ $linha['situacao'] == 0 ? 'text-danger' : '' }}">{{$linha['nome']}}</td>
                            <td>
                                <a href="/categoria/update/{{$linha['id']}}" class="btn btn-success">
                                    <li class="fa fa-edit"></li>
                                </a>
                                <a href="/categoria/excluir/{{$linha['id']}}" class="btn btn-danger">
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
