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
        $databases = ['rumahdrone_ekspedisi', 'rumahdrone_kios'];

        $protectedTables = [
            'ekspedisi', 'jenis_layanan', 
            'daily_recap', 'kios_akun_rd', 'kios_alasan_jual', 'kios_kategori_permasalahan', 'kios_marketplace', 'kios_recap_keperluan', 'kios_recap_ts', 'kios_recap_ts_produk', 'kios_technical_support', 'kios_status_komplain', 'kios_want_to_buy', 'kios_want_to_sell', 'metode_pembelian_second', 'status_pembayaran'];

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
