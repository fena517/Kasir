<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    protected $table = 'produks';
    protected $primaryKey = 'ProdukId';
    protected $fillable = [
        'KodeProduk',
        'NamaProduk',
        'KategoriId',
        'UnitId',
        'Harga',
        'stok',
        'GambarProduk'
    ]; 

    public function stockIns()
    {
        return $this->hasMany(StockIn::class, 'ProdukId');
    } 

    public function stock_outs()
    {
        return $this->hasMany(stock_out::class, 'ProdukId');
    } 

    public function penjualans()
    {
        return $this->belongsToMany(Penjualan::class, 'detail_penjualans', 'ProdukId', 'PenjualanId');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'KategoriId');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'UnitId');
    }

    public function getDiscountedPrice()
    {
        $discount = $this->discount()->where('start_date', '<=', now())->where('end_date', '>=', now())->first();

        if ($discount) {
            return $this->Harga - ($this->Harga * $discount->discount_percent / 100);
        }

        return $this->Harga;
    }
    public function latestPrice()
    {
        return $this->hasOne(ProductPrice::class, 'product_id')->latest();
    }
}
