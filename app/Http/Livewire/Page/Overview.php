<?php

namespace App\Http\Livewire\Page;

use Livewire\Component;

class Overview extends Component
{
    public $title  = "Overview";
    public $dataTinjau;
    public $modal = [
        'for' => 'null',
        'message' => 'null',
    ];
    protected $listeners = ['closeModal' => 'handlerClose'];

    public function openModal($for, $message)
    {
        $this->modal['for'] = $for;
        $this->modal['message'] = $message;
    }
    public function handlerClose($attr)
    {
        if ($attr['session'] == 'upload') {
            session()->flash('action', "PDS Berhasil Di Upload");
        }
        $this->modal['for'] = $attr['for'];
        $this->modal['message'] = 'null';
    }

    public function render()
    {
        return view('livewire.page.overview', [
            'data' => $this->dataTinjau
        ])->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
