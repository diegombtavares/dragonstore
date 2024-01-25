<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;

class MarcaController extends Controller
{
    public function index()
    {
        $dados = Marca::all()->toArray();
        return View("Marca.index",
                [
                    'marcas'=>$dados
                ]
        );
    }

    public function inserir()
    {
        return View("Marca.formulario");
    }

    public function salvar_novo(Request $request)
    {
        $marca = new Marca;
        $marca->nome = $request -> input("nome");
        $marca->nome_fantasia = $request->input("nome_fantasia");
        $marca->situacao = $request->input("situacao");
        $marca->save();
        return redirect("/marca");
    }

    public function excluir($id)
    {
        $marca = Marca::find($id);
        $marca->delete();
        return redirect("/marca");
    }

    public function alterar($id)
    {
        $marca = Marca::find($id)->toArray();
        return View("Marca.formulario", ['marca'=>$marca]);
    }

    public function salvar_update(Request $request)
    {
        $id = $request->input("id");
        $marca = Marca::find($id);
        $marca->nome = $request->input("nome");
        $marca->nome_fantasia = $request->input("nome_fantasia");
        $marca->situacao = $request->input("situacao");
        $marca->save();
        return redirect("/marca");
    }
}
