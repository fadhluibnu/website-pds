<?php

use App\Http\Controllers\AuthController;
use App\Http\Livewire\Page\DetailPengguna;
use App\Http\Livewire\Page\Overview;
use App\Http\Livewire\Page\Pengajuan;
use App\Http\Livewire\Page\Pengaturan;
use App\Http\Livewire\Page\Pengguna;
use App\Http\Livewire\Page\Peninjauan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['HasSession'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name("logout");
    Route::get('/', Overview::class)->name("overview");
    Route::get('/pengajuan', Pengajuan::class)->name("pengajuan");
    Route::get('/pengaturan', Pengaturan::class)->name("pengaturan");
});
Route::get('/peninjauan', Peninjauan::class)->name("peninjauan")->middleware('peninjauan');
Route::middleware(['peninjauan'])->group(function () {
    Route::get('/pengguna', Pengguna::class)->name("pengguna");
    Route::get('/pengguna/detail-pengguna', DetailPengguna::class)->name("detail-pengguna");
});
Route::get('/login', [AuthController::class, 'index'])->name("login")->middleware('NoSession');
Route::post('/login', [AuthController::class, 'login'])->middleware('NoSession');
