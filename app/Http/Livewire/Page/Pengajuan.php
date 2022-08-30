<?php

namespace App\Http\Livewire\Page;

use App\Models\Dokumen;
use App\Models\JenisDokumen;
use App\Models\JenisPermohonan;
use App\Models\Pic;
use App\Models\PihakTerkait;
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
    public $deleteName;
    protected $listeners = ['closeModal' => 'handlerClose'];

    public function openModal($for, $message)
    {
        if ($for == "delete") {
            $name = Dokumen::where('id', $message)->get();
            $this->deleteName = $name[0]['judul'];
        }
        $this->modal['for'] = $for;
        $this->modal['message'] = $message;
    }
    public function handlerClose($attr)
    {
        if ($attr['session'] == 'upload') {
            session()->flash('action', "PDS Berhasil Di Upload");
        }
        if ($attr['session'] == 'edit') {
            session()->flash('action', "PDS Berhasil Di Edit");
        }
        $this->modal['for'] = $attr['for'];
        $this->modal['message'] = 'null';
    }
    public function closeDelete()
    {
        $this->modal['for'] = "null";
        $this->modal['message'] = "null";
    }
    public function deletePds($id)
    {
        $delete = Dokumen::destroy($id);
        $pic = Pic::where('dokumen_id', $id)->delete();
        $pt = PihakTerkait::where('dokumen_id', $id)->delete();
        if ($delete && $pic && $pt) {
            session()->flash('action', "PDS Berhasil Di Hapus");
            $this->modal['for'] = "null";
            $this->modal['message'] = "null";
        }
    }
    public function render()
    {
        $pemohon = session('auth');
        $dokumen = Dokumen::where('pemohon', $pemohon[0]['id'])->latest()->get();
        return view('livewire.page.pengajuan', [
            'dokumen' => $dokumen
        ])->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
