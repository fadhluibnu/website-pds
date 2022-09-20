<?php

use App\Http\Controllers\AuthController;
use App\Http\Livewire\Page\DetailPengguna;
use App\Http\Livewire\Page\Overview;
use App\Http\Livewire\Page\Pengajuan;
use App\Http\Livewire\Page\Pengaturan;
use App\Http\Livewire\Page\Pengguna;
use App\Http\Livewire\Page\Peninjauan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

    // event edit

    // Route::get('/addrequest/{id}', function ($id) {
    //     $event = Storage::get('event.json');
    //     $decode = json_decode($event, true);
    //     $contents = $decode;
    //     $contents[] = [
    //         "id" => $id, "message" => $id . " say hi"
    //     ];
    //     $contents = json_encode($contents);
    //     Storage::put('event.json', $contents);
    //     $event2 = Storage::get('event.json');
    //     echo $event2;
    // });
    // Route::get('/delete/{id}', function ($id) {
    //     $event = Storage::get('event.json');
    //     $decode = json_decode($event, true);
    //     $content = [];
    //     foreach (collect($decode) as $item) {
    //         if ($item['id'] != $id) {
    //             $content[] = [
    //                 'id' => $item['id'],
    //                 'message' => $item['message']
    //             ];
    //         }
    //     }
    //     $contents = json_encode($content);
    //     Storage::put('event.json', $contents);
    // });
});
Route::get('/peninjauan', Peninjauan::class)->name("peninjauan")->middleware('peninjauan');
Route::middleware(['peninjauan'])->group(function () {
    Route::get('/pengguna', Pengguna::class)->name("pengguna");
    Route::get('/pengguna/detail-pengguna', DetailPengguna::class)->name("detail-pengguna");
});
Route::get('/login', [AuthController::class, 'index'])->name("login")->middleware('NoSession');
Route::post('/login', [AuthController::class, 'login'])->middleware('NoSession');

// event Route

// event upload
Route::get('/get_upload', function () {
    $event = Storage::get('event_upload.json');
    return json_decode($event, true);
});
Route::get('/delete_upload/{id}', function ($id) {
    $event = Storage::get('event_upload.json');
    $decode = json_decode($event, true);
    $content = [];
    foreach (collect($decode) as $item) {
        if ($item['id'] != $id) {
            $content[] = [
                'type' => $item['type'],
                'id' => $item['id'],
                'identitas' => $item['identitas'],
                'role' => $item['role']
            ];
        }
    }
    $contents = json_encode($content);
    Storage::put('event_upload.json', $contents);
});
