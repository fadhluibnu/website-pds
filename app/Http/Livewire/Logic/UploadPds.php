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
    // public $file_name;
    public $pemohon;
    public $status = 1;
    public $management;
    public $pengendali;
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


    protected $rules =  [
        'nomor' => 'required|unique:App\Models\Dokumen,nomor',
        'judul' => 'required|unique:App\Models\Dokumen,judul',
        'jenisdokumen' => 'required',
        'jenispermohonan' => 'required',
        'deskripsi' => 'required',
        'file' => 'required|mimes:docx',
        'status' => 'required',
        'pemohon' => 'required',
    ];
    public function mount()
    {
        $sessionUser = session('auth');
        $this->pemohon = $sessionUser[0]['id'];
        $this->user_name = $sessionUser[0]['name'];
        if (Gate::forUser($this->pemohon)->allows('management')) {
            $this->management = $sessionUser[0]['id'];
        }
        if (Gate::forUser($this->pemohon)->allows('pengendaliDokumen')) {
            $this->pengendali = $sessionUser[0]['id'];
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        if ($this->file != null) {
            $this->placeholder_upload_fie = 'd-none';
            $this->placeholder_name_file = '';
        }
    }
    public function dokumen_dipilih($id)
    {
        $this->dokumen_dipilih .= "|" . $id;
    }

    public function storepds()
    {
        if ($this->pengendalidokumen == null & $this->managerdeqa == null & $this->manageriqa == null & $this->managerurel == null & $this->smias == null) {
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
            // if($this->smira != null){
            //     $this->
            // }
            $validatedData = $this->validate();
            $validatedData['file'] = $this->file->store('dokumen-pds', 'public');

            $store = Dokumen::create($validatedData);

            if ($store) {
                if ($this->pengendalidokumen != null) {
                    $this->storePic($store['id'], $this->pengendalidokumen);
                }
                if ($this->managerdeqa != null) {
                    $this->storePic($store['id'], $this->managerdeqa);
                }
                if ($this->manageriqa != null) {
                    $this->storePic($store['id'], $this->manageriqa);
                }
                if ($this->managerurel != null) {
                    $this->storePic($store['id'], $this->managerurel);
                }
                if ($this->smias != null) {
                    $this->storePic($store['id'], $this->smias);
                }
                History::create([
                    'dokumen_id' => $store['id'],
                    'user_id' => $this->pemohon,
                    'user_name' => $this->user_name,
                    'file' => $validatedData['file'],
                    'photo' => session('auth')[0]['photo'],
                    'judul' => 'PDS Berhasil Diupload',
                    'pesan' => 'Dokumen <strong>' . $this->judul . '</strong> telah berhasil diupload'
                ]);
                // event(new EventForPic($this->event_pic, $store['id'] . 'ditinjau', $id));
                $param = [
                    'for' => null,
                    'session' => 'upload'
                ];
                $this->emit('closeModal', $param);
                $this->eventUpload($store['id']);
            } else {
                session()->flash('action', "Data Gagal Diupload");
            }
        }
    }
    public function storePic($dokumen_id, $roleid)
    {
        Pic::create([
            'dokumen_id' => $dokumen_id,
            'role_id' => $roleid
        ]);
        $this->event_pic[] = $roleid;
    }
    public function eventUpload($id)
    {
        $event = Storage::get('event_upload.json');
        $decode = json_decode($event, true);
        $contents = $decode;
        $contents[] = [
            "type" => 'upload',
            "id" => $id,
            'identitas' => $id . 'ditinjau',
            'role' => $this->event_pic
        ];
        $contents = json_encode($contents);
        Storage::put('event_upload.json', $contents);
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
    }
}
