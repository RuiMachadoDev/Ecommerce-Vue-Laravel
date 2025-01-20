<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function __construct()
    {
        // Garante que apenas utilizadores autenticados acedem às rotas
        $this->middleware('auth')->except(['index']);
    }

    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();

        $cart = $cartItems->map(function ($item) {
            return [
                'id' => $item->product->id,
                'name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
            ];
        });

        return inertia('Cart', ['cart' => $cart]);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = auth()->user()->cartItems()->firstOrCreate(
            ['product_id' => $validated['product_id']],
            ['quantity' => 0]
        );

        $cartItem->quantity += $validated['quantity'];
        $cartItem->save();

        return response()->json(['message' => 'Produto adicionado ao carrinho']);
    }

    public function remove(Request $request)
    {
        $validated = $request->validate(['id' => 'required|exists:cart_items,id']);
        auth()->user()->cartItems()->where('id', $validated['id'])->delete();

        return response()->json(['message' => 'Produto removido do carrinho']);
    }

    public function count()
    {
        $cartCount = auth()->user()->cartItems()->sum('quantity');
        return response()->json(['count' => $cartCount]);
    }
}
