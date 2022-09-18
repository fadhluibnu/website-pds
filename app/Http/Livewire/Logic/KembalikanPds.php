<?php

namespace App\Http\Livewire\Logic;

use App\Events\EventStatus;
use App\Models\Dokumen;
use App\Models\History;
use App\Models\Pic;
use App\Models\PihakTerkait;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class KembalikanPds extends Component
{
    public $active = 'active';
    // public $idDock;
    public $attrKembalikan;
    public $komentar;
    public function kembalikan($id)
    {
        $user = session('auth')[0];
        $dokumen = Dokumen::where('id', $id)->update([
            'status' => 2,
            'pic_status' => false,
            'pihakterkait_status' => false,
            'management_status' => false,
            'management_status' => false
        ]);
        $pic = Pic::where('dokumen_id', $id)->update([
            'pic' => null,
            'status' => false
        ]);
        $pihak_terkait = PihakTerkait::where('dokumen_id', $id)->update([
            'pihak_terkait' => null,
            'status' => false
        ]);
        $history_lama = History::where('dokumen_id', $id)->where('type', 'catatan_now')->update([
            'type' => 'catatan'
        ]);
        $history = History::create([
            'type' => 'catatan_now',
            'dokumen_id' => $id,
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'photo' => $user['photo'],
            'judul' => 'PDS Dikembalikan',
            'pesan' => $this->komentar
        ]);
        if ($dokumen || $pic || $pihak_terkait || $history || $history_lama) {
            // event(new EventStatus($id, "dikembalikan"));
            $this->active = 'off';
            $param = [
                'for' => 'kembalikan',
                'session' => 'kembalikan'
            ];
            $this->emit('closeModal', $param);
        } else {
            session()->flash('err', "PDS Gagal Disubmit");
        }
    }
    public function closeX($default)
    {
        $this->active = 'off';
        $param = [
            'for' => 'kembalikan',
            'session' => 'null'
        ];
        $this->emit('closeModal', $param);
        if ($default != "null") {
            $this->emit('openTinjau', 'tinjau',);
        }
    }
    public function toTinjau()
    {
        $this->active = 'off';
        $param = [
            'for' => 'kembalikan',
            'session' => 'null'
        ];
        $this->emit('closeModal', $param);
        $this->emit('fromKembalikan', $this->attrKembalikan);
    }
    public function render()
    {
        // dd($this->attrKembalikan);
        $data = Dokumen::where('id', $this->attrKembalikan['id'])->get();
        $http = Http::get(env("URL_API_GET_USER") . $data[0]->pemohon);
        return view('livewire.logic.kembalikan-pds', [
            'data' => $data,
            'api' => $http
        ]);
    }
}
