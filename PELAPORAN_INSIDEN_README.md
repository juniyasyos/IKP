# Sistem Pelaporan Insiden Keselamatan Pasien (IKP)

Aplikasi untuk pelaporan dan pengelolaan insiden keselamatan pasien menggunakan Laravel dan Filament.

## Fitur yang Telah Dibuat

### 1. **Navigasi Top (Horizontal)**
- Panel admin Filament sekarang menggunakan navigasi di bagian atas
- Konfigurasi di: `app/Providers/Filament/AdminPanelProvider.php`

### 2. **Form Pelaporan Insiden Custom**
- **Lokasi**: Menu "Pelaporan Insiden"
- **File**: `app/Filament/Pages/PelaporanInsiden.php`
- **View**: `resources/views/filament/pages/pelaporan-insiden.blade.php`

**Fitur Form:**
- Data Pelapor (nama, unit kerja, telepon, tanggal lapor)
- Data Insiden (jenis, tanggal, waktu, lokasi, pasien)
- Kronologi Insiden (detail kejadian)
- Kategori dan Dampak (jenis insiden, dampak, grading risiko)
- Tindakan dan Analisis (tindakan, analisis penyebab, rekomendasi)
- Catatan Tambahan
- Dua tombol: **Simpan Draft** dan **Submit Laporan**

### 3. **Resource Daftar Laporan**
- **Lokasi**: Menu "Daftar Laporan Insiden"
- **File Resource**: `app/Filament/Resources/LaporanInsidens/LaporanInsidenResource.php`

**Fitur:**
- Tabel dengan kolom: No. Laporan, Tanggal, Jenis, Kategori, Lokasi, Status, Dampak, Pelapor
- Filter berdasarkan: Status, Jenis Insiden, Dampak
- Action: View (Detail), Edit, Delete
- Support soft delete
- Sorting dan searching

### 4. **Detail Laporan (View Page)**
- **File**: `app/Filament/Resources/LaporanInsidens/Pages/ViewLaporanInsiden.php`
- Menampilkan semua informasi laporan secara terstruktur dengan badge dan format yang jelas

### 5. **Database Structure**
- **Model**: `app/Models/LaporanInsiden.php`
- **Migration**: `database/migrations/2025_12_04_014608_create_laporan_insidens_table.php`

**Field Database:**
- Data pelapor dan identitas
- Data insiden lengkap
- Kronologi dan analisis
- Status workflow (draft, submitted, reviewed, closed)
- Grading risiko (Biru, Hijau, Kuning, Merah, Hitam)
- Timestamp review dan reviewer
- Soft deletes

## Struktur File

```
app/
├── Filament/
│   ├── Pages/
│   │   └── PelaporanInsiden.php          # Form pelaporan custom
│   └── Resources/
│       └── LaporanInsidens/
│           ├── LaporanInsidenResource.php
│           ├── Pages/
│           │   ├── ListLaporanInsidens.php
│           │   ├── CreateLaporanInsiden.php
│           │   ├── EditLaporanInsiden.php
│           │   └── ViewLaporanInsiden.php
│           ├── Schemas/
│           │   └── LaporanInsidenForm.php
│           └── Tables/
│               └── LaporanInsidensTable.php
├── Models/
│   └── LaporanInsiden.php
└── Providers/
    └── Filament/
        └── AdminPanelProvider.php        # Config top navigation

resources/
└── views/
    └── filament/
        └── pages/
            └── pelaporan-insiden.blade.php

database/
└── migrations/
    └── 2025_12_04_014608_create_laporan_insidens_table.php
```

## Cara Menggunakan

### 1. Setup (Sudah dilakukan)
```bash
# Migration sudah dijalankan
php artisan migrate

# Cache sudah dibersihkan
php artisan optimize:clear
```

### 2. Akses Aplikasi
```bash
# Jalankan server development
php artisan serve
```

Akses di browser: `http://localhost:8000` atau sesuai path panel Anda

### 3. Menu yang Tersedia

**a. Pelaporan Insiden**
- Untuk membuat laporan baru
- Bisa simpan sebagai draft atau langsung submit

**b. Daftar Laporan Insiden**
- Melihat semua laporan yang pernah dibuat
- Filter, search, dan sorting
- View detail, Edit, atau Delete laporan

## Status Laporan

1. **Draft** - Laporan masih dalam proses pengisian
2. **Disubmit** - Laporan sudah dikirim, menunggu review
3. **Direview** - Sedang dalam proses review
4. **Selesai** - Laporan sudah selesai diproses

## Jenis Insiden

- **KNC** - Kejadian Nyaris Cedera
- **KTD** - Kejadian Tidak Diharapkan
- **KTC** - Kejadian Tidak Cedera
- **Sentinel** - Kejadian sentinel

## Kategori Insiden

- Medikasi
- Prosedur Klinik
- Dokumentasi
- Infeksi Nosokomial
- Jatuh
- Komunikasi
- Peralatan Medis
- Transfusi Darah
- Diet/Nutrisi
- Lainnya

## Grading Risiko

- 🔵 **Biru** - Tidak signifikan
- 🟢 **Hijau** - Minor
- 🟡 **Kuning** - Moderat
- 🔴 **Merah** - Mayor
- ⚫ **Hitam** - Katastropik

## Nomor Laporan

Sistem otomatis generate nomor laporan dengan format:
```
IKP/YYYY/MM/XXXX
```

Contoh: `IKP/2025/12/0001`

## Customization

Jika ingin mengubah field atau tambah fitur:

1. **Ubah Migration** untuk field database baru
2. **Update Model** `$fillable` array
3. **Update Form** di `LaporanInsidenForm.php` dan `PelaporanInsiden.php`
4. **Update Table** di `LaporanInsidensTable.php`
5. **Update View** di `ViewLaporanInsiden.php`

## Notes

- Navigasi sudah dipindah ke atas (top navigation)
- Semua form menggunakan Filament components
- Support soft delete untuk recovery data
- Auto-generate nomor laporan
- Relasi dengan user (pelapor dan reviewer)
