<?php

namespace Arman\LaravelHelper\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use function Laravel\Prompts\select;
use Throwable;

class CreateConstCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'helper:const';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate const';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $tables = $this->getAllTablesName();

        $table = select(
            'please select table',
            $tables,
        );

        $columns = array_diff(Schema::getColumnListing($table), ['created_at', 'updated_at']);

        $tableUpperCase = \Illuminate\Support\Str::upper($table);
        $tableSingularName = \Illuminate\Support\Str::singular($tableUpperCase);

        $text = "\n\nconst TB_$tableUpperCase = '$table';\n";
        foreach ($columns as $colum) {
            $columUpperCase = \Illuminate\Support\Str::upper($colum);
            $text .= "const COL_${tableSingularName}_$columUpperCase = '$colum';\n";
        }

        try {
            file_put_contents(app_path('Extras/consts.php'), $text, FILE_APPEND);
            $this->info('mission accomplished.');
        } catch (Throwable $e) {
            $this->error('mission failed.');
        }
    }

    public function getAllTablesName()
    {
        $tables = [];
        $result = DB::select('SHOW TABLES');

        foreach ($result as $item) {
            foreach ($item as $key => $value)
                $tables[] = $value;
        }

        return $tables;
    }
}