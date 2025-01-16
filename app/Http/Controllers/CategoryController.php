<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        // Aplica o middleware para verificar se o utilizador está autenticado
        $this->middleware('auth:sanctum');

        // Permissões específicas para métodos
        $this->middleware('can:manage categories')->only(['store', 'update', 'destroy']);
    }

    /**
     * Lista todas as categorias.
     */
    public function index()
    {
        \Log::info('Cabeçalhos recebidos', request()->headers->all());
        \Log::info('Sessão', session()->all());

        if (!auth()->check()) {
            \Log::info('Utilizador não autenticado.');
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return Category::all();
    }

    /**
     * Cria uma nova categoria.
     */
    
    public function store(Request $request)
    {
        dd(auth()->check(), auth()->user()->getRoleNames());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($validated);

        return response()->json($category, 201);
    }

    /**
     * Atualiza uma categoria existente.
     */
    public function update(Request $request, Category $category)
    {
        // Verifica autenticação
        if (!auth()->check()) {
            \Log::info('Ação não permitida: usuário não autenticado ao tentar atualizar categoria.');
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
        ]);

        $category->update($validated);

        \Log::info('Categoria atualizada com sucesso:', ['category' => $category]);

        return response()->json($category);
    }

    /**
     * Exclui uma categoria.
     */
    public function destroy(Category $category)
    {
        // Verifica autenticação
        if (!auth()->check()) {
            \Log::info('Ação não permitida: usuário não autenticado ao tentar excluir categoria.');
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $category->delete();

        \Log::info('Categoria excluída com sucesso:', ['category_id' => $category->id]);

        return response()->noContent();
    }
}
