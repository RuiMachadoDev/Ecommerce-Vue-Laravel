<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            \Log::info('Nenhuma categoria encontrada.');
            return response()->json([], 200);
        }

        \Log::info('Categorias retornadas:', $categories->toArray());
        return response()->json($categories, 200);
    }

    public function store(Request $request)
    {
        // Regista os dados enviados
        \Log::info('Dados recebidos para criar categoria:', $request->all());

        // Tenta validar e captura qualquer erro
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|unique:categories,slug',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erro de validação:', $e->errors());
            return response()->json(['errors' => $e->errors()], 422);
        }

        // Tenta criar a categoria
        try {
            $category = Category::create($validated);
            return response()->json($category, 201);
        } catch (\Exception $e) {
            \Log::error('Erro ao criar categoria:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Erro interno ao criar categoria'], 500);
        }
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug,' . $category->id,
        ]);

        $category->update($validated);

        return $category;
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->noContent();
    }
}
