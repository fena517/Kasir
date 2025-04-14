<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_outs', function (Blueprint $table) {
            $table->bigIncrements('KeluarId');
            $table->unsignedBigInteger('ProdukId');
            $table->integer('Jumlah');
            $table->date('Tgl');
            $table->text('Alasan');
            $table->timestamps();

            $table->foreign('ProdukId')->references('ProdukId')->on('produks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_outs');
    }
}
