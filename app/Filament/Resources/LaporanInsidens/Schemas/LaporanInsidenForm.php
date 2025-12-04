<?php

namespace App\Filament\Resources\LaporanInsidens\Schemas;

use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class LaporanInsidenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Pelapor')
                    ->description('Informasi tentang pelapor insiden')
                    ->schema([
                        Forms\Components\TextInput::make('nama_pelapor')
                            ->label('Nama Pelapor')
                            ->required()
                            ->default(Auth::user()->name ?? ''),

                        Forms\Components\TextInput::make('unit_kerja')
                            ->label('Unit Kerja')
                            ->required(),

                        Forms\Components\TextInput::make('nomor_telepon')
                            ->label('Nomor Telepon')
                            ->tel(),

                        Forms\Components\DatePicker::make('tanggal_lapor')
                            ->label('Tanggal Lapor')
                            ->required()
                            ->default(now())
                            ->native(false),
                    ])
                    ->columns(2),

                Section::make('Data Insiden')
                    ->description('Informasi detail tentang insiden yang terjadi')
                    ->schema([
                        Forms\Components\Select::make('jenis_insiden')
                            ->label('Jenis Insiden')
                            ->required()
                            ->options([
                                'KNC (Kejadian Nyaris Cedera)' => 'KNC (Kejadian Nyaris Cedera)',
                                'KTD (Kejadian Tidak Diharapkan)' => 'KTD (Kejadian Tidak Diharapkan)',
                                'KTC (Kejadian Tidak Cedera)' => 'KTC (Kejadian Tidak Cedera)',
                                'Sentinel' => 'Sentinel',
                            ])
                            ->native(false),

                        Forms\Components\DatePicker::make('tanggal_insiden')
                            ->label('Tanggal Insiden')
                            ->required()
                            ->native(false)
                            ->maxDate(now()),

                        Forms\Components\TimePicker::make('waktu_insiden')
                            ->label('Waktu Insiden')
                            ->required()
                            ->native(false),

                        Forms\Components\TextInput::make('lokasi_insiden')
                            ->label('Lokasi Insiden')
                            ->required()
                            ->placeholder('Contoh: Ruang IGD, Lantai 2'),
                    ])
                    ->columns(2),

                Section::make('Data Pasien')
                    ->description('Isi jika insiden melibatkan pasien')
                    ->schema([
                        Forms\Components\TextInput::make('nama_pasien')
                            ->label('Nama Pasien'),

                        Forms\Components\TextInput::make('nomor_rekam_medis')
                            ->label('No. Rekam Medis'),

                        Forms\Components\TextInput::make('ruangan')
                            ->label('Ruangan'),

                        Forms\Components\TextInput::make('umur')
                            ->label('Umur (Tahun)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(150),

                        Forms\Components\Select::make('kelompok_umur')
                            ->label('Kelompok Umur')
                            ->options([
                                '0-1 bulan' => '0-1 bulan',
                                '>1 bulan - 1 tahun' => '>1 bulan - 1 tahun',
                                '>1 tahun - 5 tahun' => '>1 tahun - 5 tahun',
                                '>5 tahun - 15 tahun' => '>5 tahun - 15 tahun',
                                '>15 tahun - 30 tahun' => '>15 tahun - 30 tahun',
                                '>30 tahun - 65 tahun' => '>30 tahun - 65 tahun',
                                '>65 tahun' => '>65 tahun',
                            ])
                            ->native(false),

                        Forms\Components\Select::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->native(false),

                        Forms\Components\Select::make('penanggung_biaya')
                            ->label('Penanggung Biaya Pasien')
                            ->options([
                                'Pribadi' => 'Pribadi',
                                'BPJS' => 'BPJS',
                                'Asuransi Swasta' => 'Asuransi Swasta',
                                'Lainnya' => 'Lainnya (sebutkan)',
                            ])
                            ->native(false),

                        Forms\Components\DateTimePicker::make('tanggal_masuk_rs')
                            ->label('Tanggal Masuk RS')
                            ->native(false)
                            ->maxDate(now()),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Kronologi Insiden')
                    ->schema([
                        Forms\Components\Textarea::make('kronologi')
                            ->label('Kronologi Kejadian')
                            ->required()
                            ->rows(8)
                            ->helperText('Jelaskan secara detail kronologi kejadian insiden. Tidak ada batasan karakter.')
                            ->columnSpanFull(),

                        Forms\Components\Radio::make('insiden_terjadi_pada')
                            ->label('Insiden Terjadi Pada')
                            ->required()
                            ->options([
                                'Pasien' => 'Pasien',
                                'Petugas' => 'Petugas',
                                'Pengunjung' => 'Pengunjung',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->default('Pasien')
                            ->inline()
                            ->inlineLabel(false)
                            ->live(),

                        Forms\Components\TextInput::make('insiden_terjadi_pada_lainnya')
                            ->label('Sebutkan Lainnya')
                            ->placeholder('Jelaskan kepada siapa insiden terjadi')
                            ->visible(fn(Forms\Get $get) => $get('insiden_terjadi_pada') === 'Lainnya')
                            ->required(fn(Forms\Get $get) => $get('insiden_terjadi_pada') === 'Lainnya'),
                    ]),

                Section::make('Kategori dan Dampak')
                    ->schema([
                        Forms\Components\Select::make('kategori_insiden')
                            ->label('Kategori Insiden')
                            ->required()
                            ->options([
                                'Medikasi' => 'Medikasi',
                                'Prosedur Klinik' => 'Prosedur Klinik',
                                'Dokumentasi' => 'Dokumentasi',
                                'Infeksi Nosokomial' => 'Infeksi Nosokomial',
                                'Jatuh' => 'Jatuh',
                                'Komunikasi' => 'Komunikasi',
                                'Peralatan Medis' => 'Peralatan Medis',
                                'Transfusi Darah' => 'Transfusi Darah',
                                'Diet/Nutrisi' => 'Diet/Nutrisi',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->native(false)
                            ->searchable(),

                        Forms\Components\Select::make('dampak_insiden')
                            ->label('Dampak Insiden')
                            ->required()
                            ->options([
                                'Tidak ada cedera' => 'Tidak ada cedera',
                                'Cedera ringan' => 'Cedera ringan',
                                'Cedera sedang' => 'Cedera sedang',
                                'Cedera berat' => 'Cedera berat',
                                'Meninggal' => 'Meninggal',
                            ])
                            ->native(false)
                            ->default('Tidak ada cedera'),

                        Forms\Components\Select::make('grading_risiko')
                            ->label('Grading Risiko (Diisi oleh Validator)')
                            ->options([
                                'Biru (Tidak signifikan)' => 'Biru (Tidak signifikan)',
                                'Hijau (Minor)' => 'Hijau (Minor)',
                                'Kuning (Moderat)' => 'Kuning (Moderat)',
                                'Merah (Mayor)' => 'Merah (Mayor)',
                                'Hitam (Katastropik)' => 'Hitam (Katastropik)',
                            ])
                            ->native(false)
                            ->helperText('Field ini hanya dapat diisi oleh validator/tim IKP')
                            ->visibleOn('edit'),
                    ])
                    ->columns(3),

                Section::make('Tindakan yang Dilakukan')
                    ->schema([
                        Forms\Components\Textarea::make('tindakan_dilakukan')
                            ->label('Tindakan yang Telah Dilakukan')
                            ->required()
                            ->rows(6)
                            ->helperText('Jelaskan tindakan segera yang telah dilakukan setelah insiden terjadi. Tidak ada batasan karakter.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Catatan Tambahan')
                    ->schema([
                        Forms\Components\Textarea::make('catatan_tambahan')
                            ->label('Catatan Tambahan')
                            ->rows(5)
                            ->helperText('Informasi tambahan (opsional). Tidak ada batasan karakter.')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status Laporan')
                            ->options([
                                'draft' => 'Draft',
                                'submitted' => 'Disubmit',
                                'reviewed' => 'Direview',
                                'closed' => 'Selesai',
                            ])
                            ->default('draft')
                            ->required()
                            ->native(false),
                    ])
                    ->visibleOn('edit'),
            ]);
    }
}
