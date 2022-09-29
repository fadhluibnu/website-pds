<?php

namespace App\Http\Livewire\Logic;

use App\Models\Dokumen;
use App\Models\History;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class DetailHistory extends Component
{
    public $idDokumen;
    public $active = 'active';
    public $judul;

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
        return Storage::disk('public')->download($path, $this->judul);
    }

    public function exportHistory($path, $uploader)
    {
        return Storage::disk('public')->download($path, $this->judul . " By " . $uploader);
    }

    public function render()
    {
        $data = Dokumen::where('id', $this->idDokumen)->latest()->get();
        $this->judul = $data[0]['judul'];
        $history = History::where('dokumen_id', $this->idDokumen)->latest()->get();


        $pics = [];
        $pics_query = explode("|", $data[0]['pic']);
        for ($i = 1; $i <= count($pics_query) - 1; $i++) {
            $pic = explode(":", $pics_query[$i]);
            $pics += [$pic[0]];
        }
        return view('livewire.logic.detail-history', [
            'data' => collect($data),
            'history' => collect($history),
            'pics' => collect($pics)
        ]);
    }
}
