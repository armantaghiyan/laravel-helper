<?php

namespace Arman\LaravelHelper\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'helper:cc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clear cache';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');

        $this->info('Cleared.');
    }
}