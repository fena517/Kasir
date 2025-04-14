<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';
    protected $primaryKey = 'PembayaranId';
    public $incrementing = true; // Sesuai dengan bigIncrements
    protected $keyType = 'int';
    protected $fillable = ['PenjualanId', 'MetodePembayaran', 'TotalDibayar', 'Kembalian', 'KodeTransaksi'];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'PenjualanId');
    }
}
