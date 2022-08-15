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
            return $data['user']['role']['id'] == 1;
        });
        Gate::define('osmtth', function () {
            $data = session('auth');
            return $data['user']['role']['id'] === 2;
        });
        Gate::define('management', function () {
            $data = session('auth');
            return $data['user']['role']['id'] == 3;
        });
        Gate::define('pengendaliDokumen', function () {
            $data = session('auth');
            return $data['user']['role']['id'] == 4;
        });
        Gate::define('managerIqa', function () {
            $data = session('auth');
            return $data['user']['role']['id'] == 5;
        });
        Gate::define('managerUrel', function () {
            $data = session('auth');
            return $data['user']['role']['id'] == 6;
        });
        Gate::define('managerDeqa', function () {
            $data = session('auth');
            return $data['user']['role']['id'] == 7;
        });
    }
}
