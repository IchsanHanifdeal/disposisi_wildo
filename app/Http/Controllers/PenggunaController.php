<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pengguna', [
            'users' => User::all(),
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
            'nama' => 'required|string|max:255', // Validate name
            'email' => 'required|email|unique:users,email', // Validate email with unique constraint
            'password' => 'required|string|min:8', // Validate password with a minimum length
            'role' => 'required|string|max:255', // Validate role
        ]);

        DB::beginTransaction();
        try {
            $pengguna = new User();
            $pengguna->nama = $request->nama;
            $pengguna->email = $request->email;
            $pengguna->password = Hash::make($request->password); // Hash the password before saving
            $pengguna->role = $request->role;

            $pengguna->save();
            DB::commit();

            // Set success flag in session
            return redirect()->back()->with('toast', [
                'message' => 'Pengguna berhasil ditambahkan.',
                'type' => 'success',
                // 'playAudio' => true // Optionally, if you want to play audio
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction(); // Start transaction

        try {
            // Find user by ID
            $user = User::findOrFail($id);

            // Delete the user
            $user->delete();

            DB::commit(); // Commit transaction if everything is fine

            // Return success message
            return redirect()->back()->with('toast', [
                'message' => 'Pengguna berhasil dihapus.',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction if something goes wrong

            // Return error message
            return redirect()->back()->with('toast', [
                'message' => 'Gagal menghapus pengguna: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }
}
