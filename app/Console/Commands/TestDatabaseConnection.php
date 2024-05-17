<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestDatabaseConnection extends Command
{
    protected $signature = 'db:test-connection {connection?}';
    protected $description = 'Test database connection';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $connection = $this->argument('connection') ?: 'default';

        try {
            DB::connection($connection)->getPdo();
            $this->info('Berhasil terhubung ke database ' . $connection . '.');
        } catch (Exception $e) {
            $this->error('Tidak bisa terhubung ke database ' . $connection . '.');
            $this->error($e->getMessage());
        }
    }
}
