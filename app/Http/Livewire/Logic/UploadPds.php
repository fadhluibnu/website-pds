<?php

namespace App\Http\Livewire\Logic;

use App\Events\EventForPic;
use App\Models\Dokumen;
use App\Models\History;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\JenisDokumen;
use App\Models\JenisPermohonan;
use App\Models\Pic;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
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
    public $status;
    public $pic;
    public $pihak_terkait;
    public $management;
    public $pengendali_dokumen;
    public $location;
    public $saveLoader;

    public $pengendalidokumen;
    public $manageriqa;
    public $managerurel;
    public $managerdeqa;
    public $smias;
    public $alertPic;

    public $user_name;
    public $placeholder_upload_fie = "not-active";
    public $placeholder_name_file = "d-none";
    protected $event_pic = [];
    public $dokumen_dipilih;


    public function mount()
    {
        $sessionUser = session('auth');
        $this->pemohon = $sessionUser[0]['id'];
        $this->location = "PIC";
        $this->status = "Ditinjau";
        $this->user_name = $sessionUser[0]['name'];
    }
    protected $rules =  [
        'nomor' => 'required',
        'judul' => 'required',
        'status' => 'required',
        'pemohon' => 'required',
        'jenisdokumen' => 'required',
        'jenispermohonan' => 'required',
        'deskripsi' => 'nullable',
        'file' => 'required|mimes:docx',
        'pic' => 'nullable',
        'location' => 'required',
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        if ($this->file != null) {
            $this->placeholder_upload_fie = 'd-none';
        }
    }

    public function storepds()
    {
        if ($this->pengendalidokumen == null & $this->managerdeqa == null & $this->manageriqa == null & $this->managerurel == null & $this->smias == null) {
            $this->alertPic = "<script>alert('Anda belum memilih Penanggung Jawab')</script>";
        } else {
            $this->pihak_terkait = null;
            $this->management = null;
            $this->pengendali_dokumen = null;
            $this->rules += [
                'pihak_terkait' => 'nullable',
                'management' => 'nullable',
                'pengendali_dokumen' => 'nullable',
            ];
            $validatedData = $this->validate();
            $validatedData['file'] = $this->file->store('dokumen-pds', 'public');

            $role_selected = null;
            if ($this->pengendalidokumen != null) {
                $role_selected .= "|" . $this->pengendalidokumen . ":false";
            }
            if ($this->managerdeqa != null) {
                $role_selected .= "|" . $this->managerdeqa . ":false";
            }
            if ($this->manageriqa != null) {
                $role_selected .= "|" . $this->manageriqa . ":false";
            }
            if ($this->managerurel != null) {
                $role_selected .= "|" . $this->managerurel . ":false";
            }
            if ($this->smias != null) {
                $role_selected .= "|" . $this->smias . ":false";
            }

            $validatedData['pic'] = $role_selected;

            $store = Dokumen::create($validatedData);

            if ($store) {
                History::create([
                    'dokumen_id' => $store['id'],
                    'user_id' => $this->pemohon,
                    'user_name' => $this->user_name,
                    'file' => $validatedData['file'],
                    'photo' => session('auth')[0]['photo'],
                    'judul' => 'PDS Berhasil Diupload',
                    'pesan' => 'Dokumen <strong>' . $this->judul . '</strong> telah berhasil diupload'
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
        return view('livewire.logic.upload-pds');
    }
}
