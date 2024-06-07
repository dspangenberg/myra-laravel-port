<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
      if ($this->app->isLocal()) {
        $this->app->register(IdeHelperServiceProvider::class);
      }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
