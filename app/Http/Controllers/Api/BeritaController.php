<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Author;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::with('author')->get();

        return response()->json([
            'message' => 'Berhasil mengambil semua data berita',
            'data' => $beritas
        ]);
    }

    public function show($id)
    {
        $berita = Berita::find($id);

        if (!$berita) {
            return response()->json(['message' => 'Berita tidak ditemukan'], 404);
        }

        \Log::info('Data Berita: ', $berita->toArray());

        return response()->json($berita);
    }
}
