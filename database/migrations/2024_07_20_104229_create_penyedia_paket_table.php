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
        Schema::create('penyedia_paket', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->integer('kode_rup');
            $table->integer('paket_terkonsolidasi');
            $table->text('paket');
            $table->bigInteger('pagu');
            $table->string('id_kldi');
            $table->string('kldi');
            $table->integer('id_satker');
            $table->string('satuan_kerja');
            $table->text('sumber_dana');
            $table->integer('id_referensi');
            $table->string('ids_lokasi');
            $table->integer('id_lokasi');
            $table->string('lokasi');
            $table->integer('id_bulan');
            $table->string('pemilihan');
            $table->integer('id_metode');
            $table->string('metode');
            $table->integer('id_jenis_pengadaan');
            $table->string('jenis_pengadaan');
            $table->boolean('is_pdn');
            $table->boolean('is_umk');
            $table->boolean('pds');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyedia_paket');
    }
};
