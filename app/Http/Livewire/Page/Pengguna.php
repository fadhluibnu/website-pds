<?php

namespace App\Http\Livewire\Page;

use App\Models\Dokumen;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Pengguna extends Component
{
    public $title = "Pengguna";
    public $search;
    public $nama;
    public $role;
    public $sortby;

    public function get_all_users()
    {
        $all_user_query = Http::withToken(session('token'))->get(env("URL_API_GET_USER"));
        $all_user_query = collect($all_user_query->json());

        $all_role_query = Http::withToken(session('token'))->get(env("URL_API_GET_ROLE"));
        $all_role_query = collect($all_role_query->json());
        // dd($all_user_query);

        $dokumen = Dokumen::all();

        $users = [];
        $total_dokumen = 0;
        $dokumen_selesai = 0;
        $dalam_proses = 0;
        foreach ($all_role_query as $role) {
            // if ($role['name'] != "Deactivated") {
            foreach ($all_user_query as $value) {
                if ($value['email'] != "test@test.com" && $value['email'] != "test@mail.com" && $value['email'] != "000001@test.com" && $value['email'] != "000002@test.com") {
                    if ($role['id'] == $value['role']) {
                        foreach (collect($dokumen) as $docx) {
                            if ($docx['pemohon'] == $value['id']) {
                                $total_dokumen += 1;
                                if ($docx['status'] == "Selesai") {
                                    $dokumen_selesai += 1;
                                }
                                if ($docx['status'] == "Ditinjau") {
                                    $dalam_proses += 1;
                                }
                            }
                        }
                        $users[] = [
                            'role_id' => $role['id'],
                            'nik' => $value['id'],
                            'name' => $value['name'],
                            'role' => $role['name'],
                            'email' => $value['email'],
                            'telp' => $value['telp'],
                            'photo' => $value['photo'],
                            'total_dokumen' => $total_dokumen,
                            'dokumen_selesai' => $dokumen_selesai,
                            'dalam_proses' => $dalam_proses,
                            'average' => round(collect([$total_dokumen, $dokumen_selesai, $dalam_proses])->avg())
                        ];
                        $total_dokumen = 0;
                        $dokumen_selesai = 0;
                        $dalam_proses = 0;
                    }
                }
            }
            // }
        }

        $users = collect($users)->sortByDesc('average');

        $result = [];
        foreach ($users as $value) {
            $result[] = [
                'nik' => $value['nik'],
                'name' => $value['name'],
                'role' => $value['role'],
                'email' => $value['email'],
                'telp' => $value['telp'],
                'photo' => $value['photo'],
                'average' => $value['average']
            ];
        }
        return $result;
    }

    public function fun_search()
    {
        $this->search = true;
    }

    public function search_operation($data)
    {
        $result = [];
        if ($this->role == null) {
            $this->role = "kosong";
        }
        for ($i_data = 0; $i_data <= count($data) - 1; $i_data++) {
            if ($this->nama == null && $this->role == "kosong") {
                $result[] = $data[$i_data];
            } elseif ($this->nama != null && $this->role != "kosong") {
                $split_data_nama = explode(strtolower($this->nama), strtolower($data[$i_data]['name']));
                if (count($split_data_nama) > 1 && $data[$i_data]['role'] == $this->role) {
                    $result[] = $data[$i_data];
                }
            } elseif ($this->nama == null && $this->role != "kosong") {
                if ($data[$i_data]['role'] == $this->role) {
                    $result[] = $data[$i_data];
                }
            } elseif ($this->nama != null && $this->role == "kosong") {
                $split_data_nama = explode(strtolower($this->nama), strtolower($data[$i_data]['name']));
                if (count($split_data_nama) > 1) {
                    $result[] = $data[$i_data];
                }
            }
        }
        return $result;
    }

    public function render()
    {
        if ($this->search == true) {
            $result = collect($this->get_all_users());
            $result = $this->search_operation($result);
        } else {
            $result = $this->get_all_users();
        }
        $all_role_query = Http::withToken(session('token'))->get(env("URL_API_GET_ROLE"));
        $all_role_query = collect($all_role_query->json());
        return view('livewire.page.pengguna', [
            'users' => collect($result),
            'roles' => $all_role_query
        ])->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
