<?php

namespace App\Http\Livewire\Logic;

use App\Events\EventForPic;
use App\Models\Dokumen;
use App\Models\History;
use App\Models\Pic;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithFileUploads;

class Perbaiki extends Component
{
    use WithFileUploads;
    public $active = "active";
    public $idDokumen;
    public $file;
    public $judul;
    public $status = 1;
    protected $rules =  [
        'file' => 'required|mimes:docx',
        'status' => 'required'
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function update_file()
    {
        $validatedData = $this->validate();
        $update = Dokumen::where('id', $this->idDokumen)->update($validatedData);
        if ($update) {
            $history = History::create([
                'dokumen_id' => $this->idDokumen,
                'user_id' => session('auth')[0]['id'],
                'user_name' => session('auth')[0]['name'],
                'photo' => session('auth')[0]['photo'],
                'judul' => 'PDS Berhasil Diperbaiki',
                'pesan' => 'Dokumen <strong>' . $this->judul . '</strong> telah berhasil diperbaiki'
            ]);
            if ($history) {
                $param = [
                    'for' => null,
                    'session' => 'perbaiki'
                ];
                $pic = Pic::where('dokumen_id', $this->idDokumen)->get();
                $event = [];
                foreach ($pic as $item) {
                    $event[] = $item->role_id;
                }
                event(new EventForPic($pic, $this->idDokumen));
                $this->emit('closeModal', $param);
            }
        }
    }

    public function render()
    {
        $data = Dokumen::where('id', $this->idDokumen)->get();
        $history = $data[0]->histories->where('dokumen_id', $this->idDokumen)->where('type', 'catatan_now');
        foreach ($history as $item) {
            if ($item->type == "catatan_now") {
                $http = Http::get(env("URL_API_GET_USER") . $item->user_id);
            }
        }
        $http = $http->json();
        return view('livewire.logic.perbaiki', [
            'data' => $data[0],
            'person' => $http[0]['name']
        ]);
    }
}
