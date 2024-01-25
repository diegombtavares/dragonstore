<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Produto;
use App\Models\Pedido;

class CarrinhoController extends Controller
{
    public function index()
    {
        $carrinho = Session::get('carrinho', []);

        // Obter apenas os IDs dos produtos no carrinho
        $produtoIds = array_column($carrinho, 'id');

        $produtosNoCarrinho = Produto::whereIn('id', $produtoIds)->get();

        return view('Carrinho.index', ['carrinho' => $produtosNoCarrinho]);
    }

    public function adicionar(Request $request, $id)
    {
        $quantidade = $request->input('quantidade', 1);

        $produto = Produto::find($id);

        if (!$produto) {
            return redirect('/')->with('error', 'Produto não encontrado.');
        }

        $carrinho = Session::get('carrinho', []);

        $produtoIndex = array_search($id, array_column($carrinho, 'id'));

        if ($produtoIndex === false) {
            $carrinho[] = [
                'id' => $id,
                'quantidade' => $quantidade,
                'preco' => $produto->preco,
            ];
        } else {
            $carrinho[$produtoIndex]['quantidade'] += $quantidade;
        }

        Session::put('carrinho', $carrinho);

        return redirect('/carrinho');
    }

    public function excluirItem($id)
    {
        $carrinho = Session::get('carrinho', []);

        if (($key = array_search($id, array_column($carrinho, 'id'))) !== false) {
            unset($carrinho[$key]);
            Session::put('carrinho', $carrinho);
        }

        return redirect('/carrinho');
    }

    public function limpar()
    {
        Session::forget('carrinho');
        return redirect('/carrinho');
    }

    public function concluirCompra(Request $request)
    {
        $carrinho = Session::get('carrinho', []);

        // Verifique se o carrinho não está vazio
        if (empty($carrinho)) {
            return redirect('/carrinho')->with('error', 'Seu carrinho está vazio.');
        }

        $subtotal = 0;
        $produtoIds = [];
        $quantidades = [];

        foreach ($carrinho as $produto) {
            $subtotal += $produto['preco'] * $produto['quantidade'];
            $produtoIds[] = $produto['id'];
            $quantidades[] = $produto['quantidade'];
        }

        $pedido = new Pedido();
        $pedido->nome_cliente = $request->input('nome');
        $pedido->email_cliente = $request->input('email');
        $pedido->total = $subtotal;
        $pedido->produto_ids = json_encode($produtoIds);
        $pedido->quantidades = json_encode($quantidades);
        $pedido->save();

        // Limpe o carrinho após a conclusão da compra
        Session::forget('carrinho');

        return redirect('/carrinho')->with('success', 'Compra concluída com sucesso!');
    }

}
