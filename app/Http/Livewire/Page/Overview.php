<?php

namespace App\Http\Livewire\Page;

use App\Models\Dokumen;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Overview extends Component
{
    public $title  = "Overview";
    public $q_tinjau = null;
    public $monitor_id;
    public $dataTinjau;
    public $modal = [
        'for' => 'null',
        'message' => 'null',
    ];
    public $tinjau = [
        'for' => 'null',
        'id' => 'null',
        'pengendali' => 'null',
        'manager' => 'null',
        'manajemen' => 'null',
        'location' => 'null'
    ];
    public $kembalikan = [
        'for' => 'null',
        'id' => 'null'
    ];
    protected $listeners = [
        'closeModal' => 'handlerClose',
        'openKembalikan' => 'handlerKembalikan',
        'fromKembalikan' => 'handlerTinjau',
    ];

    public function openModal($for, $message)
    {
        $this->modal['for'] = $for;
        $this->modal['message'] = $message;
    }
    public function openTinjau($for, $id, $pengendali, $manager, $manajemen, $location)
    {
        $this->tinjau['for'] = $for;
        $this->tinjau['id'] = $id;
        $this->tinjau['pengendali'] = $pengendali;
        $this->tinjau['manager'] = $manager;
        $this->tinjau['manajemen'] = $manajemen;
        $this->tinjau['location'] = $location;
    }
    public function handlerTinjau($attr)
    {
        $this->tinjau['for'] = 'tinjau';
        $this->tinjau['id'] = $attr['id'];
        $this->tinjau['pengendali'] = $attr['pengendali'];
        $this->tinjau['manager'] = $attr['manager'];
        $this->tinjau['management'] = $attr['management'];
    }
    public function handlerKembalikan($attr)
    {
        $this->kembalikan['for'] = 'kembalikan';
        $this->kembalikan['id'] = $attr['id'];
        $this->kembalikan['pengendali'] = $attr['pengendali'];
        $this->kembalikan['manager'] = $attr['manager'];
        $this->kembalikan['management'] = $attr['management'];
        $this->kembalikan['location'] = $attr['location'];
    }
    public function handlerClose($attr)
    {
        if ($attr['session'] == 'upload') {
            session()->flash('action', "PDS Berhasil Di Upload");
        }
        if ($attr['session'] == 'edit') {
            session()->flash('action', "PDS Berhasil Di Edit");
        }
        if ($attr['session'] == 'tinjau') {
            session()->flash('action', "PDS Berhasil Di Tinjau");
        }
        if ($attr['session'] == 'kembalikan') {
            session()->flash('action', "PDS Berhasil Di Kembalikan");
        }
        if ($attr['for'] == 'tinjau') {
            $this->tinjau['for'] = "null";
            $this->tinjau['id'] = "null";
            $this->tinjau['as_pic'] = "null";
        } elseif ($attr['for'] == 'kembalikan') {
            $this->kembalikan['for'] = 'null';
            $this->kembalikan['id'] = 'null';
        } else {
            $this->modal['for'] = $attr['for'];
            $this->modal['message'] = 'null';
        }
    }

    // Mengambil Dokumen Yang Harus Ditinjau Dan Hilang Setelah Di Tinjau
    public function get_dokumens($search)
    {
        $data = [];

        $inisialisai = new Dokumen();
        // $inisialisai = $inisialisai->where('judul', 'like', "%ex%");
        if (Gate::forUser(session('auth')[0]['id'])->allows('picOrPihakTerkait')) {
            $pic_query = $inisialisai->where('judul', 'like', "%" . $search . "%")->where('status', 1)->whereHas('pics', function (Builder $query) {
                $query->where('role_id', session('auth')[0]['role'])->where('status', false);
            })->get();
            foreach ($pic_query as $value) {
                $get_pemohon = Http::get(env("URL_API_GET_USER") . $value->pemohon);
                $data[] = $this->store_datas($value, $get_pemohon, "as_pic", "as_pic", "as_pic", "PIC");
            }
            $pihakterkait_query = $inisialisai->where('judul', 'like', "%" . $search . "%")->where('status', 1)->where('pic_status', true)->whereHas('pihakTerkaits', function (Builder $query) {
                $query->where('role_id', session('auth')[0]['role'])->where('status', false);
            })->get();
            foreach ($pihakterkait_query as $value) {
                $get_pemohon = Http::get(env("URL_API_GET_USER") . $value->pemohon);
                $data[] = $this->store_datas($value, $get_pemohon, "as_pihak_terkait", "as_pihak_terkait", "as_pihak_terkait", "Pihak Terkait");
            }
        }
        if (Gate::forUser(session('auth')[0]['id'])->allows('management')) {
            $management_query = $inisialisai->where('judul', 'like', "%" . $search . "%")->where('status', 1)->where('pic_status', true)->where('pihakterkait_status', true)->where('management_status', "!=", true)->get();
            foreach ($management_query as $value) {
                $get_pemohon = Http::get(env("URL_API_GET_USER") . $value->pemohon);
                $data[] = $this->store_datas($value, $get_pemohon, "null", "null", "manajemen", "Manajemen");
            }
        }

        if (Gate::forUser(session('auth')[0]['id'])->allows('pengendaliDokumen')) {
            $pengendali_query = $inisialisai->where('judul', 'like', "%" . $search . "%")->where('status', 1)->where('pic_status', true)->where('pihakterkait_status', true)->where('management_status', true)->get();
            foreach ($pengendali_query as $value) {
                $get_pemohon = Http::get(env("URL_API_GET_USER") . $value->pemohon);
                $data[] = $this->store_datas($value, $get_pemohon, "not_pic_and_pihak_terkait", "null", "null", "Pengendali");
            }
        }
        $data = collect($data);
        return $data;
    }
    public function tracking_document()
    {
        $data = [];
        $dokumen = Dokumen::where('pemohon', session('auth')[0]['id'])->where('status', "!=", 3)->latest()->get();
        foreach ($dokumen as $value) {
            $data[] = $this->store_tracking($value);
        }
        return $data;
    }

    public function showInMonitor($id)
    {
        $this->monitor_id = $id;
    }

    public function monitor($id)
    {
        if ($id != null) {
            $data = Dokumen::where('id', $id)->first();
            return $data;
        }
        $data = $this->tracking_document();
        if ($id == null && $data != null) {
            $data = $data[0];
            return $data;
        }
    }

    public function store_tracking($value)
    {
        $data = [
            'id' => $value->id,
            'nomor' => $value->nomor,
            'judul' => $value->judul,
            'status' => $value->status,
            'pic_status' => $value->pic_status,
            'pihakterkait_status' => $value->pihakterkait_status,
            'management_status' => $value->management_status,
            'pengendali_status' => $value->pengendali_status,
            'pengembali_dokumen' => $value->pengembali_dokumen
        ];
        return $data;
    }

    public function store_datas($value, $get_pemohon, $pengendali, $manager, $manajemen, $location)
    {
        $data = [
            'id' => $value->id,
            'identitas' => $value->id . 'ditinjau',
            'nomor' => $value->nomor,
            'judul' => $value->judul,
            'status' => 1,
            'pemohon' => $get_pemohon[0]['name'],
            'photo' => $get_pemohon[0]['photo'],
            'tgl' => $value->created_at,
            'pengendali' => $pengendali,
            'manager' => $manager,
            'manajemen' => $manajemen,
            'location' => $location
        ];
        return $data;
    }

    public function render()
    {
        $data = $this->get_dokumens($this->q_tinjau);
        $monitor = $this->monitor($this->monitor_id);
        if (count(collect($monitor)) == 0) {
            $monitor = null;
        } else {
            $monitor = collect($monitor);
        }
        return view('livewire.page.overview', [
            'data' => $data,
            'tracking' => collect($this->tracking_document()),
            'monitor' => $monitor
        ])->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
