<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.suratmasuk', [
            'surat_masuk' => SuratMasuk::all(),
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
            'tanggal_masuk' => 'required', // Validate title
            'jenis_surat' => 'required|string|max:255', // Validate title
            'tujuan' => 'required|string|max:255', // Validate title
            'perihal' => 'required|string|max:255', // Validate title
        ]);

        DB::beginTransaction();
        try {
            $surat_masuk = new SuratMasuk();
            $surat_masuk->no_urut = $request->no_urut;
            $surat_masuk->tanggal_masuk = $request->tanggal_masuk;
            $surat_masuk->jenis_surat = $request->jenis_surat;
            $surat_masuk->tujuan = $request->tujuan;
            $surat_masuk->perihal = $request->perihal;

            $surat_masuk->save();
            DB::commit();

            // Set success flag in session
            return redirect()->back()->with('toast', [
                'message' => 'Surat Masuk berhasil ditambahkan.',
                'type' => 'success',
                'playAudio' => true // Flag to play audio
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
    public function show(SuratMasuk $suratMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratMasuk $suratMasuk)
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
            'tanggal_masuk' => 'required|date', // Validate tanggal_masuk
            'jenis_surat' => 'required|string|max:255', // Validate jenis_surat
            'tujuan' => 'required|string|max:255', // Validate tujuan
            'perihal' => 'required|string|max:255', // Validate perihal
        ]);

        DB::beginTransaction();
        try {
            $surat_masuk = SuratMasuk::findOrFail($id);

            $surat_masuk->no_urut = $request->no_urut;
            $surat_masuk->tanggal_masuk = $request->tanggal_masuk;
            $surat_masuk->jenis_surat = $request->jenis_surat;
            $surat_masuk->tujuan = $request->tujuan;
            $surat_masuk->perihal = $request->perihal;

            $surat_masuk->save();

            DB::commit();

            return redirect()->back()->with('toast', [
                'message' => 'Surat Masuk berhasil diperbarui.',
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
            $surat_masuk = SuratMasuk::findOrFail($id); // Fetch the record

            $surat_masuk->delete(); // Delete the record

            DB::commit();

            // Redirect with success message and audio playback flag
            return redirect()->back()->with('toast', [
                'message' => 'Surat Masuk berhasil dihapus.',
                'type' => 'success',
                'playAudio' => true, // Flag to play audio
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
