<?php

namespace EldoMagan\BagistoArcade\Actions;

use Illuminate\Support\Facades\Http;

class AddProductToCart
{
    public function execute($product, $quantity)
    {
        $this->response = Http::post(route('cart.add', $this->product->product_id), [
            'product_id' => $product->product_id,
            'quantity' => $quantity,
        ]);
    }
}
