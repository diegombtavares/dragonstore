<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = ['nome_cliente', 'email_cliente', 'total'];

    public function itensPedido()
    {
        return $this->hasMany(ItemPedido::class);
    }

    public function getSubtotalAttribute()
    {
        $subtotal = 0;

        foreach ($this->itensPedido as $item) {
            $subtotal += $item->preco_unitario * $item->quantidade;
        }

        return $subtotal;
    }

    // Exemplo de método para obter a lista de produtos no pedido
    public function getProdutosAttribute()
    {
        return $this->itensPedido->pluck('produto.nome')->toArray();
    }
}
