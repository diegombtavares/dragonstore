<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Cor;
use App\Models\Marca;

class ProdutoController extends Controller
{
    public function index()
    {
        //$dados = Produto::all()->toArray();
        $dados = Produto::select(
                                    "produto.id",
                                    "produto.nome",
                                    "produto.quantidade",
                                    "produto.preco",
                                    "produto.descricao",
                                    "categoria.nome AS categoriaNome",
                                    "cor.cor AS corNome",
                                    "marca.nome AS marcaNome")
                    ->join("categoria", "categoria.id", "=", "produto.id_categoria")
                    ->join("cor", "cor.id", "=", "produto.id_cor")
                    ->join("marca", "marca.id", "=", "produto.id_marca")
                    ->get();
        return View("Produto.index",
                [
                    'produtos'=>$dados
                ]
        );
    }

    public function inserir()
    {
        $categorias = Categoria::all()->toArray();
        $cores = Cor::all()->toArray();
        $marcas = Marca::all()->toArray();
        return view("Produto.formulario", ['categorias'=>$categorias, 'cores'=>$cores, 'marcas'=>$marcas]);
    }

    public function salvar_novo(Request $request)
    {
        $produto = new Produto;
        $produto->nome = $request->input("nome");
        $produto->id_categoria = $request->input("id_categoria");
        $produto->id_cor = $request->input("id_cor");
        $produto->id_marca = $request->input("id_marca");
        $produto->preco = $request->input("preco");
        $produto->quantidade = $request->input("quantidade");
        $produto->descricao = $request->input("descricao");
        $produto->save();
        return redirect("/produto");
    }

    public function excluir($id)
    {
        $produto = Produto::find($id);
        $produto->delete();
        return redirect("/produto");
    }

    public function alterar($id)
    {
        $produto = Produto::find($id)->toArray();
        $categorias = Categoria::all()->toArray();
        $cores = Cor::all()->toArray();
        $marcas = Marca::all()->toArray();
        return view("Produto.formulario", ['produto'=>$produto, 'categorias'=>$categorias, 'cores'=>$cores, 'marcas'=>$marcas]);
    }

    public function salvar_update(Request $request)
    {
        $id = $request->input("id");
        $produto = Produto::find($id);
        $produto->nome = $request->input("nome");
        $produto->id_categoria = $request->input("id_categoria");
        $produto->id_cor = $request->input("id_cor");
        $produto->id_marca = $request->input("id_marca");
        $produto->preco = $request->input("preco");
        $produto->quantidade = $request->input("quantidade");
        $produto->descricao = $request->input("descricao");
        $produto->save();
        return redirect("/produto");
    }
}
