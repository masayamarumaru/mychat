<?php

namespace App\Providers\ViewComposers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\User;

class ComposerSearviceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
      View::composer('*', function ($view) {
        $users = User::get();
          $view->with('global_users', $users);
      });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
