<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;

class CartCounter extends Component
{
    /**
     * This listener is the "magic" part. 
     * Whenever any other component (like the Checkout or AddToCart button) 
     * says 'cartUpdated', this specific component will re-run its render 
     * function to show the new number.
     */
    protected $listeners = ['cartUpdated' => '$refresh'];

    public function render(CartService $cart)
    {
        return view('livewire.cart-counter', [
            // We use the service to get the sum of all items in the session
            'count' => $cart->getCount()
        ]);
    }
}