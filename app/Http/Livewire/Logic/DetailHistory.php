<?php

namespace App\Http\Livewire\Logic;

use App\Models\Dokumen;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class DetailHistory extends Component
{
    public $idDokumen;
    public $active = 'active';

    public function closeX()
    {
        $this->active = 'off';
        $param = [
            'for' => null,
            'session' => 'null'
        ];
        $this->emit('closeModal', $param);
    }

    public function export($path)
    {
        return Storage::disk('public')->download($path);
    }

    public function render()
    {
        $data = Dokumen::where('id', $this->idDokumen)->latest()->get();
        // dd($data[0]->histories);
        return view('livewire.logic.detail-history', [
            'data' => $data
        ]);
    }
}
