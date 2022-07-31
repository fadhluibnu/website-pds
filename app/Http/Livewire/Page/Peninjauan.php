<?php

namespace App\Http\Livewire\Page;

use Livewire\Component;

class Peninjauan extends Component
{
    public $title = "Peninjauan";
    public function render()
    {
        return view('livewire.page.peninjauan')->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
