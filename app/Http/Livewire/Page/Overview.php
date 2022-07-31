<?php

namespace App\Http\Livewire\Page;

use Livewire\Component;

class Overview extends Component
{
    public $title  = "Overview";
    public function render()
    {
        return view('livewire.page.overview')->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
