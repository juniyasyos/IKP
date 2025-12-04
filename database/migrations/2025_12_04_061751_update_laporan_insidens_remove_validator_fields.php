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
            // Hapus field yang tidak diperlukan di form pelaporan (akan diisi validator)
            $table->dropColumn(['analisis_penyebab', 'rekomendasi']);

            // Catatan: grading_risiko sudah nullable dari awal, tindakan_dilakukan tetap ada (diisi pelapor)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_insidens', function (Blueprint $table) {
            // Kembalikan field yang dihapus
            $table->text('analisis_penyebab')->nullable();
            $table->text('rekomendasi')->nullable();
        });
    }
};
