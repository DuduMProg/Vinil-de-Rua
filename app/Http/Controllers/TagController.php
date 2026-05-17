<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        return view('tag.index', ['tags' => Tag::all()]);
    }

    public function create()
    {
        return view('tag.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'banner' => 'nullable|url',
        ]);

        Tag::create([
            'name' => $request->name,
        ]);

        return redirect('/tag')->with('success', 'Tag criada!');
    }

    public function edit(Tag $tag)
    {
        return view('tag.edit', ['tag' => $tag]);
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tag->update([
            'name' => $request->name,
        ]);

        return redirect('/tag')->with('success', 'Tag atualizada!');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect('/tag')->with('success', 'Tag deletada!');
    }

    public function show(Tag $tag)
    {
        return view('tag.show', [
            'tag' => $tag,
            'products' => $tag->products()->get()
        ]);
    }
}
