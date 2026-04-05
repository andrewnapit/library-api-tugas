<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    // 1. Fungsi POST (Tambah Data)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:200',
            'author'      => 'required|string|max:150',
            'isbn'        => 'required|string|max:20|unique:books,isbn',
            'category'    => 'nullable|string|max:100',
            'publisher'   => 'nullable|string|max:150',
            'year'        => 'nullable|integer|min:1900|max:2100',
            'stock'       => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $book = Book::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil ditambahkan.',
            'data'    => new BookResource($book)
        ], 201);
    }

    // 2. Fungsi PUT (Update Data)
    public function update(Request $request, string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan.'
            ], 404);
        }

        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:200',
            'author'      => 'sometimes|required|string|max:150',
            'isbn'        => 'sometimes|required|string|max:20|unique:books,isbn,' . $id,
            'category'    => 'nullable|string|max:100',
            'publisher'   => 'nullable|string|max:150',
            'year'        => 'nullable|integer|min:1900|max:2100',
            'stock'       => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $book->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data buku berhasil diupdate.',
            'data'    => new BookResource($book)
        ], 200);
    }

    // 3. Fungsi DELETE (Hapus Data) yang baru ditambahkan
    public function destroy(string $id)
    {
        // Cek apakah buku dengan ID tersebut ada
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan.'
            ], 404);
        }

        // Cek stok buku (Tidak boleh dihapus jika stok > 0 sesuai instruksi modul) [cite: 537]
        if ($book->stock > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Peringatan: Buku tidak dapat dihapus karena stok masih tersedia (Sisa stok: ' . $book->stock . ').'
            ], 422);
        }

        // Simpan judul buku sebelum dihapus untuk pesan konfirmasi [cite: 539]
        $deletedTitle = $book->title;

        // Hapus buku dari database
        $book->delete();

        // Kembalikan response berhasil dengan menyebutkan judul buku [cite: 539, 540]
        return response()->json([
            'success' => true,
            'message' => 'Buku "' . $deletedTitle . '" berhasil dihapus.'
        ], 200);
    }

}
