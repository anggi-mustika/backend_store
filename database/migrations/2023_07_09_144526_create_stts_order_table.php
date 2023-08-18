<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stts_order', function (Blueprint $table) {
            $table->id();
            $table->integer('jml_pesanan');
            $table->integer('sub_total');
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('pesanan_id');

            $table->foreign('barang_id')->references('id')->on('barang')->on('pesanan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('users_id')->references('id')->on('users')->on('pesanan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pesanan_id')->references('id')->on('pesanan')->on('pesanan')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stts_order');
    }
};
