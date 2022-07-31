<?php

namespace App\Http\Livewire\Layouts;

use Livewire\Component;

class Sidebar extends Component
{
    public $title;
    public function mount($title)
    {
        $this->title = $title;
    }
    public function render()
    {
        return view('livewire.layouts.sidebar');
    }
}
