<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanInsiden extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nama_pelapor',
        'unit_kerja',
        'nomor_telepon',
        'tanggal_lapor',
        'nomor_laporan',
        'jenis_insiden',
        'tanggal_insiden',
        'waktu_insiden',
        'lokasi_insiden',
        'nama_pasien',
        'nomor_rekam_medis',
        'ruangan',
        'umur',
        'kelompok_umur',
        'jenis_kelamin',
        'penanggung_biaya',
        'tanggal_masuk_rs',
        'kronologi',
        'insiden_terjadi_pada',
        'insiden_terjadi_pada_lainnya',
        'dampak_insiden',
        'kategori_insiden',
        'tindakan_dilakukan',
        'status',
        'grading_risiko',
        'catatan_tambahan',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'tanggal_lapor' => 'date',
        'tanggal_insiden' => 'date',
        'tanggal_masuk_rs' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->nomor_laporan)) {
                $model->nomor_laporan = self::generateNomorLaporan();
            }
        });
    }

    public static function generateNomorLaporan(): string
    {
        $year = date('Y');
        $month = date('m');
        $lastReport = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastReport ? intval(substr($lastReport->nomor_laporan, -4)) + 1 : 1;

        return sprintf('IKP/%s/%s/%04d', $year, $month, $sequence);
    }
}
