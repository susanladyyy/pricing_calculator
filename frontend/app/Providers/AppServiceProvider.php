<?php

namespace App\Providers;

use App\Models\University;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('components.navbar', function ($view) {
            if (Auth::check()) {
                $user = User::where('id', Auth::id())->first();
                $logo = University::where('id', $user->university_id)->first();
                $path = $logo->logo_path;

                $view->with('path', $path);
            }
        });
    }
}
