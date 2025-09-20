# Fitur Import Rombel

## Deskripsi
Fitur import rombel memungkinkan pengguna untuk mengimpor data rombongan belajar secara massal dari file Excel (.xlsx, .xls) atau CSV.

## Fitur yang Diimplementasikan

### 1. RombelImport Class
- **Lokasi**: `app/Imports/RombelImport.php`
- **Fungsi**: Menangani proses import data dari file Excel/CSV
- **Fitur**:
  - Mapping kolom yang fleksibel
  - Validasi data siswa (harus sudah terdaftar)
  - Auto-create unit dan kelas jika belum ada
  - Mencegah duplikasi data rombel

### 2. RombelController Import Method
- **Lokasi**: `app/Http/Controllers/RombelController.php`
- **Method**: `import(Request $request)`
- **Fungsi**: 
  - Validasi file upload
  - Menjalankan proses import
  - Error handling

### 3. Route Import
- **Lokasi**: `routes/web.php`
- **Route**: `POST /rombel/import`
- **Name**: `rombel.import`

### 4. UI Components
- **Lokasi**: `resources/views/rombel.blade.php`
- **Fitur**:
  - Tombol "Import Excel" di header
  - Modal import dengan form upload
  - Informasi format file yang diperlukan
  - Error dan success message handling

## Format File Excel/CSV

### Kolom yang Diperlukan
1. **nama_siswa** (atau variasi: nama siswa, siswa, nama, name)
2. **kelas** (atau variasi: class, tingkat, grade)
3. **unit** (atau variasi: unit_kerja, departemen, bagian, section)

### Contoh Format CSV
```csv
nama_siswa,kelas,unit
Ahmad Rizki,10A,SD
Siti Nurhaliza,10B,SD
Budi Santoso,11A,SMP
Dewi Sartika,11B,SMP
Eko Prasetyo,12A,SMA
```

## Cara Penggunaan

1. Buka halaman Rombel
2. Klik tombol "Import Excel" (warna kuning)
3. Pilih file Excel/CSV yang akan diimport
4. Klik "Import Data"
5. Sistem akan memproses file dan menampilkan pesan sukses/error

## Validasi dan Error Handling

### Validasi File
- Format file harus .xlsx, .xls, atau .csv
- File harus ada (required)

### Validasi Data
- Nama siswa harus sudah terdaftar di sistem
- Jika siswa tidak ditemukan, baris tersebut akan dilewati
- Unit dan kelas akan dibuat otomatis jika belum ada
- Duplikasi rombel akan dicegah

### Error Messages
- Pesan sukses: "Data rombel berhasil diimport."
- Pesan error: "Terjadi kesalahan saat mengimport data: [detail error]"

## Dependencies
- Laravel Excel (Maatwebsite\Excel)
- File yang sudah ada: GuruImport.php sebagai referensi

## File Sample
- **Lokasi**: `public/sample_rombel_import.csv`
- **Fungsi**: File contoh untuk testing import

## Testing
1. Pastikan ada data siswa di sistem
2. Gunakan file sample atau buat file Excel dengan format yang benar
3. Test import melalui UI
4. Verifikasi data yang diimport muncul di tabel rombel
