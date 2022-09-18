<?php

namespace App\Http\Livewire\Logic;

use App\Events\EventForPengendali;
use App\Events\EventForPihakTerkait;
use App\Events\EventManajemenPengendali;
use App\Events\EventStatus;
use App\Events\ForManagement;
use App\Models\Dokumen;
use App\Models\History;
use App\Models\Pic;
use App\Models\PihakTerkait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class Tinjau extends Component
{
    use WithFileUploads;
    public $attrTinjau;
    public $active = 'active';

    // form
    public $idDock;
    public $judul;
    public $pengendali;
    public $manager;
    public $manajemen;
    public $role;
    public $id_peninjau;
    public $file;
    public $komentar;
    public $old_file;

    public $pengendalidokumen;
    public $manageriqa;
    public $managerurel;
    public $managerdeqa;
    public $smias;
    public $alertPic;

    protected $operation;
    protected $rules = [];

    public function tinjau_pds()
    {
        $id_user = session('auth')[0]['id'];
        $dokumen = Dokumen::where('id', $this->idDock);
        $event = $dokumen->get();

        if (Gate::forUser(session('auth')[0]['id'])->allows('picOrPihakTerkait')) {
            if ($this->pengendali == "as_pic" || $this->manager == "as_pic") {
                $this->for_pic();
            } elseif ($this->pengendali == "as_pihak_terkait" || $this->manager == "as_pihak_terkait") {
                $this->pihak_terkait();
            } elseif ($this->pengendali == "not_pic_and_pihak_terkait") {
                $latst = $dokumen->update([
                    'status' => 3,
                    'pengendali_status' => true,
                    'pengendali' => $this->id_peninjau,
                ]);
                if ($latst) {
                    $this->operation = true;
                }
            }
        }

        if (Gate::forUser($id_user)->allows('management')) {
            $check = $dokumen->first();
            if ($check->management_status == false) {
                $dokumen->update([
                    'management_status' => true,
                ]);
            }
            if ($check->management == null) {
                $dokumen->update([
                    'management' => $this->id_peninjau,
                ]);
            }
            $this->operation = true;
        }
        $file_now = null;
        if ($this->file != null && $this->operation) {
            // $delete = Storage::disk('public')->delete($this->old_file);
            // if ($delete) {
            $file_now = $this->file->store('dokumen-pds', 'public');
            $update = $dokumen->update([
                'file' => $file_now
            ]);
            if ($update) {
                $this->operation = true;
            }
            // }
        }

        if ($this->operation) {
            $history = History::create([
                'dokumen_id' => $this->idDock,
                'user_id' => $id_user,
                'user_name' => session('auth')[0]['name'],
                'file' => $file_now,
                'photo' => session('auth')[0]['photo'],
                'judul' => 'PDS Telah Disetujui',
                'pesan' => $this->komentar
            ]);
            if ($history) {
                $this->operation = true;
            }
        }
        if ($this->operation) {
            $this->active = 'off';
            $param = [
                'for' => 'tinjau',
                'session' => 'tinjau'
            ];
            $this->emit('closeModal', $param);
        } else {
            session()->flash('err', "PDS Gagal Disubmit");
        }
    }

    public function for_pic()
    {
        if ($this->pengendalidokumen == null & $this->managerdeqa == null & $this->manageriqa == null & $this->managerurel == null & $this->smias == null) {
            $this->alertPic = "<script>alert('Anda belum memilih Penanggung Jawab')</script>";
        } else {
            $this->Pic();
            if ($this->operation) {
                if ($this->pengendalidokumen != null) {
                    $this->store_pihak_terkait($this->idDock, "Document Controller 1");
                }
                if ($this->managerdeqa != null) {
                    $this->store_pihak_terkait($this->idDock, $this->managerdeqa);
                }
                if ($this->manageriqa != null) {
                    $this->store_pihak_terkait($this->idDock, $this->manageriqa);
                }
                if ($this->managerurel != null) {
                    $this->store_pihak_terkait($this->idDock, $this->managerurel);
                }
                if ($this->smias != null) {
                    $this->store_pihak_terkait($this->idDock, $this->smias);
                }
            }
        }
    }
    public function Pic()
    {
        $pic = Pic::where('dokumen_id', $this->idDock)->where('role_id', $this->role)->update([
            'pic' => $this->id_peninjau,
            'status' => true
        ]);
        if ($pic) {
            $check = Pic::where('dokumen_id', $this->idDock)->where('status', false)->get();
            if (count($check) == 0) {
                Dokumen::where('id', $this->idDock)->update([
                    'pic_status' => true
                ]);
            }
            $this->operation = true;
        }
    }
    public function store_pihak_terkait($dokumen_id, $roleid)
    {
        $pt = PihakTerkait::create([
            'dokumen_id' => $dokumen_id,
            'role_id' => $roleid
        ]);
        if ($pt) {
            $this->operation = true;
        }
    }
    public function pihak_terkait()
    {
        $query = PihakTerkait::where('dokumen_id', $this->idDock);
        $pt = $query->where('role_id', $this->role)->update([
            'pihak_terkait' => $this->id_peninjau,
            'status' => true
        ]);
        $check = PihakTerkait::where('dokumen_id', $this->idDock)->where('status', false)->get();
        if ($pt) {
            if (count($check) == 0) {
                Dokumen::where('id', $this->idDock)->update([
                    'pihakterkait_status' => true
                ]);
            }
            $this->operation = true;
        }
    }
    public function export($path, $judul)
    {
        return Storage::disk('public')->download($path, $judul);
    }
    public function event_for_pihakterkait($id)
    {
        $check = Pic::where('dokumen_id', $id)->where('status', false)->get();
        if (count($check) == 0) {
            $dokumen = Dokumen::where('id', $id)->update([
                'pic_status' => true
            ]);
            if ($dokumen) {
                $pihakterkaits = DB::table('pihak_terkaits')
                    ->select('role_id')
                    ->where('dokumen_id', $id)
                    ->distinct()
                    ->get();

                // event(new EventForPihakTerkait($pihakterkaits, $id . "ditinjau", $id));
            }
        }
    }

    public function event_for_management($id, $for)
    {
        $check = PihakTerkait::where('dokumen_id', $id)->where('status', false)->get();
        if (count($check) == 0) {
            event(new ForManagement($id, $for));
        }
    }
    public function closeX($default)
    {
        $this->active = 'off';
        $param = [
            'for' => 'tinjau',
            'session' => 'null'
        ];
        $this->emit('closeModal', $param);
        if ($default != "null") {
            $this->emit('openKembalikan', $default);
        }
    }
    public function kembalikan($id, $pengendali, $manager, $management)
    {
        $this->active = 'off';
        $param = [
            'for' => 'tinjau',
            'session' => 'null'
        ];
        $this->emit('closeModal', $param);
        $arr = [
            'id' => $id,
            'pengendali' => $pengendali,
            'manager' => $manager,
            'management' => $management
        ];
        $this->emit('openKembalikan', $arr);
    }
    public function render()
    {
        $data = Dokumen::where('id', $this->attrTinjau['id'])->get();
        $this->old_file = $data[0]['file'];
        $this->judul = $data[0]['judul'];
        $this->idDock = $data[0]['id'];
        $this->pengendali = $this->attrTinjau['pengendali'];
        $this->manager = $this->attrTinjau['manager'];
        $this->manajemen = $this->attrTinjau['manajemen'];
        $this->role = session('auth')[0]['role'];
        $this->id_peninjau = session('auth')[0]['id'];
        $http = Http::get(env("URL_API_GET_USER") . $data[0]->pemohon);
        return view('livewire.logic.tinjau', [
            'data' => $data,
            'api' => $http
        ]);
    }
}
