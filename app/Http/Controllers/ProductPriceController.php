<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Http\Request;

class ProductPriceController extends Controller
{
    public function updateProductPrices()
    {
        // Tambahkan timezone agar waktu sesuai
        $today = Carbon::now('Asia/Jakarta')->startOfDay();

        // Ambil semua produk yang memiliki harga terbaru
        $products = Product::all();

        foreach ($products as $product) {
            // Ambil harga terakhir
            $latestPrice = ProductPrice::where('product_id', $product->id)
                            ->orderBy('created_at', 'desc')
                            ->first();

            if ($latestPrice) {
                // Tambahkan 10% ke harga lama
                $newPrice = $latestPrice->price * 1.1;
                ProductPrice::create([
                    'product_id' => $product->id,
                    'price' => $newPrice,
                    'created_at' => $today,
                ]);
            }
        }

        return response()->json(['message' => 'Harga produk diperbarui!']);
    }
}
