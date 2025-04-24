<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->bigIncrements('ProdukId');
            $table->string('KodeProduk', 10)->unique();
            $table->string('NamaProduk', 100);
            $table->unsignedBigInteger('KategoriId');
            $table->unsignedBigInteger('UnitId');
            $table->decimal('Harga', 10, 2);
            $table->integer('stok')->default(0);
            $table->string('GambarProduk')->nullable();
            $table->timestamps();

            $table->foreign('KategoriId')->references('KategoriId')->on('kategoris')->onDelete('cascade');
            $table->foreign('UnitId')->references('UnitId')->on('units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produks');
    }
}
