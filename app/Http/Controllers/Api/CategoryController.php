<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        // Ambil semua kategori dengan id, name, slug (buat navbar)
        return Category::select('id', 'name', 'slug')->get();
    }
}
