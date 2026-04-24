<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;

class AddToCartButton extends Component
{
    public $productId;

    public function addToCart(CartService $cart)
    {
        $cart->add($this->productId);
        $this->dispatch('cartUpdated'); // Tells the Bag counter to refresh
    }

    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}