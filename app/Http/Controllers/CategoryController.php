<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::withCount('products')->get()
        ]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'banner' => 'nullable|url',
        ]);

        Category::create([
            'name'   => $request->name,
            'banner' => $request->banner,
        ]);

        return redirect('/category')->with('success', 'Categoria criada!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'banner' => 'nullable|url',
        ]);

        $category->update([
            'name'   => $request->name,
            'banner' => $request->banner ?? $category->banner,
        ]);

        return redirect('/category')->with('success', 'Categoria atualizada!');
    }

    public function destroy(Category $category)
    {
        if ($category->banner) {
            \Storage::disk('public')->delete($category->banner);
        }
        $category->delete();
        return redirect('/category')->with('success', 'Categoria deletada!');
    }

    public function show(Category $category)
    {
        return view('category.show', [
            'category'   => $category,
            'products'   => $category->products()->with(['images', 'tag'])->get(),
            'categories' => Category::all(),
        ]);

         // Salva na sessão as últimas 3 categorias vistas
    $vistas = session()->get('categorias_vistas', []);
    $vistas = array_filter($vistas, fn($v) => $v !== $category->id);
    array_unshift($vistas, $category->id);
    session()->put('categorias_vistas', array_slice($vistas, 0, 3));

    return view('category.show', [
        'category'   => $category,
        'products'   => $category->products()->with(['images', 'tag'])->get(),
        'categories' => Category::all(),
    ]);
    }
}