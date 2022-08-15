<?php

namespace App\Http\Livewire\Logic;

use App\Models\Dokumen;
use App\Models\History;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\JenisDokumen;
use App\Models\JenisPermohonan;
use App\Models\Pic;
use Illuminate\Support\Facades\Gate;
use League\CommonMark\Node\Block\Document;

class UploadPds extends Component
{
    use WithFileUploads;

    // public $display;
    public $modalUpload;

    // atribut form
    public $nomor;
    public $judul;
    public $jenisdokumen;
    public $jenispermohonan;
    public $deskripsi;
    public $file;
    public $pemohon;
    public $status = 1;
    public $management;
    public $pengendali;
    public $saveLoader;

    public $pengendalidokumen;
    public $manageriqa;
    public $managerurel;
    public $managerdeqa;
    public $osmtth;
    public $alertPic;

    public $user_name;


    protected $rules =  [
        'nomor' => 'required|unique:App\Models\Dokumen,nomor',
        'judul' => 'required|unique:App\Models\Dokumen,judul',
        'jenisdokumen' => 'required',
        'jenispermohonan' => 'required',
        'deskripsi' => 'required',
        'file' => 'required',
        'status' => 'required',
        'pemohon' => 'required',
    ];
    public function mount()
    {
        $sessionUser = session('auth');
        $this->pemohon = $sessionUser['user']['id'];
        $this->user_name = $sessionUser['user']['name'];
        if (Gate::forUser($this->pemohon)->allows('management')) {
            $this->management = $sessionUser['user']['id'];
        }
        if (Gate::forUser($this->pemohon)->allows('pengendaliDokumen')) {
            $this->pengendali = $sessionUser['user']['id'];
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function storepds()
    {
        if ($this->pengendalidokumen == null & $this->managerdeqa == null & $this->manageriqa == null & $this->managerurel == null & $this->osmtth == null) {
            $this->alertPic = "<script>alert('Anda belum memilih Penanggung Jawab')</script>";
        } else {
            if (Gate::forUser($this->pemohon)->allows('management')) {
                $this->rules += [
                    'management' => 'required'
                ];
            }
            if (Gate::forUser($this->pemohon)->allows('pengendaliDokumen')) {
                $this->rules += [
                    'pengendali' => 'required'
                ];
            }
            $validatedData = $this->validate();

            $validatedData['file'] = $this->file->store('dokumen-pds', 'public');

            $store = Dokumen::create($validatedData);

            if ($store) {
                if ($this->pengendalidokumen != null) {
                    $this->storePic($store['id'], $this->pengendalidokumen, $this->pemohon);
                }
                if ($this->managerdeqa != null) {
                    $this->storePic($store['id'], $this->managerdeqa, $this->pemohon);
                }
                if ($this->manageriqa != null) {
                    $this->storePic($store['id'], $this->manageriqa, $this->pemohon);
                }
                if ($this->managerurel != null) {
                    $this->storePic($store['id'], $this->managerurel, $this->pemohon);
                }
                if ($this->osmtth != null) {
                    $this->storePic($store['id'], $this->osmtth, $this->pemohon);
                }
                History::create([
                    'dokumen_id' => $store['id'],
                    'user_id' => $this->pemohon,
                    'user_name' => $this->user_name,
                    'judul' => 'PDS Berhasil Diupload',
                    'pesan' => 'Dokumen ' . $store['judul'] . ' telah berhasil diupload'
                ]);
                $param = [
                    'for' => null,
                    'session' => 'upload'
                ];
                $this->emit('closeModal', $param);
            } else {
                session()->flash('action', "Data Gagal Diupload");
            }
        }
    }
    public function storePic($dokumen_id, $roleid, $pic)
    {
        Pic::create([
            'dokumen_id' => $dokumen_id,
            'role_id' => $roleid,
            'pic' => $pic
        ]);
    }
    public function closeX()
    {
        $this->modalUpload = 'off';
        $param = [
            'for' => null,
            'session' => 'null'
        ];
        $this->emit('closeModal', $param);
    }

    public function render()
    {
        $jenisdokumen = JenisDokumen::all();
        $jenispermohonan = JenisPermohonan::all();
        return view('livewire.logic.upload-pds', [
            'jenisdok' => $jenisdokumen,
            'jenisper' => $jenispermohonan,
        ]);
        // 
    }
}
