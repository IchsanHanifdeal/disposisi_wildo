<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProposalKeluar;
use Illuminate\Support\Facades\DB;

class ProposalKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.proposalkeluar', [
            'proposal_keluar' => ProposalKeluar::all(),
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
        // Validasi input termasuk file
        $request->validate([
            'no_urut' => 'required|string|max:255', // Validasi no urut
            'tanggal' => 'required|date', // Validasi tanggal (harus berupa tanggal)
            'perihal' => 'required|string|max:255', // Validasi perihal
            'file' => 'nullable|file|mimes:pdf', // Validasi file (hanya PDF, max 2MB)
        ]);

        DB::beginTransaction();
        try {
            // Membuat instance ProposalKeluar baru
            $proposal_keluar = new ProposalKeluar();
            $proposal_keluar->no_urut = $request->no_urut;
            $proposal_keluar->tanggal_keluar = $request->tanggal;
            $proposal_keluar->perihal = $request->perihal;

            // Mengecek apakah file diunggah
            if ($request->hasFile('file')) {
                // Mengambil file yang diunggah
                $file = $request->file('file');

                // Menentukan nama file dan path untuk menyimpan
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/proposal_keluar', $filename); // Simpan ke direktori 'public/proposal_keluar'

                // Simpan path file ke database
                $proposal_keluar->file = $filename; // Simpan nama file, bukan path penuh
            }

            // Simpan data proposal_keluar ke database
            $proposal_keluar->save();
            DB::commit();

            // Mengirim notifikasi sukses ke sesi
            return redirect()->back()->with('toast', [
                'message' => 'Proposal Keluar berhasil ditambahkan.',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['file_materi' => $e->getMessage()])
                ->withInput()
                ->with('toast', [
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                    'type' => 'error'
                ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(ProposalKeluar $proposalKeluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProposalKeluar $proposalKeluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_urut' => 'required|string|max:255', // Validate 'no_urut'
            'tanggal' => 'required|date', // Validate 'tanggal'
            'perihal' => 'required|string|max:255', // Validate 'perihal'
        ]);

        DB::beginTransaction();
        try {
            // Find the existing proposal record
            $proposal_keluar = ProposalKeluar::findOrFail($id);

            // Update the proposal details
            $proposal_keluar->no_urut = $request->no_urut;
            $proposal_keluar->tanggal_keluar = $request->tanggal;
            $proposal_keluar->perihal = $request->perihal;

            // Save the updated record
            $proposal_keluar->save();
            DB::commit();

            // Set success message in session
            return redirect()->back()->with('toast', [
                'message' => 'Proposal Masuk berhasil diperbarui.',
                'type' => 'success',
                // 'playAudio' => true // Flag to play audio if necessary
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
            // Find the existing proposal record by ID
            $proposal_keluar = ProposalKeluar::findOrFail($id);

            // Delete the proposal record
            $proposal_keluar->delete();

            DB::commit();

            // Set success message in session
            return redirect()->back()->with('toast', [
                'message' => 'Proposal keluar berhasil dihapus.',
                'type' => 'success',
                // 'playAudio' => true // Flag to play audio if necessary
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
