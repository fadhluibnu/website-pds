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
        'management' => 'null'
    ];
    public $kembalikan = [
        'for' => 'null',
        'id' => 'null'
    ];
    protected $listeners = [
        'closeModal' => 'handlerClose',
        'openKembalikan' => 'handlerKembalikan',
        'fromKembalikan' => 'handlerTinjau',
        // 'echo:for_pic,EventForPic' => 'notifyNewOrder'
    ];
    // public function notifyNewOrder($data, $badge)
    // {
    //     $role = session('auth')[0]['role'];
    //     for ($i = 0; $i < count($data['pic']) - 1; $i++) {
    //         if ($data['pic'][$i] == $role) {
    //             $this->update += 1;
    //         }
    //     }
    //     dd($badge);
    //     // session()->flash('badge', $badge);
    // }
    public function openModal($for, $message)
    {
        if ($for == "delete") {
            $name = Dokumen::where('id', $message)->get();
            $this->deleteName = $name[0]['judul'];
        }
        $this->modal['for'] = $for;
        $this->modal['message'] = $message;
    }
    public function openTinjau($for, $id, $pengendali, $manager, $management)
    {
        $this->tinjau['for'] = $for;
        $this->tinjau['id'] = $id;
        $this->tinjau['pengendali'] = $pengendali;
        $this->tinjau['manager'] = $manager;
        $this->tinjau['management'] = $management;
    }
    public function handlerTinjau($attr)
    {
        $this->tinjau['for'] = 'tinjau';
        $this->tinjau['id'] = $attr['id'];
        $this->tinjau['pengendali'] = $attr['pengendali'];
        $this->tinjau['manager'] = $attr['manager'];
        $this->tinjau['management'] = $attr['management'];
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
    public function handlerKembalikan($attr)
    {
        $this->kembalikan['for'] = 'kembalikan';
        $this->kembalikan['id'] = $attr['id'];
        $this->kembalikan['pengendali'] = $attr['pengendali'];
        $this->kembalikan['manager'] = $attr['manager'];
        $this->kembalikan['management'] = $attr['management'];
    }

    public function refresh($data)
    {
        $badge = explode("|", $data);
        $this->badge = $badge;
    }
    public function get_dokumen()
    {
        $data = [];
        $for_pt = [];
        if (Gate::forUser(session('auth')[0]['id'])->allows('picOrPihakTerkait')) {
            $for_pic = Dokumen::where('status', 1)->whereHas('pics', function (Builder $query) {
                $query->where('role_id', session('auth')[0]['role'])->where('status', false);
            })->where('judul', 'like', '%' . $this->judul . '%')->get();
            $for_pihak_terkait = Dokumen::where('status', 1)->whereHas('pihakTerkaits', function (Builder $query) {
                $query->where('role_id', session('auth')[0]['role'])->where('status', false);
            })->where('judul', 'like', '%' . $this->judul . '%')->get();

            if ($for_pic) {
                foreach ($for_pic as $item) {
                    $get_pemohon = Http::get(env("URL_API_GET_USER") . $item->pemohon);
                    $data[] = [
                        'id' => $item->id,
                        'nomor' => $item->nomor,
                        'judul' => $item->judul,
                        'status' => $item->status,
                        'pemohon' => $get_pemohon[0]['name'],
                        'photo' => $get_pemohon[0]['photo'],
                        'tgl' => $item->created_at,
                        'pengendali' => 'as_pic',
                        'manager' => 'as_pic',
                        'management' => 'null'
                    ];
                }
            }
            if ($for_pihak_terkait) {
                foreach ($for_pihak_terkait as $item) {
                    foreach ($item->pics as $pt) {
                        if ($pt->dokumen_id == $item->id && $pt->status == false) {
                            $for_pt = [
                                'dokumen_id' => $pt->dokumen_id
                            ];
                        }
                    }
                    if (count($for_pt) == 0) {
                        $get_pemohon = Http::get(env("URL_API_GET_USER") . $item->pemohon);
                        $data[] = [
                            'id' => $item->id,
                            'nomor' => $item->nomor,
                            'judul' => $item->judul,
                            'status' => $item->status,
                            'pemohon' => $get_pemohon[0]['name'],
                            'photo' => $get_pemohon[0]['photo'],
                            'tgl' => $item->created_at,
                            'pengendali' => 'as_pihak_terkait',
                            'manager' => 'as_pihak_terkait',
                            'management' => 'null'
                        ];
                    }
                }
            }
        }
        if (Gate::forUser(session('auth')[0]['id'])->allows('management')) {
            $data_management = [];
            $for_management = Dokumen::where('status', 1)->WhereNull('management')->get();
            foreach ($for_management as $item) {
                foreach ($item->pihakTerkaits as $key) {
                    if ($key->dokumen_id == $item->id  && $key->status == false) {
                        $data_management[] = $item->id;
                    }
                }
                foreach ($item->pics as $key) {
                    if ($key->dokumen_id == $item->id  && $key->status == false) {
                        $data_management[] = $item->id;
                    }
                }
            }
            $filters = collect($for_management)->whereNotIn('id', $data_management)->all();
            foreach ($filters as $item) {
                $last = 'null';
                if ($item->pengendali != null) {
                    $last = 'last_view';
                }
                $get_pemohon = Http::get(env("URL_API_GET_USER") . $item->pemohon);
                $data[] = [
                    'id' => $item->id,
                    'nomor' => $item->nomor,
                    'judul' => $item->judul,
                    'status' => $item->status,
                    'pemohon' => $get_pemohon[0]['name'],
                    'photo' => $get_pemohon[0]['photo'],
                    'tgl' => $item->created_at,
                    'pengendali' => 'null',
                    'manager' => 'null',
                    'management' => $last
                ];
            }
        }
        if (Gate::forUser(session('auth')[0]['id'])->allows('pengendaliDokumen')) {
            $data_pengendali = [];
            $for_pengendali = Dokumen::where('status', 1)->WhereNotNull('management')->where('pengendali', null)->get();
            foreach ($for_pengendali as $item) {
                foreach ($item->pihakTerkaits as $key) {
                    if ($key->dokumen_id == $item->id  && $key->status == false) {
                        $data_pengendali[] = $item->id;
                    }
                }
                foreach ($item->pics as $key) {
                    if ($key->dokumen_id == $item->id  && $key->status == false) {
                        $data_pengendali[] = $item->id;
                    }
                }
            }
            $filters = collect($for_pengendali)->whereNotIn('id', $data_pengendali)->all();
            foreach ($filters as $item) {
                $get_pemohon = Http::get(env("URL_API_GET_USER") . $item->pemohon);
                $data[] = [
                    'id' => $item->id,
                    'nomor' => $item->nomor,
                    'judul' => $item->judul,
                    'status' => $item->status,
                    'pemohon' => $get_pemohon[0]['name'],
                    'photo' => $get_pemohon[0]['photo'],
                    'tgl' => $item->created_at,
                    'pengendali' => 'not_pic_and_pihak_terkait',
                    'manager' => 'null',
                    'management' => 'null'
                ];
            }
        }
        return $this->datas = $data;
    }

    public function render()
    {
        $this->get_dokumen();
        return view('livewire.page.peninjauan', [
            'data' => $this->datas
        ])->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
