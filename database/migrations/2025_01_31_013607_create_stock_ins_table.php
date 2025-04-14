<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_ins', function (Blueprint $table) {
            $table->bigIncrements('MasukId');
            $table->unsignedBigInteger('ProdukId');
            $table->unsignedBigInteger('SupplierId');
            $table->integer('Jumlah');
            $table->decimal('Harga', 10, 2);
            $table->date('Tgl');
            $table->date('Kadaluarsa');
            $table->timestamps();

            $table->foreign('ProdukId')->references('ProdukId')->on('produks')->onDelete('cascade');
            $table->foreign('SupplierId')->references('SupplierId')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_ins');
    }
}
