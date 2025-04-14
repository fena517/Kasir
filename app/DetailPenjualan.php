<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPenjualan extends Model
{
    protected $table = 'detail_penjualans';
    protected $primaryKey = 'DetailId';
    protected $fillable = [
        'PenjualanId',
        'ProdukId',
        'JumlahProduk',
        'Harga',  
        'SubTotal'
    ];

        public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'PenjualanId');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'ProdukId');
    }
    public function getHargaSatuanAttribute()
    {
        return $this->produk->Harga ?? 0; // Pastikan harga ada di tabel Produk
    }
    public static function boot()
    {
        parent::boot();

        static::saving(function ($detail) {
            $detail->SubTotal = ($detail->Harga ?? 0) * $detail->JumlahProduk;
        });
    }
}
