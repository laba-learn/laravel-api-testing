<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Article;

class ArticleController extends Controller 
{
    public function index()
    {
        return Article::all();
    }
 
    public function show($id)
    {
        return Article::find($id);
    }

    public function store(Request $request)
    {
        return Article::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->update($request->all());

        return $article;
    }

    public function destroy(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return response()->json(['success' => true], 200);
    }
}