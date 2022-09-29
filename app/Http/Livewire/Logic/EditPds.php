<?php

namespace App\Http\Livewire\Logic;

use App\Events\EventForPic;
use App\Models\Dokumen;
use App\Models\History;
use App\Models\JenisDokumen;
use App\Models\JenisPermohonan;
use App\Models\Pic;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPds extends Component
{
    use WithFileUploads;
    public $active = 'active';
    public $idDokumen;

    // atribut form
    public $idUpdate;
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
    protected $event_pic = [];

    public function mount()
    {
        $this->status = "Ditinjau";
        $this->location = "PIC";
        $this->pemohon = session('auth')[0]['id'];
    }

    protected $rules =  [
        'nomor' => 'required',
        'judul' => 'required',
        'deskripsi' => 'nullable',
        'jenisdokumen' => 'required',
        'jenispermohonan' => 'required',
        'status' => 'required',
        'pemohon' => 'required',
        'pic' => 'nullable',
        'pihak_terkait' => 'nullable',
        'management' => 'nullable',
        'pengendali_dokumen' => 'nullable',
        'location' => 'required',
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function updatepds()
    {
        if ($this->pengendalidokumen == null & $this->managerdeqa == null & $this->manageriqa == null & $this->managerurel == null & $this->smias == null) {
            $this->alertPic = "<script>alert('Anda belum memilih Penanggung Jawab')</script>";
        } else {
            $sync = Dokumen::where('id', $this->idDokumen)->latest()->get();

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
            $has_change = "";
            if ($sync[0]->nomor != $this->nomor) {
                $has_change .= " <strong>[ Nomor ] </strong> ";
            }
            if ($sync[0]->judul != $this->judul) {
                $has_change .= "<strong>[ Judul ]</strong> ";
            }
            if ($this->jenisdokumen != $sync[0]['jenisdokumen']) {
                $has_change .= "<strong>[ Jenis Dokumen ]</strong> ";
            }
            if ($this->jenispermohonan != $sync[0]['jenispermohonan']) {
                $has_change .= "<strong>[ Jenis Dokumen ]</strong> ";
            }
            if ($this->file) {
                $this->rules += [
                    'file' => 'required'
                ];
            }
            $validatedData = $this->validate();
            if ($this->file) {
                $delete = Storage::disk('public')->delete($sync[0]->file);
                if ($delete) {
                    $validatedData['file'] = $this->file->store('dokumen-pds', 'public');
                    $has_change .= "<strong>[ File ]</strong> ";
                }
            }
            if ($sync[0]['pic'] != $role_selected) {
                $validatedData['pic'] = $role_selected;
                $has_change .= "<strong>[ Penangung Jawab ]</strong> ";
            } else {
                $validatedData['pic'] = $sync[0]['pic'];
            }
            $update = Dokumen::where('id', $this->idDokumen)->update($validatedData);
            if ($update) {
                History::create([
                    'dokumen_id' => $this->idDokumen,
                    'user_id' => $this->pemohon,
                    'user_name' => $this->user_name,
                    'photo' => session('auth')[0]['photo'],
                    'judul' => 'PDS Berhasil Diedit',
                    'pesan' => 'Dokumen <strong>' . $this->judul . '</strong> telah mengalami perubahan pada ' . $has_change
                ]);
                // event(new EventForPic($this->event_pic, $this->idDokumen . 'ditinjau', $id));
                $param = [
                    'for' => null,
                    'session' => 'edit'
                ];
                $this->emit('closeModal', $param);
            }
        }

        // if ($this->pengendalidokumen == null & $this->managerdeqa == null & $this->manageriqa == null & $this->managerurel == null & $this->smias == null) {
        //     $this->alertPic = "<script>alert('Anda belum memilih Penanggung Jawab')</script>";
        // } else {
        //     $has_change = "";
        //     $sync = Dokumen::where('id', $this->idDokumen)->get();
        //     if ($sync[0]->nomor != $this->nomor) {
        //         $this->rules['nomor'] = 'required|unique:App\Models\Dokumen,nomor';
        //         $has_change .= " <strong>[ Nomor ] </strong ";
        //     } else {
        //         $this->rules['nomor'] = 'required';
        //     }
        //     if ($sync[0]->judul != $this->judul) {
        //         $this->rules['judul'] = 'required|unique:App\Models\Dokumen,judul';
        //         $has_change .= "<strong>[ Judul ]</strong> ";
        //     } else {
        //         $this->rules['judul'] = 'required';
        //     }
        //     if ($this->jenisdokumen != $sync[0]['jenisdokumen']) {
        //         $has_change .= "<strong>[ Jenis Dokumen ]</strong> ";
        //     }
        //     if ($this->jenispermohonan != $sync[0]['jenispermohonan']) {
        //         $has_change .= "<strong>[ Jenis Dokumen ]</strong> ";
        //     }
        //     if ($this->file) {
        //         $this->rules += [
        //             'file' => 'required'
        //         ];
        //     }
        //     $validatedData = $this->validate();
        //     if ($this->file) {
        //         $delete = Storage::disk('public')->delete($sync[0]->file);
        //         if ($delete) {
        //             $validatedData['file'] = $this->file->store('dokumen-pds', 'public');
        //         }
        //     }
        //     $update = Dokumen::where('id', $this->idDokumen)->update($validatedData);
        //     if ($update) {
        //         $pic = Pic::where('dokumen_id', $this->idDokumen)->delete();
        //         if ($pic) {
        //             if ($this->pengendalidokumen != null) {
        //                 $this->create_pic($this->idDokumen, "Document Controller 1");
        //                 $this->create_pic($this->idDokumen, "Document Controller 2");
        //             }
        //             if ($this->managerdeqa != null) {
        //                 $this->create_pic($this->idDokumen, $this->managerdeqa);
        //             }
        //             if ($this->manageriqa != null) {
        //                 $this->create_pic($this->idDokumen, $this->manageriqa);
        //             }
        //             if ($this->managerurel != null) {
        //                 $this->create_pic($this->idDokumen, $this->managerurel);
        //             }
        //             if ($this->smias != null) {
        //                 $this->create_pic($this->idDokumen, $this->smias);
        //             }
        //         }
        //         History::create([
        //             'dokumen_id' => $this->idDokumen,
        //             'user_id' => $this->pemohon,
        //             'user_name' => $this->user_name,
        //             'photo' => session('auth')[0]['photo'],
        //             'judul' => 'PDS Berhasil Diedit',
        //             'pesan' => 'Dokumen <strong>' . $this->judul . '</strong> telah mengalami perubahan pada ' . $has_change
        //         ]);
        //         // event(new EventForPic($this->event_pic, $this->idDokumen . 'ditinjau', $id));
        //         $param = [
        //             'for' => null,
        //             'session' => 'edit'
        //         ];
        //         $this->emit('closeModal', $param);
        //     }
        // }
    }

    public function closeX()
    {
        $this->active = 'off';
        $param = [
            'for' => null,
            'session' => 'null'
        ];
        $this->emit('closeModal', $param);
    }
    public function render()
    {
        $data = Dokumen::where('id', $this->idDokumen)->latest()->get();
        if ($this->idUpdate == null) {
            $this->user_name = session('auth')[0]['name'];
            $this->idUpdate  = $data[0]['id'];
            $this->nomor = $data[0]['nomor'];
            $this->judul = $data[0]['judul'];
            $this->deskripsi = $data[0]['deskripsi'];
            $this->pemohon = $data[0]['pemohon'];
            $this->status = $data[0]['status'];
            $this->jenisdokumen = $data[0]['jenisdokumen'];
            $this->jenispermohonan = $data[0]['jenispermohonan'];

            $pics_explode = explode("|", $data[0]['pic']);
            for ($i = 1; $i <= count($pics_explode) - 1; $i++) {
                $pic = explode(":", $pics_explode[$i]);
                if ($pic[0] == "SM IAS") {
                    $this->smias = "SM IAS";
                }
                if ($pic[0] == "Document Controller 1") {
                    $this->pengendalidokumen = "Document Controller 1";
                }
                if ($pic[0] == "Lab Manager IQA") {
                    $this->manageriqa = "Lab Manager IQA";
                }
                if ($pic[0] == "Lab Manager UREL") {
                    $this->managerurel = "Lab Manager UREL";
                }
                if ($pic[0] == "Lab Manager DEQA") {
                    $this->managerdeqa = "Lab Manager DEQA";
                }
            }
        }

        return view('livewire.logic.edit-pds', [
            'data' => collect($data)
        ]);
    }
}
