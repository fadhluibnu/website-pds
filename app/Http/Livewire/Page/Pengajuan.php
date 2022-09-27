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
    public $search = false;
    public $modal = [
        'for' => 'null',
        'message' => 'null',
        'delete' => 'null',
    ];
    public $title = "Pengajuan";
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
        $this->judul = $this->judul;
        $this->status = $this->status;
        $this->search = true;
        $this->tanggal = null;
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
        if ($attr['session'] == 'perbaiki') {
            session()->flash('action', "PDS Berhasil Di Perbaiki");
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
        if ($delete) {
            session()->flash('action', "PDS Berhasil Di Hapus");
            // event(new EventDeleteDokumen($nomor . $id));
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
    public function fun_search()
    {
        $this->search = true;
    }
    public function search_operation($data)
    {
        $result = [];
        if ($this->status == null) {
            $this->status = "kosong";
        }
        for ($i_data = 0; $i_data <= count($data) - 1; $i_data++) {
            if ($this->judul != null && $this->status != "kosong" && $this->tanggal != null) {
                $split_data_judul = explode(strtolower($this->judul), strtolower($data[$i_data]['judul']));
                if (count($split_data_judul) > 1 && $data[$i_data]['status'] == $this->status && date('Y-m-d', strtotime($data[$i_data]['tgl'])) == $this->tanggal) {
                    $result[] = $data[$i_data];
                }
            } elseif ($this->judul == null && $this->status == "kosong" && $this->tanggal == null) {
                $result = $data;
            } elseif ($this->judul != null && $this->status != "kosong" && $this->tanggal == null) {
                $split_data_judul = explode(strtolower($this->judul), strtolower($data[$i_data]['judul']));
                if (count($split_data_judul) > 1 && $data[$i_data]['status'] == $this->status) {
                    $result[] = $data[$i_data];
                }
            } elseif ($this->judul != null && $this->status == "kosong" && $this->tanggal != null) {
                $split_data_judul = explode(strtolower($this->judul), strtolower($data[$i_data]['judul']));
                if (count($split_data_judul) > 1 && date('Y-m-d', strtotime($data[$i_data]['tgl'])) == $this->tanggal) {
                    $result[] = $data[$i_data];
                }
            } elseif ($this->judul == null && $this->status != "kosong" && $this->tanggal != null) {
                if ($data[$i_data]['status'] == $this->status && date('Y-m-d', strtotime($data[$i_data]['tgl'])) == $this->tanggal) {
                    $result[] = $data[$i_data];
                }
            } elseif ($this->judul != null && $this->status == "kosong" && $this->tanggal == null) {
                $split_data_judul = explode(strtolower($this->judul), strtolower($data[$i_data]['judul']));
                // dd($split_data_judul);
                if (count($split_data_judul) > 1) {
                    $result[] = $data[$i_data];
                }
            } elseif ($this->judul == null && $this->status != "kosong" && $this->tanggal == null) {
                if ($data[$i_data]['status'] == $this->status) {
                    $result[] = $data[$i_data];
                }
            } elseif ($this->judul == null && $this->status == "kosong" && $this->tanggal != null) {
                if (date('Y-m-d', strtotime($data[$i_data]['tgl'])) == $this->tanggal) {
                    $result[] = $data[$i_data];
                }
            }
        }
        return $result;
    }
    public function render()
    {
        if ($this->search == true) {
            $data = collect($this->get_dokumen());
            $data = collect($this->search_operation($data));
        } else {
            $data = $this->get_dokumen();
        }
        // $data = [];
        return view('livewire.page.pengajuan', [
            'dokumen' => collect($data)
        ])->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
