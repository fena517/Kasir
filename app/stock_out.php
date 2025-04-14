<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stock_out extends Model
{
    protected $table = 'stock_outs';
    protected $primaryKey = 'KeluarId';
    protected $fillable = [
        'ProdukId',
        'Jumlah',
        'Tgl',
        'Alasan'
    ];

    public function produk()
{
    return $this->belongsTo(Produk::class, 'ProdukId', 'ProdukId');
}
}
