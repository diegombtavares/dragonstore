<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CorController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\LojaController;
use App\Http\Controllers\PedidoController;


Route::group(['prefix'=>'produto'], function() {
    Route::get('/', [ProdutoController::class, 'index']);
    Route::get('/novo', [ProdutoController::class, 'inserir']);
    Route::post('/novo', [ProdutoController::class, 'salvar_novo']);
    Route::get('/excluir/{id}', [ProdutoController::class, 'excluir']);
    Route::get('/update/{id}', [ProdutoController::class, 'alterar']);
    Route::post('/update', [ProdutoController::class, 'salvar_update']);
});

Route::get('/', [ProdutoController::class, 'index']);

Route::group(['prefix'=>'marca'], function() {
    Route::get('/', [MarcaController::class, 'index']);
    Route::get('/novo', [MarcaController::class, 'inserir']);
    Route::post('/novo', [MarcaController::class, 'salvar_novo']);
    Route::get('/excluir/{id}', [MarcaController::class, 'excluir']);
    Route::get('/update/{id}', [MarcaController::class, 'alterar']);
    Route::post('/update', [MarcaController::class, 'salvar_update']);
});

Route::get('/marca', [MarcaController::class, 'index']);

Route::group(['prefix'=>'categoria'], function() {
    Route::get('/', [CategoriaController::class, 'index']);
    Route::get('/novo', [CategoriaController::class, 'inserir']);
    Route::post('/novo', [CategoriaController::class, 'salvar_novo']);
    Route::get('/excluir/{id}', [CategoriaController::class, 'excluir']);
    Route::get('/update/{id}', [CategoriaController::class, 'alterar']);
    Route::post('/update', [CategoriaController::class, 'salvar_update']);
});

Route::get('/categoria', [CategoriaController::class, 'index']);

Route::group(['prefix'=>'cor'], function() {
    Route::get('/', [CorController::class, 'index']);
    Route::get('/novo', [CorController::class, 'inserir']);
    Route::post('/novo', [CorController::class, 'salvar_novo']);
    Route::get('/excluir/{id}', [CorController::class, 'excluir']);
    Route::get('/update/{id}', [CorController::class, 'alterar']);
    Route::post('/update', [CorController::class, 'salvar_update']);
});

Route::get('/cor', [CorController::class, 'index']);

Route::get('/carrinho', [CarrinhoController::class, 'index']);

Route::get('/marketplace', [MarketplaceController::class, 'mostrarProdutos'])->name('marketplace.mostrar');

Route::get('/loja', [LojaController::class, 'index'])->name('loja.index');
Route::get('/loja/filtrar', [LojaController::class, 'index'])->name('loja.filtrar');

Route::post('/carrinho/adicionar/{id}', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');
Route::delete('/carrinho/excluir/{id}', [CarrinhoController::class, 'excluirItem'])->name('carrinho.excluir');
Route::delete('/carrinho/limpar', [CarrinhoController::class, 'limpar'])->name('carrinho.limpar');
Route::post('/carrinho/concluir-compra', [CarrinhoController::class, 'concluirCompra'])->name('carrinho.concluir-compra');

Route::get('/historico-pedidos', [PedidoController::class, 'historico']);


?>
