<?php

namespace App\Http\Livewire\Page;

use App\Models\Dokumen;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class DetailPengguna extends Component
{
    public $title = "Detail Pengguna";
    protected $nik_user;
    public function mount($id)
    {
        $this->nik_user = $id;
    }
    public function render()
    {
        $user_query = Http::get(env("URL_API_GET_USER") . $this->nik_user);
        $user = collect($user_query->json());

        $activity = [
            'total_dokumen' => 0,
            'dokumen_selesai' => 0,
            'dokumen_dikembalikan' => 0,
            'dokumen_ditinjau' => 0
        ];
        $dokumen = new Dokumen();
        $activity['total_dokumen'] = count($dokumen->where('pemohon', $this->nik_user)->get());
        $activity['dokumen_selesai'] = count($dokumen->where('pemohon', $this->nik_user)->where('status', 'Selesai')->get());
        $activity['dokumen_dikembalikan'] = count($dokumen->where('pemohon', $this->nik_user)->where('status', 'Dikembalikan')->get());
        $activity['dokumen_ditinjau'] = count($dokumen->where('pemohon', $this->nik_user)->where('status', 'Ditinjau')->get());
        return view('livewire.page.detail-pengguna', [
            'user' => $user[0],
            'activity' => $activity
        ])->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
