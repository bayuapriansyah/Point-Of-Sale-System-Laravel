<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('penerimaan_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('distributor')->nullable();
            $table->string('nomor_faktur')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });

        Schema::create('penerimaan_barang_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penerimaan_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty')->default(0);
            $table->decimal('harga_beli', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('penerimaan_id')->references('id')->on('penerimaan_barangs')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penerimaan_barang_items');
        Schema::dropIfExists('penerimaan_barangs');
    }
};
