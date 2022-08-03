<?php

namespace App\Http\Livewire\Page;

use Livewire\Component;

class DetailPengguna extends Component
{
    public $title = "Detail Pengguna";
    public function render()
    {
        return view('livewire.page.detail-pengguna')->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
