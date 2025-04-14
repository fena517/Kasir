<?php

namespace App;

use App\Pelanggan;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';
    protected $primaryKey = 'PelangganId';
    protected $fillable = ['NamaPelanggan','Alamat','NomorTelepon'];

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'PelangganId', 'PelangganId');
    } 
}
