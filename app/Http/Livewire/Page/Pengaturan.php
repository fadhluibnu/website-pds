<?php

namespace App\Http\Livewire\Page;

use Livewire\Component;

class Pengaturan extends Component
{
    public $title = "Pengaturan";
    public function render()
    {
        return view('livewire.page.pengaturan', [
            'data' => session('auth')[0]
        ])->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
