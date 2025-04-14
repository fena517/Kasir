<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->bigIncrements('DetailId');
            $table->unsignedBigInteger('PenjualanId');
            $table->unsignedBigInteger('ProdukId');
            $table->integer('JumlahProduk')->default(1);
            $table->integer('Harga')->notNull();
            $table->decimal('SubTotal', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('PenjualanId')->references('PenjualanId')->on('penjualans')->onDelete('cascade');
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
        Schema::dropIfExists('detail_penjualans');
    }
}
