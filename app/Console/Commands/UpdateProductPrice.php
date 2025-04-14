<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateProductPrice extends Command
{
    protected $signature = 'update:product-price'; // Ubah agar sesuai dengan Kernel.php
    protected $description = 'Update harga produk setiap minggu';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        DB::table('produks')->update([
            'Harga' => DB::raw('Harga * 1.1') // Kenaikan harga 10%
        ]);

        $this->info('Harga produk telah diperbarui.');
    }
}
