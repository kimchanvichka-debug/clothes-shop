<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem; // Make sure to import this
use Livewire\WithFileUploads;

class Checkout extends Component
{
    use WithFileUploads;

    public $name, $phone, $address, $screenshot;

    protected $listeners = ['cartUpdated' => '$refresh'];

    public function incrementQuantity($productId, CartService $cart)
    {
        $cart->add($productId);
        $this->dispatch('cartUpdated'); 
    }

    public function decrementQuantity($productId, CartService $cart)
    {
        $cart->remove($productId);
        $this->dispatch('cartUpdated');
    }

    public function removeItem($productId, CartService $cart)
    {
        $cart->clearItem($productId);
        $this->dispatch('cartUpdated');
    }

    private function getTotal()
    {
        $cartItems = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cartItems))->get();
        
        $total = 0;
        foreach($products as $product) {
            $total += $product->price * ($cartItems[$product->id] ?? 0);
        }
        return $total;
    }

    public function render()
    {
        $cartItems = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cartItems))->get();
        
        return view('livewire.checkout', [
            'products' => $products,
            'cartItems' => $cartItems,
            'total' => $this->getTotal()
        ])->layout('layouts.app');
    }

    public function placeOrder(CartService $cart)
    {
        $this->validate([
            'name' => 'required|min:3',
            'phone' => 'required',
            'address' => 'required',
            'screenshot' => 'required|image|max:2048',
        ]);

        $path = $this->screenshot->store('orders', 'public');

        // 1. Create the main Order
        $order = Order::create([
            'customer_name'      => $this->name,
            'phone_number'       => $this->phone,
            'address'            => $this->address,
            'total_amount'       => $this->getTotal(),
            'payment_screenshot' => $path,
            'status'             => 'pending',
        ]);

        // 2. SAVE THE SPECIFIC ITEMS ORDERED
        $cartItems = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cartItems))->get();

        foreach ($products as $product) {
            // This creates a record in the order_items table for each product in the bag
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $product->id,
                'quantity'   => $cartItems[$product->id],
                'price'      => $product->price, // Saving price now in case you change product price later
            ]);
        }

        // 3. Clear everything
        $cart->clear();
        $this->reset(['name', 'phone', 'address', 'screenshot']);

        return redirect()->to('/')->with('message', 'Order placed successfully!');
    }
}