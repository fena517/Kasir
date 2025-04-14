<?php

namespace App;

use App\Penjualan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Carbon\Carbon;

class Penjualan extends Model
{
    protected $table = 'penjualans';
    protected $primaryKey = 'PenjualanId';
    protected $fillable = [
        'TanggalPenjualan', 'TotalHarga', 'PelangganId'];

    public function pelanggan()
{
    return $this->belongsTo(Pelanggan::class, 'PelangganId', 'PelangganId');
}

    public function details()
    {
        return $this->hasMany(DetailPenjualan::class, 'PenjualanId');
    }

    public function produk()
    {
        return $this->hasManyThrough(Produk::class, DetailPenjualan::class, 'PenjualanId', 'ProdukId');
    }
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'PenjualanId', 'PenjualanId');
    }
}
