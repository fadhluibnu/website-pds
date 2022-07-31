<?php

namespace App\Http\Livewire\Page;

use Livewire\Component;

class Pengajuan extends Component
{
    public $title = "Pengajuan";
    public function render()
    {
        return view('livewire.page.pengajuan')->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
