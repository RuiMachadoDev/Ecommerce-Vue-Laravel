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

        \Log::info('Carrinho atual', ['cart' => $cart]);

        return inertia('Cart', ['cart' => $cart]);
    }

    public function add(Request $request)
    {
        try {
            \Log::info('Requisição recebida no método add', ['dados' => $request->all()]);

            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
            ]);

            \Log::info('Validação concluída', ['validated' => $validated]);

            $product = \App\Models\Product::find($validated['product_id']);

            if (!$product) {
                \Log::error('Produto não encontrado', ['product_id' => $validated['product_id']]);
                return response()->json(['message' => 'Produto não encontrado.'], 404);
            }

            $cart = Session::get('cart', []);
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => isset($cart[$product->id]) ? $cart[$product->id]['quantity'] + $validated['quantity'] : $validated['quantity'],
            ];
            Session::put('cart', $cart);

            \Log::info('Produto adicionado ao carrinho', ['cart' => $cart]);

            return response()->json(['message' => 'Produto adicionado ao carrinho']);
        } catch (\Exception $e) {
            \Log::error('Erro ao adicionar produto ao carrinho', ['erro' => $e->getMessage()]);
            return response()->json(['message' => 'Erro ao adicionar produto ao carrinho.'], 500);
        }
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
