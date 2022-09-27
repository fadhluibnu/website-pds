<?php

namespace App\Http\Livewire\Page;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Pengguna extends Component
{
    public $title = "Pengguna";

    public function get_all_users()
    {

        $all_user_query = Http::withToken(session('token'))->get(env("URL_API_GET_USER"));
        $all_user_query = collect($all_user_query->json());

        $all_role_query = Http::withToken(session('token'))->get(env("URL_API_GET_ROLE"));
        $all_role_query = collect($all_role_query->json());

        $users = [];
        foreach ($all_role_query as $role) {
            foreach ($all_user_query as $value) {
                if ($role['name'] != "Deactivated") {
                    if ($role['id'] == $value['role']) {
                        $users[] = [
                            'role_id' => $role['id'],
                            'nik' => $value['id'],
                            'name' => $value['name'],
                            'role' => $role['name'],
                            'email' => $value['email'],
                            'telp' => $value['telp'],
                            'photo' => $value['photo']
                        ];
                    }
                }
            }
        }

        $users = collect($users)->sortBy('role_id');

        $result = [];
        foreach ($users as $value) {
            $result[] = [
                'nik' => $value['nik'],
                'name' => $value['name'],
                'role' => $value['role'],
                'email' => $value['email'],
                'telp' => $value['telp'],
                'photo' => $value['photo']
            ];
        }
        return $result;
    }

    public function render()
    {
        $result = $this->get_all_users();
        return view('livewire.page.pengguna', [
            'users' => collect($result)
        ])->extends("main")->section('content')->layoutData(['title' => $this->title]);
    }
}
