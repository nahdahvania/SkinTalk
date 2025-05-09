<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author; 

class AuthorController extends Controller
{
    public function index()
{
    $articles = Article::with('author')->get();
    return response()->json($articles);
}

}
