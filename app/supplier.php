<?php

namespace App;

use App\Supplier;
use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'SupplierId';
    protected $fillable = ['Nama','Alamat','Kontak'];

    public function stock_ins()
    {
        return $this->hasMany(stock_in::class, 'SupplierId');
    } 
}
