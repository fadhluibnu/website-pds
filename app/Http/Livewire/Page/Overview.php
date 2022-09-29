<?php

namespace App\Http\Livewire\Page;

use App\Models\Dokumen;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;

class Overview extends Component
{
    use WithPagination;
    public $title  = "Overview";
    public $index_paginate = 0;
    public $q_tinjau = null;
    public $q_tracking = null;
    public $monitor_id;
    public $dataTinjau;
    public $modal = [
        'for' => 'null',
        'message' => 'null',
    ];
    public $tinjau = [
        'for' => 'null',
        'id' => 'null',
        'as_view' => 'null',
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

    // tracking monitor

    // To PIC
    public $rellToPicRed;
    public $rellToPicBlue;
    public $pic;

    // to pihak terkiat
    public $pihakterkait;
    public $rellToPihakTerkaitRed;
    public $rellToPihakTerkaitBlue;

    // to management
    public $manajemen;
    public $rellToManagemenRed;
    public $rellToManagemenBlue;

    // to pengendali
    public $pengendali;
    public $rellToPengendaliRed;
    public $rellToPengendaliBlue;

    // public function mount()
    // {
    // }

    public function openModal($for, $message)
    {
        $this->modal['for'] = $for;
        $this->modal['message'] = $message;
    }
    public function openTinjau($for, $id, $as_view, $location)
    {
        $this->tinjau['for'] = $for;
        $this->tinjau['id'] = $id;
        $this->tinjau['as_view'] = $as_view;
        $this->tinjau['location'] = $location;
    }
    public function handlerTinjau($attr)
    {
        $this->tinjau['for'] = 'tinjau';
        $this->tinjau['id'] = $attr['id'];
        $this->tinjau['as_view'] = $attr['location'];
        $this->tinjau['location'] = $attr['location'];
    }
    public function handlerKembalikan($attr)
    {
        $this->kembalikan['for'] = 'kembalikan';
        $this->kembalikan['id'] = $attr['id'];
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
            session()->flash('tinjau', "PDS Berhasil Di Tinjau");
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

    public function activity()
    {
        // Dokumen Diupload
        $activity = [
            "diupload" => 0,
            "disahkan" => 0,
            'proses' => 0
        ];
        $diupload_query = new Dokumen();
        $activity['diupload'] = count($diupload_query->where('pemohon', session('auth')[0]['id'])->get());
        $activity['disahkan'] = count($diupload_query->where('pemohon', session('auth')[0]['id'])->where('status', 3)->get());
        $activity['proses'] = count($diupload_query->where('pemohon', session('auth')[0]['id'])->where('status', 1)->get());

        return $activity;
    }

    // Mengambil Dokumen Yang Harus Ditinjau Dan Hilang Setelah Di Tinjau
    public function get_dokumens($search)
    {
        $data = [];
        $dokumen  = Dokumen::latest()->get();

        $all_user_query = Http::withToken(session('token'))->get(env("URL_API_GET_USER"));
        $all_user = $all_user_query->json();
        foreach ($dokumen as $item) {
            $check_for_pihakterkait = 0;
            $check_for_management = 0;
            if ($item->pic != null) {
                $pics_explode = explode("|", $item->pic);
                for ($i_explode = 1; $i_explode <= count($pics_explode) - 1; $i_explode++) {
                    $pic_status = explode(":", $pics_explode[$i_explode]);
                    $pemohon = collect($all_user)->where('id', $item->pemohon)->first();
                    if ($pic_status[0] == session('auth')[0]['role'] && $pic_status[1] == "false" && $item->status == 'Ditinjau') {
                        $data[] = $this->store_datas($item, "Ditinjau", $pemohon, 'pic');
                    }
                    if ($pic_status[1] == 'false') {
                        $check_for_pihakterkait += 1;
                        $check_for_management += 1;
                    }
                }
            }
            if ($item->pihak_terkait != null) {
                if ($check_for_pihakterkait == 0) {
                    $pihakterkaits_explode = explode("|", $item->pihak_terkait);
                    for ($i_explode = 1; $i_explode <= count($pihakterkaits_explode) - 1; $i_explode++) {
                        $pihakterkait_status = explode(":", $pihakterkaits_explode[$i_explode]);
                        $pemohon = collect($all_user)->where('id', $item->pemohon)->first();
                        if ($pihakterkait_status[0] == session('auth')[0]['role'] && $pihakterkait_status[1] == "false" && $item->status == 'Ditinjau') {
                            $data[] = $this->store_datas($item, "Ditinjau", $pemohon, 'pihak_terkait');
                        }

                        // check unutuk management
                        if ($pihakterkait_status[1] == "false") {
                            $check_for_management += 1;
                        }
                    }
                }
            }

            // -sebagai management
            if (Gate::forUser(session('auth')[0]['id'])->allows('management')) {
                if ($check_for_management == 0) {
                    if ($item->management == null && $item->status == 'Ditinjau') {
                        $data[] = $this->store_datas($item, "Ditinjau", $pemohon, 'management');
                    }
                }
            }

            // sebagai pengendali dokumen
            if (Gate::forUser(session('auth')[0]['id'])->allows('pengendaliDokumen')) {
                if ($item->management != null) {
                    if ($item->pengendali_dokumen == null && $item->status == 'Ditinjau') {
                        $data[] = $this->store_datas($item, "Ditinjau", $pemohon, 'pengendali_dokumen');
                    }
                }
            }
        }
        if ($search != null) {
            $s_result = [];
            foreach (collect($data) as $item) {
                $explode = explode(strtolower($search), strtolower($item['judul']));
                if (count($explode) > 1) {
                    $s_result[] = [
                        'id' => $item['id'],
                        'identitas' => $item['id'] . $item['status'],
                        'nomor' => $item['nomor'],
                        'judul' => $item['judul'],
                        'status' => $item['status'],
                        'pemohon' => $item['pemohon'],
                        'photo' => $item['photo'],
                        'tgl' => $item['tgl'],
                        'location' => $item['location'],
                        'as_view' =>  $item['as_view']
                    ];
                }
            }
            return $s_result;
        }
        return $data;
    }

    // funtion yang mengembalikan array data, funtion ini di panggil oleh funtion get_dokumens() yang nanti return dari funtion store_datas() akan disimpan ke variable data di funtion get_dokumens()
    public function store_datas($value, $status, $get_pemohon, $as_view)
    {
        $data = [
            'id' => $value->id,
            'identitas' => $value->id . $status,
            'nomor' => $value->nomor,
            'judul' => $value->judul,
            'status' => $status,
            'pemohon' => $get_pemohon['name'],
            'photo' => $get_pemohon['photo'],
            'tgl' => $value->created_at,
            'location' => $value->location,
            'as_view' =>  $as_view
        ];
        return $data;
    }

    public function showInMonitor($id)
    {
        $this->monitor_id = $id;
    }

    public function tracking_document($search)
    {
        $data = [];
        $dokumen = Dokumen::where('pemohon', session('auth')[0]['id'])->where('status', '!=', 'Selesai')->get();
        $dokumen = collect($dokumen)->sortDesc();
        foreach ($dokumen as $value) {
            $data[] = $this->store_tracking($value);
        }
        if ($search != null) {
            $s_result = [];
            foreach (collect($data) as $item) {
                $explode = explode(strtolower($search), strtolower($item['judul']));
                if (count($explode) > 1) {
                    $s_result[] = $this->store_tracking($item);
                }
            }
            return $s_result;
        }
        return $data;
    }

    public function monitor($id)
    {
        if ($id != null) {
            $data = Dokumen::where('id', $id)->first();

            return $this->store_tracking($data);
        }
        $data = $this->tracking_document(null);
        if ($id == null && $data != null) {
            $data = $data[0];
            return collect($data);
        }
    }

    public function store_tracking($value)
    {
        $data = [
            'id' => $value['id'],
            'nomor' => $value['nomor'],
            'judul' => $value['judul'],
            'status' => $value['status'],
            'pic' => $value['pic'],
            'pihak_terkait' => $value['pihak_terkait'],
            'management' => $value['management'],
            'pengendali_dokumen' => $value['pengendali_dokumen'],
            'location' => $value['location']
        ];
        return $data;
    }

    public function paginate($index)
    {
        $this->index_paginate = $index;
    }

    public function render()
    {
        $data = $this->get_dokumens($this->q_tinjau);
        $paginate = collect($data)->chunk(5)->all();
        if ($this->q_tinjau != null) {
            $data = collect($data)->chunk(5)->all();
            $data = collect($data[$this->index_paginate]);
        } else {
            $data = collect($data);
        }
        $tracking = collect($this->tracking_document($this->q_tracking));
        $monitor = $this->monitor($this->monitor_id);
        if (count(collect($monitor)) == 0) {
            $monitor = null;
        } else {
            $monitor = collect($monitor);

            // handler to pic
            if ($monitor['location'] == 'PIC' && $monitor['status'] == 'Dikembalikan') {
                $this->rellToPicRed = 'active';
                $this->rellToPicBlue = 'off';
                $this->pic = 'bg-danger text-white';
            }
            if ($monitor['location'] != 'PIC' && $monitor['status'] == 'Dikembalikan') {
                $this->rellToPicRed = 'off';
                $this->rellToPicBlue = 'active';
                $this->pic = 'active';
            }
            if ($monitor['location'] == 'PIC' && $monitor['status'] == 'Ditinjau') {
                $this->rellToPicRed = 'off';
                $this->rellToPicBlue = 'active';
                $this->pic = 'active on';
            }

            if ($monitor['location'] != 'PIC' && $monitor['status'] == 'Ditinjau' && $monitor['pic'] != null) {
                $this->rellToPicRed = 'off';
                $this->rellToPicBlue = 'active';
                $this->pic = 'active';
            }

            // handler to pihak terkait
            $this->pihakterkait = 'off';
            $this->rellToPihakTerkaitRed = 'off';
            $this->rellToPihakTerkaitBlue = 'off';
            if ($monitor['location'] == 'pihak_terkait' && $monitor['status'] == 'Dikembalikan') {
                $this->rellToPihakTerkaitRed = 'active';
                $this->rellToPihakTerkaitBlue = 'off';
                $this->pihakterkait = 'bg-danger text-white';
            }
            if ($monitor['location'] != 'pihak_terkait' && $monitor['location'] != 'PIC' && $monitor['status'] == 'Dikembalikan') {
                $this->rellToPihakTerkaitRed = 'off';
                $this->rellToPihakTerkaitBlue = 'active';
                $this->pihakterkait = 'active';
            }
            if ($monitor['location'] == 'pihak_terkait' && $monitor['status'] == 'Ditinjau') {
                $this->rellToPihakTerkaitRed = 'off';
                $this->rellToPihakTerkaitBlue = 'active';
                $this->pihakterkait = 'active on';
            }
            if ($monitor['location'] != 'PIC' && $monitor['location'] != 'pihak_terkait' && $monitor['status'] == 'Ditinjau' && $monitor['pihak_terkait'] != null) {
                $this->rellToPihakTerkaitRed = 'off';
                $this->rellToPihakTerkaitBlue = 'active';
                $this->pihakterkait = 'active';
            }

            // handler to management
            $this->manajemen = "off";
            $this->rellToManagemenRed = "off";
            $this->rellToManagemenBlue = "off";
            if ($monitor['location'] == 'management' && $monitor['status'] == 'Dikembalikan') {
                $this->rellToManagemenRed = 'active';
                $this->rellToManagemenBlue = 'off';
                $this->manajemen = 'bg-danger text-white';
            }
            if ($monitor['location'] != 'management' && $monitor['location'] != 'pihak_terkait' && $monitor['location'] != 'PIC' && $monitor['status'] == 'Dikembalikan') {
                $this->rellToManagemenRed = 'off';
                $this->rellToManagemenBlue = 'active';
                $this->manajemen = 'active';
            }
            if ($monitor['location'] == 'management' && $monitor['status'] == 'Ditinjau') {
                $this->rellToManagemenRed = 'off';
                $this->rellToManagemenBlue = 'active';
                $this->manajemen = 'active on';
            }
            if ($monitor['location'] != 'management' && $monitor['status'] == 'Ditinjau' && $monitor['management'] != null) {
                $this->rellToManagemenRed = 'off';
                $this->rellToManagemenBlue = 'active';
                $this->manajemen = 'active';
            }

            // handler to pengendali
            $this->pengendali = "off";
            $this->rellToPengendaliRed = "off";
            $this->rellToPengendaliBlue = "off";

            if ($monitor['location'] == 'pengendali_dokumen' && $monitor['status'] == 'Dikembalikan') {
                $this->rellToPengendaliRed = 'active';
                $this->rellToPengendaliBlue = 'off';
                $this->pengendali = 'bg-danger text-white';
            }
            if ($monitor['location'] != 'pengendali_dokumen' && $monitor['location'] != 'management' && $monitor['location'] != 'pihak_terkait' && $monitor['location'] != 'PIC' && $monitor['status'] == 'Dikembalikan') {
                $this->rellToPengendaliRed = 'off';
                $this->rellToPengendaliBlue = 'active';
                $this->pengendali = 'active';
            }
            if ($monitor['location'] == 'pengendali_dokumen' && $monitor['status'] == 'Ditinjau') {
                $this->rellToPengendaliRed = 'off';
                $this->rellToPengendaliBlue = 'active';
                $this->pengendali = 'active on';
            }
            if ($monitor['location'] != 'pengendali_dokumen' && $monitor['status'] == 'Ditinjau' && $monitor['pengendali_dokumen'] != null) {
                $this->rellToPengendaliRed = 'off';
                $this->rellToPengendaliBlue = 'active';
                $this->pengendali = 'active';
            }
        }
        $activity = collect($this->activity());

        // $data = [];
        // $tracking = [];
        // $monitor = null;
        // $activity = [
        //     "diupload" => 0,
        //     "disahkan" => 0,
        //     'proses' => 0
        // ];

        $need_follow_up_section = 'd-none';
        if (Gate::forUser(session('auth')[0]['id'])->allows('picOrPihakTerkait')) {
            $need_follow_up_section = '';
        }

        return view('livewire.page.overview', [
            'activity' => collect($activity),
            'data' => $data,
            'tracking' => collect($tracking),
            'monitor' => $monitor,
            'need_follow_up' => $need_follow_up_section,
            'paginate' => count($paginate) - 1
        ])->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
