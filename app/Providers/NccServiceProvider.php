<?php
namespace App\Providers;
use App\Library\Services\NccSharedMethods;
use Illuminate\Support\ServiceProvider;

class NccServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\Contracts\NccServiceInterface', function ($app) {
            return new NccSharedMethods();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
