<?php

namespace App\Http\Livewire\Page;

use Livewire\Component;

class Overview extends Component
{
    public $title  = "Overview";
    public $dataTinjau;

    public function tinjau($judul)
    {
        $this->dataTinjau = [
            "name" => $judul,
            "tinjau" => 'active'
        ];
        // dd($this->dataTinjau['tinjau']);
    }

    public function render()
    {
        return view('livewire.page.overview', [
            'data' => $this->dataTinjau
        ])->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
