<?php

namespace App\Http\Livewire\Layouts;

use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Navbar extends Component
{
    public $title;
    public function mount($title)
    {
        $this->title = $title;
    }
    public function render()
    {
        return view('livewire.layouts.navbar');
    }
}
