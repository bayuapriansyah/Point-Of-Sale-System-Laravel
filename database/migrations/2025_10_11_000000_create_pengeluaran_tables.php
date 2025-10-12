<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pengeluaran_barangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->decimal('total', 15, 2)->default(0);
            $table->decimal('jumlah_bayar', 15, 2)->nullable();
            $table->decimal('kembalian', 15, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('pengeluaran_barang_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengeluaran_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty')->default(0);
            $table->decimal('harga_jual', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('pengeluaran_id')->references('id')->on('pengeluaran_barangs')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengeluaran_barang_items');
        Schema::dropIfExists('pengeluaran_barangs');
    }
};
