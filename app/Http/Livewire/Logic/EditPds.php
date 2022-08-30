<?php

namespace App\Http\Livewire\Logic;

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
        'nomor' => 'required',
        'judul' => 'required',
        'deskripsi' => 'required',
        'jenisdokumen' => 'required',
        'jenispermohonan' => 'required',
        'status' => 'required',
        'pemohon' => 'required',
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function updatepds()
    {
        if ($this->pengendalidokumen == null & $this->managerdeqa == null & $this->manageriqa == null & $this->managerurel == null & $this->osmtth == null) {
            $this->alertPic = "<script>alert('Anda belum memilih Penanggung Jawab')</script>";
        } else {
            $has_change = "";
            $sync = Dokumen::where('id', $this->idDokumen)->get();
            if ($sync[0]->nomor != $this->nomor) {
                $this->rules['nomor'] = 'required|unique:App\Models\Dokumen,nomor';
                $has_change .= " <strong>[ Nomor ] </strong ";
            } else {
                $this->rules['nomor'] = 'required';
            }
            if ($sync[0]->judul != $this->judul) {
                $this->rules['judul'] = 'required|unique:App\Models\Dokumen,judul';
                $has_change .= "<strong>[ Judul ]</strong> ";
            } else {
                $this->rules['judul'] = 'required';
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
                }
            }
            $update = Dokumen::where('id', $this->idDokumen)->update($validatedData);
            if ($update) {
                $pic = Pic::where('dokumen_id', $this->idDokumen)->delete();
                if ($pic) {
                    if ($this->pengendalidokumen != null) {
                        $this->create_pic($this->idDokumen, "Document Controller 1");
                        $this->create_pic($this->idDokumen, "Document Controller 2");
                    }
                    if ($this->managerdeqa != null) {
                        $this->create_pic($this->idDokumen, $this->managerdeqa);
                    }
                    if ($this->manageriqa != null) {
                        $this->create_pic($this->idDokumen, $this->manageriqa);
                    }
                    if ($this->managerurel != null) {
                        $this->create_pic($this->idDokumen, $this->managerurel);
                    }
                }
                // $data = new Pic;
                // $pic = Pic::where('dokumen_id', $this->idDokumen)->get();
                // foreach ($pic as $item) {
                //     if ($this->pengendalidokumen == null & $item->role_id == "Document Controller 1") {
                //         $this->delete_pic($item->id);
                //     } elseif ($this->pengendalidokumen != null & $item->role_id != "Document Controller 1") {
                //         $this->create_pic($this->idDokumen, "Document Controller 1");
                //     }

                //     if ($this->pengendalidokumen == null & $item->role_id == "Document Controller 2") {
                //         $this->delete_pic($item->id);
                //     } elseif ($this->pengendalidokumen != null  & $item->role_id != "Document Controller 2") {
                //         $this->create_pic($this->idDokumen, "Document Controller 2");
                //     }

                //     if ($this->manageriqa == null & $item->role_id == $this->manageriqa) {
                //         $this->delete_pic($item->id);
                //     } elseif ($this->manageriqa != null  & $item->role_id != $this->manageriqa) {
                //         $this->create_pic($this->idDokumen, $this->manageriqa);
                //     }

                //     if ($this->managerurel == null & $item->role_id == $this->managerurel) {
                //         $this->delete_pic($item->id);
                //     } elseif ($this->managerurel != null & $item->role_id != $this->managerurel) {
                //         $this->create_pic($this->idDokumen, $this->managerurel);
                //     }

                //     if ($this->managerdeqa == null & $item->role_id == $this->managerdeqa) {
                //         $this->delete_pic($item->id);
                //     } elseif ($this->managerdeqa != null & $item->role_id != $this->managerdeqa) {
                //         $this->create_pic($this->idDokumen, $this->managerdeqa);
                //     }
                // }
                History::create([
                    'dokumen_id' => $this->idDokumen,
                    'user_id' => $this->pemohon,
                    'user_name' => $this->user_name,
                    'photo' => session('auth')[0]['photo'],
                    'judul' => 'PDS Berhasil Diedit',
                    'pesan' => 'Dokumen <strong>' . $this->judul . '</strong> telah mengalami perubahan pada ' . $has_change
                ]);
                $param = [
                    'for' => null,
                    'session' => 'edit'
                ];
                $this->emit('closeModal', $param);
            }
        }
    }

    public function delete_pic($id)
    {
        Pic::destroy($id);
    }

    public function create_pic($dokumen_id, $roleid)
    {
        Pic::create([
            'dokumen_id' => $dokumen_id,
            'role_id' => $roleid
        ]);
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
        $data = Dokumen::where('id', $this->idDokumen)->get();
        if ($this->idUpdate == null) {
            $this->idUpdate  = $data[0]->id;
            $this->nomor = $data[0]->nomor;
            $this->judul = $data[0]->judul;
            $this->deskripsi = $data[0]->deskripsi;
            $this->pemohon = $data[0]->pemohon;
            $this->status = $data[0]->status;
            $this->jenisdokumen = $data[0]->jenisdokumen;
            $this->jenispermohonan = $data[0]->jenispermohonan;
            $this->management = $data[0]->management;
            $this->pengendali = $data[0]->pengendali;
            $this->user_name = session('auth')[0]['name'];

            foreach ($data[0]->pics as $item) {
                // if ($item->role_id == 2) {
                //     $this->osmtth = 2;
                // }
                if ($item->role_id == "Document Controller 1" || $item->role_id == "Document Controller 2") {
                    $this->pengendalidokumen = "Document Controller";
                }
                if ($item->role_id == "Lab Manager IQA") {
                    $this->manageriqa = "Lab Manager IQA";
                }
                if ($item->role_id == "Lab Manager UREL") {
                    $this->managerurel = "Lab Manager UREL";
                }
                if ($item->role_id == "Lab Manager DEQA") {
                    $this->managerdeqa = "Lab Manager DEQA";
                }
            }
        }

        $jenisdokumen = JenisDokumen::all();
        $jenispermohonan = JenisPermohonan::all();
        return view('livewire.logic.edit-pds', [
            'data' => $data,
            'jenisdok' => $jenisdokumen,
            'jenisper' => $jenispermohonan,
        ]);
    }
}
