<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProposalMasuk;
use Illuminate\Support\Facades\DB;

class ProposalMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.proposalmasuk', [
            'proposal_masuk' => ProposalMasuk::all(),
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
        // Validasi input
        $validatedData = $request->validate([
            'no_urut' => 'required|string|max:255', // Validasi no urut
            'tanggal' => 'required|date', // Validasi tanggal
            'perihal' => 'required|string|max:255', // Validasi perihal
            'file' => 'nullable|file|mimes:pdf|max:2048', // Validasi file PDF, max 2MB (opsional)
        ]);

        DB::beginTransaction();
        try {
            // Membuat data proposal_masuk
            $proposalMasuk = ProposalMasuk::create([
                'no_urut' => $validatedData['no_urut'],
                'tanggal_masuk' => $validatedData['tanggal'],
                'perihal' => $validatedData['perihal'],
            ]);

            // Jika file diunggah, simpan file
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // Buat nama file unik dan simpan
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/proposal_masuk', $filename); // Menyimpan file di storage

                // Perbarui record dengan path file
                $proposalMasuk->update([
                    'file' => 'proposal_masuk/' . $filename, // Path file yang disimpan
                ]);
            }

            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()->back()->with('toast', [
                'message' => 'Proposal Masuk berhasil ditambahkan.',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            // Redirect kembali dengan pesan error
            return redirect()->back()->withErrors([
                'error' => $e->getMessage(),
            ])->withInput()->with('toast', [
                'message' => 'Gagal menambahkan Proposal Masuk: ' . $e->getMessage(),
                'type' => 'error',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProposalMasuk $proposalMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProposalMasuk $proposalMasuk)
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
            'tanggal_masuk' => 'required|date', // Validate 'tanggal'
            'perihal' => 'required|string|max:255', // Validate 'perihal'
        ]);

        DB::beginTransaction();
        try {
            // Find the existing proposal record
            $proposal_masuk = ProposalMasuk::findOrFail($id);

            // Update the proposal details
            $proposal_masuk->no_urut = $request->no_urut;
            $proposal_masuk->tanggal_masuk = $request->tanggal_masuk;
            $proposal_masuk->perihal = $request->perihal;

            // Save the updated record
            $proposal_masuk->save();
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
            $proposal_masuk = ProposalMasuk::findOrFail($id);

            // Delete the proposal record
            $proposal_masuk->delete();

            DB::commit();

            // Set success message in session
            return redirect()->back()->with('toast', [
                'message' => 'Proposal Masuk berhasil dihapus.',
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
