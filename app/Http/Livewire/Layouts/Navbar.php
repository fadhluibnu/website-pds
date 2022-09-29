<?php

namespace App\Http\Livewire\Layouts;

use App\Models\Dokumen;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

class Navbar extends Component
{
    public $title;
    public $s_overview;

    public $search_target = [
        'container' => '',
        'form' => '',
        'search_result' => ''
    ];
    public function mount($title)
    {
        $this->title = $title;
    }

    public function search_operation($search)
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

    public function render()
    {
        return view('livewire.layouts.navbar', [
            'peninjauan' => collect($peninjauan)
        ]);
    }
}
