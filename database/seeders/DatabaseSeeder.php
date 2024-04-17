<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::connection('rumahdrone_kios')->table('kios_akun_rd')->insert([
            ['nama_akun' => 'BCA Kios'],
            ['nama_akun' => 'BCA PT Odo Multi Aero'],
            ['nama_akun' => 'BCA PT Rumah Drone'],
            ['nama_akun' => 'BCA Repair'],
            ['nama_akun' => 'BNI'],
            ['nama_akun' => 'Mandiri'],
            ['nama_akun' => 'Mandiri PT Odo Multi Aero'],
            ['nama_akun' => 'Mandiri PT Rumah Drone'],
            ['nama_akun' => 'Kas Tunai'],
            ['nama_akun' => 'Bukalapak'],
            ['nama_akun' => 'Shopee'],
            ['nama_akun' => 'Tokopedia'],
            
        ]);

        DB::connection('rumahdrone_kios')->table('kios_marketplace')->insert([
            ['nama' => 'Tokopedia'],
            ['nama' => 'Shopee'],
            ['nama' => 'Facebook'],
            ['nama' => 'Komunitas'],
            ['nama' => 'Partner'],
        ]);

        DB::connection('rumahdrone_kios')->table('status_pembayaran')->insert([
            ['status_pembayaran' => 'DP'],
            ['status_pembayaran' => 'Paid'],
            ['status_pembayaran' => 'Unpaid'],
            ['status_pembayaran' => 'Refund'],
        ]);

        // Seeder untuk Database 2
        DB::connection('rumahdrone_produk')->table('produk_kategori')->insert([
            ['nama' => 'Agriculture'],
            ['nama' => 'Consumer'],
            ['nama' => 'Enterprise'],
            ['nama' => 'Handheld'],
        ]);

        DB::connection('rumahdrone_produk')->table('produk_status')->insert([
            ['status_produk' => 'Part Baru'],
            ['status_produk' => 'Part Bekas'],
            ['status_produk' => 'Produk Baru'],
            ['status_produk' => 'Produk Bekas'],
        ]);

        DB::connection('rumahdrone_produk')->table('produk_type')->insert([
            ['type' => 'Drone', 'code' => 'DR'],
            ['type' => 'Handheld', 'code' => 'HH'],
            ['type' => 'Goggles', 'code' => 'GG'],
            ['type' => 'Accessories', 'code' => 'ACC'],
            ['type' => 'Remote Controller', 'code' => 'RC'],
            ['type' => 'Battery', 'code' => 'BTR'],
        ]);
    }
}
