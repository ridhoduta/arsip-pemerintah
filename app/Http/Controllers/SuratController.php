<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
// use App\Http\Requests\StoreSuratRequest;
// use App\Http\Requests\UpdateSuratRequest;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surat = Surat::with('kategori')->get();
        return response()->json($surat, 200);
    }

    /**
     * Simpan surat baru (upload PDF)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:100',
            'kategori_id' => 'required|exists:tb_kategori,kategori_id',
            'judul' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:2048', // hanya PDF max 2MB
        ]);

        // simpan file PDF ke storage/app/public/surat
        $path = $request->file('file')->store('surat', 'public');

        $surat = Surat::create([
            'nomor_surat' => $request->nomor_surat,
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'file' => $path,
        ]);

        return response()->json(
            [
                'message' => 'Surat berhasil ditambahkan',
                'data' => $surat,
            ],
            201,
        );
    }

    /**
     * Detail surat
     */
    public function show($id)
    {
        $surat = Surat::with('kategori')->find($id);

        if (!$surat) {
            return response()->json(['message' => 'Surat tidak ditemukan'], 404);
        }

        // tambahkan file_url
        $surat->file_url = asset('storage/' . $surat->file);

        return response()->json($surat, 200);
    }


    /**
     * Update surat (termasuk ganti PDF)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:100',
            'kategori_id' => 'required|exists:tb_kategori,kategori_id',
            'judul' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf|max:2048',
        ]);

        $surat = Surat::find($id);

        if (!$surat) {
            return response()->json(['message' => 'Surat tidak ditemukan'], 404);
        }

        // jika ada file baru, hapus file lama lalu simpan baru
        if ($request->hasFile('file')) {
            if ($surat->file && Storage::disk('public')->exists($surat->file)) {
                Storage::disk('public')->delete($surat->file);
            }
            $path = $request->file('file')->store('surat', 'public');
            $surat->file = $path;
        }

        $surat->nomor_surat = $request->nomor_surat;
        $surat->kategori_id = $request->kategori_id;
        $surat->judul = $request->judul;
        $surat->save();

        return response()->json(
            [
                'message' => 'Surat berhasil diperbarui',
                'data' => $surat,
            ],
            200,
        );
    }

    /**
     * Hapus surat
     */
    public function destroy($id)
    {
        $surat = Surat::find($id);

        if (!$surat) {
            return response()->json(['message' => 'Surat tidak ditemukan'], 404);
        }

        // hapus file PDF dari storage
        if ($surat->file && Storage::disk('public')->exists($surat->file)) {
            Storage::disk('public')->delete($surat->file);
        }

        $surat->delete();

        return response()->json(['message' => 'Surat berhasil dihapus'], 200);
    }


    public function download($id)
    {
        // ambil data surat berdasarkan surat_id
        $surat = DB::select("SELECT * FROM tb_surat WHERE surat_id = ?", [$id]);

        if (empty($surat)) {
            return response()->json(['message' => 'Surat tidak ditemukan'], 404);
        }

        // karena DB::select() hasilnya array of object, ambil index pertama
        $surat = $surat[0];

        // misal field file_path menyimpan path file surat
        $filePath = storage_path('app/public/' . $surat->file);


        if (!file_exists($filePath)) {
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        }

        return response()->download($filePath, basename($filePath));
    }

    public function updateFile(Request $request, $id)
    {
        $surat = Surat::find($id);

        if (!$surat) {
            return response()->json(['message' => 'Surat tidak ditemukan'], 404);
        }

        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        // Hapus file lama jika ada
        if ($surat->file && Storage::exists('public/' . $surat->file)) {
            Storage::delete('public/' . $surat->file);
        }

        // Simpan file baru
        $path = $request->file('file')->store('surat', 'public');
        $surat->file = $path;
        $surat->save();

        return response()->json([
            'message' => 'File surat berhasil diperbarui',
            'surat' => $surat
        ], 200);
    }
}
