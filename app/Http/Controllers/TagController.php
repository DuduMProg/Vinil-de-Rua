<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    public function index(){
        return view('tag.index', ['tags' => Tag::all()]);
    }

    public function create(){
        return view('tag.create');
    }

    public function store(Request $request){
        Tag::create($request->all());
        return redirect('/tag');
    }
}
