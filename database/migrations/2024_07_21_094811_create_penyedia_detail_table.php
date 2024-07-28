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
        Schema::create('penyedia_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paket_id');
            $table->foreign('paket_id')->references('id')->on('penyedia_paket');
            $table->integer('kode_rup');
            $table->integer('paket_terkonsolidasi');
            $table->integer('tahun_anggaran');
            $table->string('nama_klpd');
            $table->string('satuan_kerja');
            $table->string('paket');
            $table->string('volume_pekerjaan');
            $table->bigInteger('total_pagu');
            $table->string('metode_pemilihan');
            $table->integer('produk_dalam_negeri');
            $table->integer('usaha_kecil_koperasi');
            $table->string('tanggal_umumkan_paket');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyedia_detail');
    }
};
