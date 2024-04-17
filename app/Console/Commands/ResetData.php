<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all data from all databases and tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $databases = ['rumahdrone_kios', 'rumahdrone_produk'];

        $protectedTables = ['produk_kategori', 'kios_akun_rd', 'kios_marketplace', 'status_pembayaran', 'produk_kategori', 'produk_status', 'produk_type'];

        foreach ($databases as $database) {

            config(['database.connections.mysql.database' => $database]);
            DB::reconnect();

            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            $tables = DB::select('SHOW TABLES');

            foreach ($tables as $table) {
                $tableName = reset($table);

                if (!in_array($tableName, $protectedTables)) {
                    DB::table($tableName)->truncate();
                    $this->info("Truncated table: $tableName");
                } else {
                    $this->info("Skipped table: $tableName");
                }
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            $this->info("Berhasil reset data pada database: $database");
        }

        return 0;

    }

}
