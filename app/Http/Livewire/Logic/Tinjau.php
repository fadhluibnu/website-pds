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
    public $ketersedian_dokumen = false;

    // form
    public $idDock;
    public $judul;
    public $pengendali;
    public $manager;
    public $manajemen;
    public $role;
    public $location;
    public $id_peninjau;
    public $file;
    public $komentar;
    public $old_file;
    public $as_view;

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
        $dokumen_query = Dokumen::where('id', $this->idDock);
        $id_user = session('auth')[0]['id'];
        if ($this->as_view == 'pic') {
            if ($this->pengendalidokumen == null & $this->managerdeqa == null & $this->manageriqa == null & $this->managerurel == null & $this->smias == null) {
                $this->alertPic = "<script>alert('Anda belum memilih Pihak Terkait')</script>";
            } else {
                $dokumen  = $dokumen_query->first();
                $pihakterkait_selected = '';
                if ($this->pengendalidokumen != null) {
                    $pihakterkait_selected .= "|" . $this->pengendalidokumen . ":false";
                }
                if ($this->managerdeqa != null) {
                    $pihakterkait_selected .= "|" . $this->managerdeqa . ":false";
                }
                if ($this->manageriqa != null) {
                    $pihakterkait_selected .= "|" . $this->manageriqa . ":false";
                }
                if ($this->managerurel != null) {
                    $pihakterkait_selected .= "|" . $this->managerurel . ":false";
                }
                if ($this->smias != null) {
                    $pihakterkait_selected .= "|" . $this->smias . ":false";
                }

                if ($dokumen['pihak_terkait'] != null) {
                    $pihakterkait_selected .= $dokumen['pihak_terkait'];
                }

                $pihakterkait_selected = collect(explode("|", $pihakterkait_selected))->sort();
                // dd($pihakterkait_selected);
                $pihakterkait_selected_new = [];
                $pihakterkait_selected_filter = '';

                foreach ($pihakterkait_selected as $value) {
                    if ($value != '') {
                        $pihakterkait_selected_new[] = $value;
                    }
                }

                if (count($pihakterkait_selected_new) > 1) {
                    for ($i_filter = 0; $i_filter <= count($pihakterkait_selected_new) - 1; $i_filter++) {
                        if ($i_filter + 1 == count($pihakterkait_selected_new)) {
                            if ($pihakterkait_selected_new[$i_filter] != $pihakterkait_selected_new[0]) {
                                $pihakterkait_selected_filter .= "|" . $pihakterkait_selected_new[$i_filter];
                            }
                        }
                        if ($i_filter + 1 != count($pihakterkait_selected_new)) {
                            if ($pihakterkait_selected_new[$i_filter] != $pihakterkait_selected_new[$i_filter + 1]) {
                                $pihakterkait_selected_filter .= "|" . $pihakterkait_selected_new[$i_filter];
                            }
                        }
                    }
                } else {
                    $pihakterkait_selected_filter .= "|" . $pihakterkait_selected_new[0];
                }


                // dd($pihakterkait_selected_filter);

                $old_pic = $dokumen['pic'];
                $pics_explode = explode("|", $old_pic);
                $new_pic_status = [];

                $check_location = 0;
                for ($i_explode = 1; $i_explode <= count($pics_explode) - 1; $i_explode++) {
                    $pic_status = explode(":", $pics_explode[$i_explode]);

                    // mengubah location jika semua pic tidak bernilai false
                    if ($pic_status[1] == 'false') {
                        // dd("oke");
                        $check_location += 1;
                    }
                    // memperbarui pic
                    if ($pic_status[0] == $this->role) {
                        $new_pic_status = [
                            $pic_status[0],
                            $this->id_peninjau
                        ];
                    }
                }
                if ($check_location == 1) {
                    $this->location = "pihak_terkait";
                }

                // menyimpan perubahan status pic
                $update_pic = '';
                for ($i_update_pic = 1; $i_update_pic <= count($pics_explode) - 1; $i_update_pic++) {
                    $pic_status_update = explode(":", $pics_explode[$i_update_pic]);
                    if ($pic_status_update[0] != $this->role) {
                        $update_pic .= "|" . $pic_status_update[0] . ":" . $pic_status_update[1];
                    }
                }
                $update_pic .= "|" . $new_pic_status[0] . ":" . $new_pic_status[1];

                // file handler
                $file_handler = null;
                $file_history = null;

                if ($this->file == null) {
                    $file_handler = $this->old_file;
                } else {
                    $file_handler = $this->file->store('dokumen-pds', 'public');
                    $file_history = $file_handler;
                }

                $update_dokumen = $dokumen_query->update([
                    'file' => $file_handler,
                    'pic' => $update_pic,
                    'pihak_terkait' => $pihakterkait_selected_filter,
                    'location' => $this->location
                ]);
                if ($update_dokumen) {
                    History::create([
                        'dokumen_id' => $this->idDock,
                        'user_id' => $id_user,
                        'user_name' => session('auth')[0]['name'],
                        'file' => $file_history,
                        'photo' => session('auth')[0]['photo'],
                        'judul' => 'PDS Telah Disetujui',
                        'pesan' => $this->komentar
                    ]);
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
        } elseif ($this->as_view == 'pihak_terkait') {
            $dokumen  = $dokumen_query->first();
            $pihakterkait_now = explode("|", $dokumen['pihak_terkait']);

            $update_role_pihakterkait = [];
            $update_pihakterkait = '';
            $check_location = 0;

            for ($i_now = 1; $i_now <= count($pihakterkait_now) - 1; $i_now++) {
                $pihakterkait_status = explode(":", $pihakterkait_now[$i_now]);
                if ($pihakterkait_status[0] == $this->role) {
                    $update_role_pihakterkait = [
                        $pihakterkait_status[0], $this->id_peninjau
                    ];
                }
                if ($pihakterkait_status[0] != $this->role) {
                    $update_pihakterkait .= "|" . $pihakterkait_status[0] . ":" . $pihakterkait_status[1];
                }
                if ($pihakterkait_status[1] == 'false') {
                    $check_location += 1;
                }
            }
            if ($check_location == 1) {
                $this->location = 'management';
            }
            $update_pihakterkait .= "|" . $update_role_pihakterkait[0] . ":" . $update_role_pihakterkait[1];

            $file_handler = null;
            $file_history = null;
            if ($this->file == null) {
                $file_handler = $this->old_file;
            } else {
                $file_handler = $this->file->store('dokumen-pds', 'public');
                $file_history = $file_handler;
            }

            $update_dokumen = $dokumen_query->update([
                'file' => $file_handler,
                'pihak_terkait' => $update_pihakterkait,
                'location' => $this->location
            ]);
            if ($update_dokumen) {
                History::create([
                    'dokumen_id' => $this->idDock,
                    'user_id' => $id_user,
                    'user_name' => session('auth')[0]['name'],
                    'file' => $file_history,
                    'photo' => session('auth')[0]['photo'],
                    'judul' => 'PDS Telah Disetujui',
                    'pesan' => $this->komentar
                ]);
                $this->active = 'off';
                $param = [
                    'for' => 'tinjau',
                    'session' => 'tinjau'
                ];
                $this->emit('closeModal', $param);
            } else {
                session()->flash('err', "PDS Gagal Disubmit");
            }
        } elseif ($this->as_view == 'management') {
            $file_handler = null;
            $file_history = null;
            if ($this->file == null) {
                $file_handler = $this->old_file;
            } else {
                $file_handler = $this->file->store('dokumen-pds', 'public');
                $file_history = $file_handler;
            }

            $update_dokumen = $dokumen_query->update([
                'file' => $file_handler,
                'management' => $this->id_peninjau,
                'location' => 'pengendali_dokumen'
            ]);
            if ($update_dokumen) {
                History::create([
                    'dokumen_id' => $this->idDock,
                    'user_id' => $id_user,
                    'user_name' => session('auth')[0]['name'],
                    'file' => $file_history,
                    'photo' => session('auth')[0]['photo'],
                    'judul' => 'PDS Telah Disetujui',
                    'pesan' => $this->komentar
                ]);
                $this->active = 'off';
                $param = [
                    'for' => 'tinjau',
                    'session' => 'tinjau'
                ];
                $this->emit('closeModal', $param);
            } else {
                session()->flash('err', "PDS Gagal Disubmit");
            }
        } elseif ($this->as_view == 'pengendali_dokumen') {
            $file_handler = null;
            $file_history = null;
            if ($this->file == null) {
                $file_handler = $this->old_file;
            } else {
                $file_handler = $this->file->store('dokumen-pds', 'public');
                $file_history = $file_handler;
            }
            $update_dokumen = $dokumen_query->update([
                'file' => $file_handler,
                'status' => 'Selesai',
                'pengendali_dokumen' => $this->id_peninjau,
                'location' => 'Finish'
            ]);
            if ($update_dokumen) {
                History::create([
                    'dokumen_id' => $this->idDock,
                    'user_id' => $id_user,
                    'user_name' => session('auth')[0]['name'],
                    'file' => $file_history,
                    'photo' => session('auth')[0]['photo'],
                    'judul' => 'PDS Telah Disetujui',
                    'pesan' => $this->komentar
                ]);
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
    public function kembalikan($id)
    {
        $this->active = 'off';
        $param = [
            'for' => 'tinjau',
            'session' => 'null'
        ];
        $this->emit('closeModal', $param);
        $arr = [
            'id' => $id,
        ];
        $this->emit('openKembalikan', $arr);
    }
    public function render()
    {
        // dd($this->attrTinjau);
        $data = Dokumen::where('id', $this->attrTinjau['id'])->get();
        if (count($data) != 0) {
            $this->old_file = $data[0]['file'];
            $this->judul = $data[0]['judul'];
            $this->idDock = $data[0]['id'];
            $this->as_view = $this->attrTinjau['as_view'];
            $this->location = $this->attrTinjau['location'];
            $this->role = session('auth')[0]['role'];
            $this->id_peninjau = session('auth')[0]['id'];
            $http = Http::get(env("URL_API_GET_USER") . $data[0]->pemohon);
        } else {
            $data = null;
            $http = null;
            $this->ketersedian_dokumen = true;
        }
        return view('livewire.logic.tinjau', [
            'data' => collect($data[0]),
            'api' => $http
        ]);
    }
}
