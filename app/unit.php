<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class unit extends Model
{
    protected $table = 'units';
    protected $primaryKey = 'UnitId';
    protected $fillable = [
        'Nama',
    ];
}
