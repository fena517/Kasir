<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stock_in extends Model
{
    protected $table = 'stock_ins';
    protected $primaryKey = 'MasukId';
    protected $fillable = [
        'ProdukId',
        'SupplierId',
        'Jumlah',
        'Harga',
        'Tgl'
    ];

    public function produk()
{
    return $this->belongsTo(Produk::class, 'ProdukId', 'ProdukId');
}
    
    public function supplier()
{
    return $this->belongsTo(supplier::class, 'SupplierId');
}
}
