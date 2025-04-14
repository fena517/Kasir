<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->bigIncrements('PembayaranId');
            $table->unsignedBigInteger('PenjualanId'); 
            $table->string('MetodePembayaran');
            $table->decimal('TotalDibayar', 15, 2);
            $table->decimal('Kembalian', 15, 2);
            $table->string('KodeTransaksi')->unique();
            $table->timestamps();

            $table->foreign('PenjualanId')->references('PenjualanId')->on('penjualans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayarans');
    }
}
