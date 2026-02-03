<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\InterfaceProduct;
use App\Repositories\DBProduct;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register():void{
     $this->app->bind(InterfaceProduct::class, DBProduct::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
