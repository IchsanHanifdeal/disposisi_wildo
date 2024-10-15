<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.suratkeluar', [
            'surat_keluar' => SuratKeluar::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_urut' => 'required|string|max:255', // Validate title
            'tanggal_keluar' => 'required', // Validate title
            'jenis_surat' => 'required|string|max:255', // Validate title
            'tujuan' => 'required|string|max:255', // Validate title
            'perihal' => 'required|string|max:255', // Validate title
        ]);

        DB::beginTransaction();
        try {
            $surat_keluar = new SuratKeluar();
            $surat_keluar->no_urut = $request->no_urut;
            $surat_keluar->tanggal_keluar = $request->tanggal_keluar;
            $surat_keluar->jenis_surat = $request->jenis_surat;
            $surat_keluar->tujuan = $request->tujuan;
            $surat_keluar->perihal = $request->perihal;

            $surat_keluar->save();
            DB::commit();

            return redirect()->back()->with('toast', [
                'message' => 'Surat keluar berhasil ditambahkan.',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['file_materi' => $e->getMessage()])
                ->withInput()
                ->with('toast', [
                    'message' => $e->getMessage(),
                    'type' => 'error'
                ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratKeluar $suratKeluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratKeluar $suratKeluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'no_urut' => 'required|string|max:255', // Validate no_urut
            'tanggal_keluar' => 'required|date', // Validate tanggal_keluar
            'jenis_surat' => 'required|string|max:255', // Validate jenis_surat
            'tujuan' => 'required|string|max:255', // Validate tujuan
            'perihal' => 'required|string|max:255', // Validate perihal
        ]);

        DB::beginTransaction();
        try {
            $surat_keluar = SuratKeluar::findOrFail($id);

            $surat_keluar->no_urut = $request->no_urut;
            $surat_keluar->tanggal_keluar = $request->tanggal_keluar;
            $surat_keluar->jenis_surat = $request->jenis_surat;
            $surat_keluar->tujuan = $request->tujuan;
            $surat_keluar->perihal = $request->perihal;

            $surat_keluar->save();

            DB::commit();

            return redirect()->back()->with('toast', [
                'message' => 'Surat keluar berhasil diperbarui.',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['file_materi' => $e->getMessage()])
                ->withInput()
                ->with('toast', [
                    'message' => $e->getMessage(),
                    'type' => 'error'
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $surat_keluar = SuratKeluar::findOrFail($id); // Assuming your model is called 'kategori'

            $surat_keluar->delete();

            DB::commit();

            return redirect()->back()->with('toast', [
                'message' => 'Surat keluar berhasil dihapus.',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['file_materi' => $e->getMessage()])
                ->with('toast', [
                    'message' => $e->getMessage(),
                    'type' => 'error'
                ]);
        }
    }
}