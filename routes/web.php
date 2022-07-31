<?php

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

Route::get('/', Overview::class)->name("overview");
Route::get('/peninjauan', [Peninjauan::class])->name("peninjauan");
Route::get('/pengajuan', [Pengajuan::class])->name("pengajuan");
Route::get('/pengguna', [Pengguna::class])->name("pengguna");
Route::get('/pengaturan', [Pengaturan::class])->name("pengaturan");
