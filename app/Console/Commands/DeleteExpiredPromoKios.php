<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\kios\KiosProduk;
use Illuminate\Console\Command;

class DeleteExpiredPromoKios extends Command
{
    protected $signature = 'app:delete-expired-promo-kios';
    protected $description = 'Command description';

    public function handle()
    {
        $expiredProducts = KiosProduk::where('end_promo', '<', Carbon::now())->get();

        foreach ($expiredProducts as $product) {
            $product->harga_promo = 0;
            $product->start_date_promo = null;
            $product->end_date_promo = null;
            $product->save();
        }

        $this->info('Expired promos have been deleted successfully.');
    }
}
