<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class CartService
{
    public function add($productId)
    {
        // Get the current cart from the session, or an empty array if it doesn't exist
        $cart = Session::get('cart', []);
        
        // If product is already in bag, increase quantity, otherwise add new with quantity 1
        if (isset($cart[$productId])) {
            $cart[$productId]++;
        } else {
            $cart[$productId] = 1;
        }

        // Save the updated cart back to the session
        Session::put('cart', $cart);
    }

    public function getCount()
    {
        // Total up all the quantities in the bag
        return array_sum(Session::get('cart', []));
    }

    public function clear()
    {
        Session::forget('cart');
    }
}