<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json(Category::paginate(10));
        }

        return Inertia::render('Categories', [
            'categories' => Category::paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        \Log::info('Requisição recebida para criar categoria:', $request->all());
    
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|unique:categories,slug',
            ]);
    
            $category = Category::create($validated);
            \Log::info('Categoria criada com sucesso:', $category->toArray());
    
            return $category;
        } catch (\Exception $e) {
            \Log::error('Erro ao criar categoria:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
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
