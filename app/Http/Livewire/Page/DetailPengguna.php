<?php

namespace App\Http\Livewire\Page;

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
        // dd($user[0]);
        return view('livewire.page.detail-pengguna', [
            'user' => $user[0]
        ])->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
