<?php

namespace App;

use App\Kategori;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    protected $table = 'kategoris';
    protected $primaryKey = 'KategoriId';
    protected $fillable = [
        'Nama',
    ];

}
