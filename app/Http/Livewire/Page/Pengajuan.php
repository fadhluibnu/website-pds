<?php

namespace App\Http\Livewire\Page;

use App\Models\Dokumen;
use App\Models\JenisDokumen;
use App\Models\JenisPermohonan;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithFileUploads;

class Pengajuan extends Component
{
    use WithFileUploads;
    public $modal = [
        'for' => 'null',
        'message' => 'null',
    ];
    public $title = "Pengajuan";
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
        $pemohon = session('auth');
        $dokumen = Dokumen::where('pemohon', $pemohon['user']['id'])->latest()->get();

        // $jenisdokumen = JenisDokumen::all();
        // $jenispermohonan = JenisPermohonan::all();
        return view('livewire.page.pengajuan', [
            'dokumen' => $dokumen
        ])->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
