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
        Schema::create('penyedia_sumber_dana', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paket_id');
            $table->foreign('paket_id')->references('id')->on('penyedia_paket');
            $table->integer('kode_rup');
            $table->integer('paket_terkonsolidasi');
            $table->string('sumber_dana');
            $table->integer('tahun_anggaran');
            $table->string('kl_pd');
            $table->string('kode_mak');
            $table->string('kode_subkegiatan');
            $table->string('kode_akun');
            $table->string('kode_klasifikasi_sh');
            $table->string('kode_standar_harga');
            $table->bigInteger('pagu_sumber_dana');
            $table->text('uraian_pekerjaan');
            $table->text('spesifikasi_pekerjaan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyedia_sumber_dana');
    }
};
