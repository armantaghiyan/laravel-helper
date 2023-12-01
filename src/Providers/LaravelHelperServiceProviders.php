<?php

namespace Arman\LaravelHelper\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class LaravelHelperServiceProviders extends ServiceProvider
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
        $this->loadHelpers();
        $this->publishedFiles();
    }

    public function loadHelpers()
    {
        $helperFiles = config('helper.files');
        if (gettype($helperFiles) === 'array') {
            foreach ($helperFiles as $file) {
                require_once($file);
            }
        }
    }

    public function publishedFiles()
    {
        $this->publishes([
            __DIR__ . '/../config/helper.php' => config_path('helper.php'),
            __DIR__ . '/../Extras/consts.php' => app_path('Extras/consts.php'),
            __DIR__ . '/../Extras/helpers.php' => app_path('Extras/helpers.php'),
        ], 'files');
    }
}
