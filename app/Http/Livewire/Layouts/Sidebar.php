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
        $user = session('auth');
        return view('livewire.layouts.sidebar', [
            'user' => $user,
            'gate' => $user['user']['role']['id']
        ]);
    }
}
