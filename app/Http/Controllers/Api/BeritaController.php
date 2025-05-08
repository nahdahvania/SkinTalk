<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Author;
use App\Models\Category;

class BeritaController extends Controller
{
    // Ambil semua berita dengan relasi author & category
    public function index()
    {
        $beritas = Berita::with(['author', 'category'])->get();

        return response()->json([
            'message' => 'Berhasil mengambil semua data berita',
            'data' => $beritas
        ]);
    }

    // Ambil detail berita berdasarkan ID
    public function show($id)
    {
        $berita = Berita::with(['author', 'category'])->find($id);

        if (!$berita) {
            return response()->json(['message' => 'Berita tidak ditemukan'], 404);
        }

        \Log::info('Data Berita: ', $berita->toArray());

        return response()->json([
            'message' => 'Berhasil mengambil detail berita',
            'data' => $berita
        ]);
    }

    // Ambil berita berdasarkan kategori (nama kategori)
    public function byCategory($categoryName)
    {
        $beritas = Berita::whereHas('category', function ($query) use ($categoryName) {
            $query->where('name', $categoryName);
        })->with(['author', 'category'])->get();

        if ($beritas->isEmpty()) {
            return response()->json(['message' => 'Tidak ada berita dalam kategori ini'], 404);
        }

        return response()->json([
            'message' => 'Berhasil mengambil berita berdasarkan kategori',
            'data' => $beritas
        ]);
    }
}
