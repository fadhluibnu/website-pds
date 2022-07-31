<?php

namespace App\Http\Livewire\Page;

use Livewire\Component;

class Pengguna extends Component
{
    public $title = "Pengguna";
    public function render()
    {
        return view('livewire.page.pengguna')->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
