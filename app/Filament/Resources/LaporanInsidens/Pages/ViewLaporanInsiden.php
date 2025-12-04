<?php

namespace App\Filament\Resources\LaporanInsidens\Pages;

use App\Filament\Resources\LaporanInsidens\LaporanInsidenResource;
use Filament\Infolists;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ViewLaporanInsiden extends ViewRecord
{
    protected static string $resource = LaporanInsidenResource::class;

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Laporan')
                    ->schema([
                        Infolists\Components\TextEntry::make('nomor_laporan')
                            ->label('Nomor Laporan'),

                        Infolists\Components\TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'draft' => 'secondary',
                                'submitted' => 'warning',
                                'reviewed' => 'info',
                                'closed' => 'success',
                                default => 'secondary',
                            })
                            ->formatStateUsing(fn(string $state): string => match ($state) {
                                'draft' => 'Draft',
                                'submitted' => 'Disubmit',
                                'reviewed' => 'Direview',
                                'closed' => 'Selesai',
                                default => $state,
                            }),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Tanggal Dibuat')
                            ->dateTime('d F Y, H:i'),
                    ])
                    ->columns(3),

                Section::make('Data Pelapor')
                    ->schema([
                        Infolists\Components\TextEntry::make('nama_pelapor')
                            ->label('Nama Pelapor'),

                        Infolists\Components\TextEntry::make('unit_kerja')
                            ->label('Unit Kerja'),

                        Infolists\Components\TextEntry::make('nomor_telepon')
                            ->label('Nomor Telepon'),

                        Infolists\Components\TextEntry::make('tanggal_lapor')
                            ->label('Tanggal Lapor')
                            ->date('d F Y'),
                    ])
                    ->columns(2),

                Section::make('Data Insiden')
                    ->schema([
                        Infolists\Components\TextEntry::make('jenis_insiden')
                            ->label('Jenis Insiden')
                            ->badge()
                            ->color('warning'),

                        Infolists\Components\TextEntry::make('tanggal_insiden')
                            ->label('Tanggal Insiden')
                            ->date('d F Y'),

                        Infolists\Components\TextEntry::make('waktu_insiden')
                            ->label('Waktu Insiden')
                            ->time('H:i'),

                        Infolists\Components\TextEntry::make('lokasi_insiden')
                            ->label('Lokasi Insiden'),
                    ])
                    ->columns(2),

                Section::make('Data Pasien')
                    ->schema([
                        Infolists\Components\TextEntry::make('nama_pasien')
                            ->label('Nama Pasien')
                            ->placeholder('Tidak melibatkan pasien'),

                        Infolists\Components\TextEntry::make('nomor_rekam_medis')
                            ->label('No. Rekam Medis')
                            ->placeholder('-'),

                        Infolists\Components\TextEntry::make('ruangan')
                            ->label('Ruangan')
                            ->placeholder('-'),

                        Infolists\Components\TextEntry::make('umur')
                            ->label('Umur')
                            ->suffix(' tahun')
                            ->placeholder('-'),

                        Infolists\Components\TextEntry::make('kelompok_umur')
                            ->label('Kelompok Umur')
                            ->badge()
                            ->color('info')
                            ->placeholder('-'),

                        Infolists\Components\TextEntry::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->icon(fn($state) => $state === 'Laki-laki' ? 'heroicon-m-user' : 'heroicon-m-user')
                            ->placeholder('-'),

                        Infolists\Components\TextEntry::make('penanggung_biaya')
                            ->label('Penanggung Biaya')
                            ->badge()
                            ->color('success')
                            ->placeholder('-'),

                        Infolists\Components\TextEntry::make('tanggal_masuk_rs')
                            ->label('Tanggal Masuk RS')
                            ->dateTime('d F Y, H:i')
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Kronologi Insiden')
                    ->schema([
                        Infolists\Components\TextEntry::make('kronologi')
                            ->label('Kronologi Kejadian')
                            ->columnSpanFull()
                            ->prose(),

                        Infolists\Components\TextEntry::make('insiden_terjadi_pada')
                            ->label('Insiden Terjadi Pada')
                            ->badge(),

                        Infolists\Components\TextEntry::make('insiden_terjadi_pada_lainnya')
                            ->label('Keterangan Lainnya')
                            ->visible(fn($record) => $record->insiden_terjadi_pada === 'Lainnya')
                            ->placeholder('-'),
                    ]),

                Section::make('Kategori dan Dampak')
                    ->schema([
                        Infolists\Components\TextEntry::make('kategori_insiden')
                            ->label('Kategori Insiden')
                            ->badge()
                            ->color('info'),

                        Infolists\Components\TextEntry::make('dampak_insiden')
                            ->label('Dampak Insiden')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'Tidak ada cedera' => 'success',
                                'Cedera ringan' => 'warning',
                                'Cedera sedang' => 'warning',
                                'Cedera berat' => 'danger',
                                'Meninggal' => 'danger',
                                default => 'secondary',
                            }),

                        Infolists\Components\TextEntry::make('grading_risiko')
                            ->label('Grading Risiko')
                            ->badge()
                            ->color(fn(?string $state): string => match ($state) {
                                'Biru (Tidak signifikan)' => 'info',
                                'Hijau (Minor)' => 'success',
                                'Kuning (Moderat)' => 'warning',
                                'Merah (Mayor)' => 'danger',
                                'Hitam (Katastropik)' => 'danger',
                                default => 'secondary',
                            })
                            ->placeholder('Belum ditentukan'),
                    ])
                    ->columns(3),

                Section::make('Tindakan yang Dilakukan')
                    ->schema([
                        Infolists\Components\TextEntry::make('tindakan_dilakukan')
                            ->label('Tindakan yang Telah Dilakukan Setelah Insiden')
                            ->columnSpanFull()
                            ->prose()
                            ->placeholder('Belum ada tindakan yang dilaporkan'),
                    ]),

                Section::make('Catatan Tambahan')
                    ->schema([
                        Infolists\Components\TextEntry::make('catatan_tambahan')
                            ->label('Catatan')
                            ->columnSpanFull()
                            ->prose()
                            ->placeholder('Tidak ada catatan tambahan'),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Informasi Review')
                    ->schema([
                        Infolists\Components\TextEntry::make('reviewer.name')
                            ->label('Direview Oleh')
                            ->placeholder('Belum direview'),

                        Infolists\Components\TextEntry::make('reviewed_at')
                            ->label('Tanggal Review')
                            ->dateTime('d F Y, H:i')
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->visible(fn($record) => $record->reviewed_by !== null),
            ]);
    }
}
