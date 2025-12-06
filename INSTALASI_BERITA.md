# 📰 Instalasi Sistem Berita

## 🚀 Quick Start

### 1. Jalankan SQL Script

Buka **pgAdmin** atau **DBeaver**, lalu jalankan file:
```
database/berita_table.sql
```

Atau via command line:
```bash
psql -U postgres -d lab_software_engineering_dev -f database/berita_table.sql
```

### 2. Akses Halaman

**Halaman Publik:**
```
http://localhost/Lab_SE_Website/pages/berita.php
```

**Admin Panel:**
```
http://localhost/Lab_SE_Website/admin/?action=berita_list
```

### 3. Tambah Berita Pertama

1. Login ke admin
2. Klik "Manajemen Berita" di sidebar
3. Klik "Tambah Berita"
4. Isi form dengan Summernote editor
5. Simpan!

## ✅ File yang Dibuat

```
models/Berita.php                    # Model database
controllers/BeritaController.php     # Controller
pages/berita.php                     # Halaman publik
admin/pages/berita/
├── list_berita.php                  # List admin
├── add_berita.php                   # Form tambah (dengan Summernote)
└── edit_berita.php                  # Form edit (dengan Summernote)
database/berita_table.sql            # SQL script
assets/uploads/berita/               # Folder upload
```

## 🎨 Fitur Summernote

Editor WYSIWYG lengkap dengan:
- ✅ Bold, Italic, Underline
- ✅ Font & Size
- ✅ Colors
- ✅ Lists & Alignment
- ✅ Insert Link, Picture, Video
- ✅ Insert Table
- ✅ Fullscreen Mode
- ✅ Code View

## 📝 Cara Menggunakan

### Tambah Berita
1. Admin → Manajemen Berita → Tambah Berita
2. Isi form
3. Gunakan Summernote untuk "Isi Lengkap"
4. Upload gambar utama (opsional)
5. Pilih status (Draft/Published)
6. Simpan

### Edit Berita
1. Admin → Manajemen Berita
2. Klik icon pensil
3. Edit data
4. Simpan

### Hapus Berita
1. Admin → Manajemen Berita
2. Klik icon trash
3. Konfirmasi

## 🔧 Troubleshooting

### Summernote tidak muncul
**Solusi:** 
- Hard refresh (Ctrl + F5)
- Cek browser console (F12)
- Pastikan jQuery loaded

### Error: Table berita does not exist
**Solusi:** Jalankan `database/berita_table.sql`

### Gambar tidak bisa diupload
**Solusi:**
- Cek folder `assets/uploads/berita/` ada
- Cek permission folder (777)
- Max 5MB per gambar

## 📚 Sample Data

SQL script sudah include 4 sample berita:
1. Workshop Laravel 10
2. Software Testing DevOps
3. Pendaftaran Asisten 2026
4. Tren UI/UX 2025

## ✨ Selesai!

Sistem berita sudah siap digunakan dengan Summernote editor! 🎉

