<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoController extends Controller
{
    public function historico()
    {
        $pedidos = Pedido::all(); // ou qualquer lógica para obter os pedidos

        return view('Historico.index', ['pedidos' => $pedidos]);
    }
}
