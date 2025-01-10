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
        $cart = Session::get('cart', []);
        return inertia('Cart', ['cart' => $cart]);
    }

    public function add(Request $request)
    {
        $product = $request->input('product');
        $quantity = $request->input('quantity', 1);

        $cart = Session::get('cart', []);
        $cart[$product['id']] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => isset($cart[$product['id']]) ? $cart[$product['id']]['quantity'] + $quantity : $quantity,
        ];
        Session::put('cart', $cart);

        return response()->json(['message' => 'Produto adicionado ao carrinho']);
    }

    public function remove(Request $request)
    {
        $productId = $request->input('id');
        $cart = Session::get('cart', []);
        unset($cart[$productId]);
        Session::put('cart', $cart);

        return response()->json(['message' => 'Produto removido do carrinho']);
    }
}
