<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Cor;
use App\Models\Marca;

class LojaController extends Controller
{
    public function index(Request $request)
    {
        // Obter todos os produtos
        $query = Produto::select(
            "produto.id",
            "produto.nome",
            "produto.quantidade",
            "produto.preco",
            "produto.descricao",
            "categoria.nome AS categoriaNome",
            "cor.cor AS corNome",
            "marca.nome AS marcaNome"
        )
        ->join("categoria", "categoria.id", "=", "produto.id_categoria")
        ->join("cor", "cor.id", "=", "produto.id_cor")
        ->join("marca", "marca.id", "=", "produto.id_marca");

        // Filtro com base nas seleções
        if ($request->filled('id_categoria')) {
            $query->where('produto.id_categoria', $request->input('id_categoria'));
        }

        if ($request->filled('id_marca')) {
            $query->where('produto.id_marca', $request->input('id_marca'));
        }

        if ($request->filled('id_cor')) {
            $query->where('produto.id_cor', $request->input('id_cor'));
        }

        $dados = $query->get();

        // Obter todas as categorias, marcas e cores
        $categorias = Categoria::all();
        $marcas = Marca::all();
        $cores = Cor::all();

        return view("Loja.index", [
            'lojas' => $dados,
            'categorias' => $categorias,
            'marcas' => $marcas,
            'cores' => $cores,
        ]);
    }
}
