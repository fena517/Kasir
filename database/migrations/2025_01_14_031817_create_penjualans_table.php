<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->bigIncrements('PenjualanId');
            $table->date('TanggalPenjualan');
            $table->decimal('TotalHarga', 10, 2)->default(0);
            $table->unsignedBigInteger('PelangganId');
            $table->timestamps();

            $table->foreign('PelangganId')->references('PelangganId')->on('pelanggans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
}
