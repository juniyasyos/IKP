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
        Schema::table('laporan_insidens', function (Blueprint $table) {
            // Data Pasien - sesuai form kertas
            $table->string('ruangan')->nullable()->after('nomor_rekam_medis');
            $table->integer('umur')->nullable()->after('ruangan');
            $table->enum('kelompok_umur', [
                '0-1 bulan',
                '>1 bulan - 1 tahun',
                '>1 tahun - 5 tahun',
                '>5 tahun - 15 tahun',
                '>15 tahun - 30 tahun',
                '>30 tahun - 65 tahun',
                '>65 tahun'
            ])->nullable()->after('umur');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('kelompok_umur');
            $table->enum('penanggung_biaya', [
                'Pribadi',
                'BPJS',
                'Asuransi Swasta',
                'Lainnya'
            ])->nullable()->after('jenis_kelamin');
            $table->dateTime('tanggal_masuk_rs')->nullable()->after('penanggung_biaya');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_insidens', function (Blueprint $table) {
            $table->dropColumn([
                'ruangan',
                'umur',
                'kelompok_umur',
                'jenis_kelamin',
                'penanggung_biaya',
                'tanggal_masuk_rs'
            ]);
        });
    }
};
