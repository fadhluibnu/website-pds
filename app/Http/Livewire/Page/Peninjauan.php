<?php

namespace App\Http\Livewire\Page;

use App\Models\Dokumen;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Peninjauan extends Component
{
    public $title = "Peninjauan";
    public $judul;
    public $status;
    // public $update;
    public $badge;
    protected $datas;
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
        if ($for == "delete") {
            $name = Dokumen::where('id', $message)->get();
            $this->deleteName = $name[0]['judul'];
        }
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

    public function refresh($data)
    {
        $badge = explode("|", $data);
        $this->badge = $badge;
    }
    public function data_dokumen($value, $get_pemohon, $status, $pengendali, $manager, $manajemen, $location)
    {
        $data = [
            'id' => $value->id,
            'identitas' => $value->id . 'ditinjau',
            'nomor' => $value->nomor,
            'judul' => $value->judul,
            'status' => $status,
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
        $data = [];
        $dokumen = new Dokumen();
        if (Gate::forUser(session('auth')[0]['id'])->allows('picOrPihakTerkait')) {
            $pic_query = $dokumen->whereHas('pics', function (Builder $query) {
                $query->where('role_id', session('auth')[0]['role']);
            })->get();

            if ($pic_query) {
                foreach ($pic_query as $value) {
                    $get_pemohon = Http::get(env("URL_API_GET_USER") . $value->pemohon);
                    $pics = collect($value->pics);
                    foreach ($pics->diff('role_id')->all() as $pic) {
                        if ($value->status != 2 && $pic->role_id == session('auth')[0]['role']) {
                            if ($pic->status == false) {
                                $data[] = $this->data_dokumen($value, $get_pemohon, 1, 'as_pic', 'as_pic', 'as_pic', "PIC");
                            } elseif ($value->status == true) {
                                $data[] = $this->data_dokumen($value, $get_pemohon, 3, 'as_pic', 'as_pic', 'as_pic', "PIC");
                            }
                        } elseif ($value->status == 2 && $pic->role_id == session('auth')[0]['role']) {
                            $data[] = $this->data_dokumen($value, $get_pemohon, 2, 'as_pic', 'as_pic', 'as_pic', "PIC");
                        }
                    }
                }
            }
            $pihakterkait_query = $dokumen->whereHas('pihakTerkaits', function (Builder $query) {
                $query->where('role_id', session('auth')[0]['role']);
            })->get();

            if ($pihakterkait_query) {
                foreach ($pihakterkait_query as $value) {
                    $get_pemohon = Http::get(env("URL_API_GET_USER") . $value->pemohon);
                    $pihakterkaits = collect($value->pihakTerkaits);
                    $pihakterkaits = $pihakterkaits->where('role_id', session('auth')[0]['role'])->first();
                    if ($pihakterkaits->role_id == session('auth')[0]['role'] && $value->status != 2 && $value->pic_status == true) {
                        if ($pihakterkaits->status == false) {
                            $data[] = $this->data_dokumen($value, $get_pemohon, 1, 'as_pihak_terkait', 'as_pihak_terkait', 'as_pihak_terkait', "Pihak Terkait");
                        } elseif ($pihakterkaits->role_id == session('auth')[0]['role'] && $pihakterkaits->status == true) {
                            $data[] = $this->data_dokumen($value, $get_pemohon, 3, 'as_pihak_terkait', 'as_pihak_terkait', 'as_pihak_terkait', "Pihak Terkait");
                        }
                    } elseif ($pihakterkaits->role_id == session('auth')[0]['role'] && $value->status == 2 && $value->pic_status == false) {
                        $data[] = $this->data_dokumen($value, $get_pemohon, 2, 'as_pihak_terkait', 'as_pihak_terkait', 'as_pihak_terkait', "Pihak Terkait");
                    }
                }
            }
        }
        if (Gate::forUser(session('auth')[0]['id'])->allows('management')) {
            $management_query = $dokumen->where('pic_status', true)->where('pihakterkait_status', true)->get();
            foreach ($management_query as $value) {
                $get_pemohon = Http::get(env("URL_API_GET_USER") . $value->pemohon);
                if ($value->status != 2 && $value->pic_status == true && $value->pihakterkait_status == true) {
                    if ($value->management_status == true) {
                        $data[] = $this->data_dokumen($value, $get_pemohon, 3, 'null', 'null', 'null', "Manajemen");
                    } elseif ($value->management_status == false) {
                        $data[] = $this->data_dokumen($value, $get_pemohon, 1, 'null', 'null', 'null', "Manajemen");
                    }
                } elseif ($value->status == 2 && $value->pic_status == false && $value->pihakterkait_status == false) {
                    $data[] = $this->data_dokumen($value, $get_pemohon, 2, 'null', 'null', 'null', "Manajemen");
                }
            }
        }

        if (Gate::forUser(session('auth')[0]['id'])->allows('pengendaliDokumen')) {
            $pengendali_query = $dokumen->get();
            foreach ($pengendali_query as $value) {
                $get_pemohon = Http::get(env("URL_API_GET_USER") . $value->pemohon);

                $pics_query = collect($value->pics);
                $pihakterkait_query = collect($value->pihakTerkaits);
                $pic = $pics_query->where('role_id', session('auth')[0]['role'])->where('status', false)->all();
                $pihakterkait = $pihakterkait_query->where('role_id', session('auth')[0]['role'])->where('status', false)->all();

                if (!$pic && !$pihakterkait && $value->status != 2 && $value->pic_status == true && $value->pihakterkait_status == true && $value->management_status == true) {
                    if ($value->pengendali_status == true) {
                        $data[] = $this->data_dokumen($value, $get_pemohon, 3, "not_pic_and_pihak_terkait", "null", "null", "Pengendali");
                    } elseif ($value->pengendali_status == false) {
                        $data[] = $this->data_dokumen($value, $get_pemohon, 1, "not_pic_and_pihak_terkait", "null", "null", "Pengendali");
                    }
                } elseif (!$pic && !$pihakterkait && $value->status == 2 && $value->pic_status == false && $value->pihakterkait_status == false && $value->management_status == false) {
                    $data[] = $this->data_dokumen($value, $get_pemohon, 2, "not_pic_and_pihak_terkait", "null", "null", "Pengendali");
                }
            }
        }

        $collect = collect($data);
        $data = $collect->sortBy([
            ['status', 'asc'],
            ['id', 'asc']
        ]);

        // dd($data->all());

        return view('livewire.page.peninjauan', [
            'data' => $data->all()
        ])->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
