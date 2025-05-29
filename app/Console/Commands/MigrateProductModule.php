<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Console\Migrations\MigrateCommand;

class MigrateProductModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:migrate-product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Executando migrations do módulo Product...');

        Artisan::call('migrate', [
            '--path' => 'app/Module/Product/Database/Migrations',
            '--database' => 'mysql_product_api',
        ]);

        $this->info(Artisan::output());
    }
}
