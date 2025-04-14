<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discounts';

    protected $fillable = ['product_id', 'discount_percent', 'start_date', 'end_date'];

    public function produk()
    {
        return $this->belongsTo(Product::class, 'product_id', 'ProdukId');
    }
}
