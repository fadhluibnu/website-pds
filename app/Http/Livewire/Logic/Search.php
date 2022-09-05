<?php

namespace App\Http\Livewire\Logic;

use App\Models\Dokumen;
use Illuminate\Database\Query\Builder;
use Livewire\Component;

class Search extends Component
{
    public $judul;
    public $status;
    public $tanggal;
    protected $data;
    public function search()
    {
        $pemohon = session('auth');
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
        $this->emit('search', collect($dokumen));
    }
    public function render()
    {
        return view('livewire.logic.search');
    }
}
