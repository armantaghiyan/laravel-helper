<?php

namespace Arman\LaravelHelper\Providers;

use Arman\LaravelHelper\Console\ClearCacheCommand;
use Arman\LaravelHelper\Console\CreateConstCommand;
use Arman\LaravelHelper\Console\InstallCommand;
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
        $this->registerCommands();
        $this->loadHelpers();
        $this->publishedFiles();
    }

    private function loadHelpers()
    {
        $helperFiles = config('helper.files');
        if (gettype($helperFiles) === 'array') {
            foreach ($helperFiles as $file) {
                require_once($file);
            }
        }
    }

    private function publishedFiles()
    {
        $this->publishes([
            __DIR__ . '/../config/helper.php' => config_path('helper.php'),
            __DIR__ . '/../Extras/consts/response.php' => app_path('Extras/consts/response.php'),
            __DIR__ . '/../Extras/consts/result.php' => app_path('Extras/consts/result.php'),
            __DIR__ . '/../Extras/consts/storage.php' => app_path('Extras/consts/storage.php'),
            __DIR__ . '/../Extras/consts/cols.php' => app_path('Extras/consts/cols.php'),
        ], 'laravel-helper');
    }

    /**
     * Register the package's commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                ClearCacheCommand::class,
                CreateConstCommand::class,
            ]);
        }
    }
}
