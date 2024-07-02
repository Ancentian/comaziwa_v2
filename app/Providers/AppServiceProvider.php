<?php

namespace App\Providers;
use Illuminate\Support\Facades\Blade;

use Illuminate\Support\ServiceProvider;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&  $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $this->app['request']->server->set('HTTPS', true);
        }

        //Blade directive to format number into required format.
        Blade::directive('num_format', function ($expression) {
            return "number_format($expression, 2, '.', ',')";
        });

        //Blade directive to format number into required format.
        Blade::directive('usercan', function ($expression) {
            $role = Role::findOrFail(auth()->user()->role_id);
            $permissions = $role->permissions->pluck('name')->toArray(); 

            if(in_array($expression,$permissions)){
                return true;
            }else{
                return false;
            }
        });

        //Blade directive to format number into required format.
        Blade::directive('format_date', function ($expression) {
            return "date('dd-mm-YYYY',strtotime($expression))";
        });

        //Blade directive to format number into required format.
        Blade::directive('format_datetime', function ($expression) {
            return "date('dd-mm-YYYY H:i',strtotime($expression))";
        });
    }
}
