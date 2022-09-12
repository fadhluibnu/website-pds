<?php

namespace App\Http\Livewire\Page;

use App\Events\EventDeleteDokumen;
use App\Models\Dokumen;
use App\Models\JenisDokumen;
use App\Models\JenisPermohonan;
use App\Models\Pic;
use App\Models\PihakTerkait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithFileUploads;

class Pengajuan extends Component
{
    use WithFileUploads;
    public $judul;
    public $status;
    public $tanggal;
    public $modal = [
        'for' => 'null',
        'message' => 'null',
        'delete' => 'null',
    ];
    public $title = "Pengajuan";
    protected $search;
    protected $data;
    public $deleteName;
    public $deleteNomor;
    protected $listeners = ['closeModal' => 'handlerClose', 'search' => 'handlerSearch'];

    protected $updateQueryString = ['judul', 'status'];
    public function mount()
    {
        $this->judul = request()->query('judul', $this->judul);
        $this->status = request()->query('status', $this->status);
        $this->status = ucwords($this->status);
        if ($this->judul || $this->status) {
            $this->search = true;
        }
    }
    public function clear()
    {
        $this->tanggal = null;
        $this->search = true;
    }
    public function openModal($for, $message)
    {
        if ($for == "delete") {
            $name = Dokumen::where('id', $message)->get();
            $this->deleteName = $name[0]['judul'];
            $this->deleteNomor = $name[0]['nomor'];
            $this->modal['delete'] = 'active';
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
    public function deletePds($id, $nomor)
    {
        $delete = Dokumen::destroy($id);
        $pic = Pic::where('dokumen_id', $id)->delete();
        $pt = PihakTerkait::where('dokumen_id', $id)->delete();
        if ($delete && $pic || $pt) {
            session()->flash('action', "PDS Berhasil Di Hapus");
            event(new EventDeleteDokumen($nomor . $id));
            $this->modal['delete'] = 'off';
            $this->modal['for'] = "null";
            $this->modal['message'] = "null";
        }
    }
    public function get_dokumen()
    {
        $pemohon = session('auth');
        $dokumen = Dokumen::where('pemohon', $pemohon[0]['id'])->latest()->get();
        return $dokumen;
    }
    public function search()
    {
        $pemohon = session('auth');
        $this->search = true;
        $dokumen = Dokumen::where('pemohon', $pemohon[0]['id']);
        if ($this->judul) {
            $dokumen = $dokumen->where('judul', 'like', '%' . $this->judul . '%');
        }
        if ($this->status) {
            $dokumen = $dokumen->whereHas('status', function (Builder $query) {
                $query->where('status', $this->status);
            });
        }
        if ($this->tanggal) {
            $dokumen = $dokumen->where('created_at', 'like', '%' . $this->tanggal . '%');
        }

        $dokumen = $dokumen->get();
        return $dokumen;
    }
    public function render()
    {
        if ($this->search == null) {
            $data = $this->get_dokumen();
        }
        if ($this->search == true) {
            $data = $this->search();
        }
        return view('livewire.page.pengajuan', [
            'dokumen' => $data
        ])->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
