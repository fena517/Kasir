<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detail_penjualan extends Model
{
    protected $table = 'detail_penjualans';
    protected $primaryKey = 'DetailId';
    protected $fillable = [
        'PenjualanId',
        'ProdukId',
        'JumlahProduk',
        'SubTotal'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'PelangganId');
    }

        public function Penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'PenjualanId');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'ProdukId');
    }
}
