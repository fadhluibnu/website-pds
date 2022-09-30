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
    public $status;
    public $location;
    public $placeholder_upload_fie = '';

    public function closeX()
    {
        $this->active = 'off';
        $param = [
            'for' => null,
            'session' => 'null'
        ];
        $this->emit('closeModal', $param);
    }
    protected $rules = [
        'file' => 'required|mimes:docx',
        'status' => 'required',
        'location' => 'required'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        if ($this->file != null) {
            $this->placeholder_upload_fie = 'd-none';
        }
    }

    public function update_file()
    {
        $validatedData = $this->validate();
        $validatedData['file'] = $this->file->store('dokumen-pds', 'public');

        $update = Dokumen::where('id', $this->idDokumen)->update($validatedData);
        if ($update) {
            $history = History::create([
                'dokumen_id' => $this->idDokumen,
                'user_id' => session('auth')[0]['id'],
                'user_name' => session('auth')[0]['name'],
                'photo' => session('auth')[0]['photo'],
                'file' => $validatedData['file'],
                'judul' => 'PDS Berhasil Diperbaiki',
                'pesan' => 'Dokumen <strong>' . $this->judul . '</strong> telah berhasil diperbaiki'
            ]);
            if ($history) {
                $param = [
                    'for' => null,
                    'session' => 'perbaiki'
                ];
                $this->emit('closeModal', $param);
            }
        }
    }

    public function render()
    {
        $this->status = "Ditinjau";
        $this->location = "PIC";
        $data = Dokumen::where('id', $this->idDokumen)->first();
        $this->judul = $data['judul'];
        $history = History::where('dokumen_id', $this->idDokumen)->where('type', 'catatan_now')->first();
        $http = Http::get(env("URL_API_GET_USER") . $history['user_id']);
        $http = $http->json();
        return view('livewire.logic.perbaiki', [
            'data' => $data,
            'history' => $history,
            'person' => $http[0]['name']
        ]);
    }
}
