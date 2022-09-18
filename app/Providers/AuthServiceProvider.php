<?php

namespace App\Providers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('engginer', function () {
            $data = session('auth');
            $engginer = ["Bagian UREL", "Lab Device", "Lab Energy", "Lab Kabel dan Aksesoris FTTH", "Lab Transmisi", "Lab Kalibrasi"];
            for ($i = 0; $i <= count($engginer) - 1; $i++) {
                if ($data[0]["role"] == $engginer[$i]) {
                    return true;
                }
            }
        });
        Gate::define('management', function () {
            $data = session('auth');
            return $data[0]['role'] == "SM IAS";
        });
        Gate::define('pengendaliDokumen', function () {
            $data = session('auth');
            if ($data[0]['role'] == "Document Controller 1" || $data[0]['role'] == "Document Controller 2") {
                return true;
            }
        });
        Gate::define('managerIqa', function () {
            $data = session('auth');
            return $data[0]['role'] == "Lab Manager IQA";
        });
        Gate::define('managerUrel', function () {
            $data = session('auth');
            return $data[0]['role'] == "Lab Manager UREL";
        });
        Gate::define('managerDeqa', function () {
            $data = session('auth');
            return $data[0]['role'] == "Lab Manager DEQA";
        });
        Gate::define('picOrPihakTerkait', function () {
            $data = session('auth')[0]['role'];
            $for = ["Lab Manager IQA", "Lab Manager UREL", "Lab Manager DEQA", "Document Controller 1", "SM IAS"];
            for ($i = 0; $i <= count($for) - 1; $i++) {
                if ($data == $for[$i]) {
                    return true;
                }
            }
        });
        Gate::define('manager', function () {
            $data = session('auth')[0]['role'];
            $for = ["Lab Manager IQA", "Lab Manager UREL", "Lab Manager DEQA"];
            for ($i = 0; $i <= count($for) - 1; $i++) {
                if ($data == $for[$i]) {
                    return true;
                }
            }
        });
    }
}
