<?php

namespace App\Http\Livewire\Layouts;

use Livewire\Component;

class Sidebar extends Component
{
    public $title;
    public $peninjauan;
    public $pengguna;
    public function mount($title)
    {
        $this->title = $title;
    }
    public function render()
    {
        $user = session('auth');
        $user = $user[0];

        $role = $user['role'];
        $manager_assambly = ['Lab Manager UREL', 'SM IAS', 'Lab Manager DEQA', 'Lab Manager IQA'];
        $all_access = ["Super Admin", "Document Controller 1", "Document Controller 2"];

        for ($i = 0; $i <= count($all_access) - 1; $i++) {
            if ($role == $all_access[$i]) {
                $this->peninjauan = true;
                $this->pengguna = true;
            }
        }
        for ($i = 0; $i <= count($manager_assambly) - 1; $i++) {
            if ($role == $manager_assambly[$i]) {
                $this->peninjauan = true;
            }
        }
        return view('livewire.layouts.sidebar', [
            'user' => $user,
        ]);
    }
}
