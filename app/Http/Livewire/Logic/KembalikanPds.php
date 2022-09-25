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
    public $pics;
    public $location;
    public $komentar;
    public function kembalikan($id)
    {
        $user = session('auth')[0];

        $pics = explode("|", $this->pics);
        $reset_pic = '';
        for ($i_reset = 1; $i_reset <= count($pics) - 1; $i_reset++) {
            $pic_status = explode(":", $pics[$i_reset]);
            $reset_pic .= "|" . $pic_status[0] . ":false";
        }
        // dd($reset_pic);

        $update_dokumen = Dokumen::where('id', $id)->update([
            'status' => 'Dikembalikan',
            'pic' => $reset_pic,
            'pihak_terkait' => null,
            'management' => null,
            'pengendali_dokumen' => null
        ]);
        if ($update_dokumen) {
            History::where('dokumen_id', $id)->where('type', 'catatan_now')->update([
                'type' => 'catatan'
            ]);
            History::create([
                'type' => 'catatan_now',
                'dokumen_id' => $id,
                'user_id' => $user['id'],
                'user_name' => $user['name'],
                'photo' => $user['photo'],
                'judul' => 'PDS Dikembalikan',
                'pesan' => $this->komentar
            ]);
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

        $arr = [
            'id' => $this->attrKembalikan['id'],
            'location' => $this->location
        ];
        $this->emit('fromKembalikan', $arr);
    }
    public function render()
    {
        $data = Dokumen::where('id', $this->attrKembalikan['id'])->first();
        $this->location = $data['location'];
        $this->pics = $data['pic'];
        $http = Http::get(env("URL_API_GET_USER") . $data['pemohon']);
        return view('livewire.logic.kembalikan-pds', [
            'data' => $data,
            'api' => $http
        ]);
    }
}
