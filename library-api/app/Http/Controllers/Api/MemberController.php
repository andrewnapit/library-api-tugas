<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Resources\MemberResource;

class MemberController extends Controller
{
    // Fungsi POST (Tambah Member) - Sesuai Tutorial Modul
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:150',
            'member_code' => 'required|string|max:20|unique:members,member_code',
            'email'       => 'required|email|unique:members,email',
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string',
            'status'      => 'nullable|in:active,inactive,suspended',
            'joined_at'   => 'nullable|date',
        ]);

        $member = Member::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil didaftarkan.',
            'data'    => new MemberResource($member)
        ], 201);
    }

    // Fungsi PUT (Update Member) - TUGAS MAHASISWA
    public function update(Request $request, string $id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Member tidak ditemukan.'], 404);
        }

        $validated = $request->validate([
            'name'        => 'sometimes|required|string|max:150',
            'member_code' => 'sometimes|required|string|max:20|unique:members,member_code,' . $id,
            'email'       => 'sometimes|required|email|unique:members,email,' . $id,
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string',
            'status'      => 'sometimes|required|in:active,inactive,suspended',
            'joined_at'   => 'nullable|date',
        ]);

        $member->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data member berhasil diupdate.',
            'data'    => new MemberResource($member)
        ], 200);
    }

    // Fungsi DELETE (Hapus Member) - TUGAS MAHASISWA
    public function destroy(string $id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Member tidak ditemukan.'], 404);
        }

        // KETENTUAN TUGAS: Tolak jika status "active" [cite: 538]
        if ($member->status === 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: Member dengan status "active" tidak boleh dihapus.'
            ], 422);
        }

        $memberName = $member->name;
        $member->delete();

        return response()->json([
            'success' => true,
            'message' => 'Member "' . $memberName . '" berhasil dihapus.'
        ], 200);
    }
}
