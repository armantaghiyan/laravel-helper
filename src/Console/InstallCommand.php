<?php

namespace Arman\LaravelHelper\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'helper:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install laravel helper';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->callSilent('vendor:publish', ['--tag' => 'laravel-helper']);
        $this->info('install successfully.');
    }
}