<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\ProposalMasukController;
use App\Http\Controllers\ProposalKeluarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/', [AuthController::class, 'logout'])->name('logout');
Route::post('/auth', [AuthController::class, 'auth'])->name('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $today = Carbon::today();

        return view('dashboard.index', [
            'today' => $today,
        ]);
    })->name('dashboard');

    Route::get('dashboard/pengguna', [PenggunaController::class, 'index'])->name('pengguna');
    Route::post('dashboard/pengguna/store', [PenggunaController::class, 'store'])->name('store.pengguna');
    Route::put('dashboard/pengguna/{id}/update', [PenggunaController::class, 'update'])->name('update.pengguna');
    Route::delete('dashboard/pengguna/{id}/delete', [PenggunaController::class, 'destroy'])->name('delete.pengguna');

    Route::get('dashboard/suratmasuk', [SuratMasukController::class, 'index'])->name('surat_masuk');
    Route::post('dashboard/suratmasuk/store', [SuratMasukController::class, 'store'])->name('store.surat_masuk');
    Route::put('dashboard/suratmasuk/{id}/update', [SuratMasukController::class, 'update'])->name('update.surat_masuk');
    Route::delete('dashboard/suratmasuk/{id}/delete', [SuratMasukController::class, 'destroy'])->name('delete.surat_masuk');

    Route::get('dashboard/suratkeluar', [SuratKeluarController::class, 'index'])->name('surat_keluar');
    Route::post('dashboard/suratkeluar/store', [SuratKeluarController::class, 'store'])->name('store.surat_keluar');
    Route::put('dashboard/suratkeluar/{id}/update', [SuratKeluarController::class, 'update'])->name('update.surat_keluar');
    Route::delete('dashboard/suratkeluar/{id}/delete', [SuratKeluarController::class, 'destroy'])->name('delete.surat_keluar');

    Route::get('dashboard/proposalmasuk', [ProposalMasukController::class, 'index'])->name('proposal_masuk');
    Route::post('dashboard/proposalmasuk/store', [ProposalMasukController::class, 'store'])->name('store.proposal_masuk');
    Route::put('dashboard/proposalmasuk/{id}/update', [ProposalMasukController::class, 'update'])->name('update.proposal_masuk');
    Route::delete('dashboard/proposalmasuk/{id}/delete', [ProposalMasukController::class, 'destroy'])->name('delete.proposal_masuk');

    Route::get('dashboard/proposalkeluar', [ProposalKeluarController::class, 'index'])->name('proposal_keluar');
    Route::post('dashboard/proposalkeluar/store', [ProposalKeluarController::class, 'store'])->name('store.proposal_keluar');
    Route::put('dashboard/proposalkeluar/{id}/update', [ProposalKeluarController::class, 'update'])->name('update.proposal_keluar');
    Route::delete('dashboard/proposalkeluar/{id}/delete', [ProposalKeluarController::class, 'destroy'])->name('delete.proposal_keluar');

    Route::get('dashboard/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('dashboard/logout', [AuthController::class, 'logout'])->name('logout');
});
