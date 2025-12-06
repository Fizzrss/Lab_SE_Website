# Database SQL Scripts

## 📋 Informasi Penting

Semua file SQL di folder ini **HARUS DIEKSEKUSI MANUAL di pgAdmin4**. 
Tidak ada auto-execute atau koneksi langsung ke folder database ini dari aplikasi.

## 🔌 Koneksi Database

Semua koneksi database menggunakan file `config/config.php` yang berisi:
- Host: localhost
- Port: 5432
- Database: lab_software_engineering_dev
- Username: postgres
- Password: (sesuai konfigurasi)

## 📁 Daftar File SQL

### Opsi 1: File Master (Paling Mudah)
**`all_tables_master.sql`** - File master yang menggabungkan semua tabel dinamis dalam satu file.

**Cara eksekusi:**
1. Pastikan tabel `berita` sudah dibuat terlebih dahulu (eksekusi `berita_table.sql`)
2. Buka pgAdmin4
3. Connect ke database `lab_software_engineering_dev`
4. Klik kanan pada database → Query Tool
5. Buka file `all_tables_master.sql`
6. Klik Execute (F5) atau Run

**Tabel yang dibuat:**
- `berita_settings` - Pengaturan hero banner berita
- `berita_komentar` - Komentar berita
- `berita_views` - Counter view berita
- `social_media_settings` - Pengaturan social media sharing
- `related_posts_settings` - Pengaturan related posts
- `footer_settings` - Pengaturan footer
- `footer_available_pages` - Daftar halaman untuk footer
- `hero_settings` - Pengaturan hero homepage (termasuk button)
- `profil_sections` - Section profil (Tentang, Visi & Misi, Roadmap, Focus & Scope)

---

### Opsi 2: File Terpisah (Eksekusi Bertahap)

#### 1. `berita_table.sql`
**Deskripsi:** Script untuk membuat tabel `berita` dan data sample.

**Tabel yang dibuat:**
- `berita` - Tabel untuk menyimpan artikel berita

#### 2. `berita_settings.sql`
**Deskripsi:** Script untuk membuat tabel `berita_settings` (pengaturan hero banner berita).

**Tabel yang dibuat:**
- `berita_settings` - Tabel untuk menyimpan pengaturan hero banner halaman berita

#### 3. `berita_komentar.sql`
**Deskripsi:** Script untuk membuat tabel komentar berita.

**Tabel yang dibuat:**
- `berita_komentar` - Tabel untuk menyimpan komentar pada berita

**Catatan:** Memerlukan tabel `berita` sudah ada (foreign key constraint)

#### 4. `berita_views.sql`
**Deskripsi:** Script untuk membuat tabel counter view berita.

**Tabel yang dibuat:**
- `berita_views` - Tabel untuk menyimpan data view count per berita per hari

**Catatan:** Memerlukan tabel `berita` sudah ada (foreign key constraint)

#### 5. `social_media_settings.sql`
**Deskripsi:** Script untuk membuat tabel pengaturan social media sharing.

**Tabel yang dibuat:**
- `social_media_settings` - Tabel untuk mengatur platform social media yang aktif

#### 6. `related_posts_settings.sql`
**Deskripsi:** Script untuk membuat tabel pengaturan related posts.

**Tabel yang dibuat:**
- `related_posts_settings` - Tabel untuk mengatur tampilan related posts

#### 7. `footer_settings.sql`
**Deskripsi:** Script untuk membuat tabel pengaturan footer.

**Tabel yang dibuat:**
- `footer_settings` - Tabel untuk menyimpan pengaturan footer (title, description, copyright)
- `footer_available_pages` - Tabel untuk menyimpan daftar halaman yang bisa dipilih di footer

#### 8. `profil_sections.sql`
**Deskripsi:** Script untuk membuat tabel pengaturan homepage dan profil.

**Tabel yang dibuat:**
- `hero_settings` - Tabel untuk menyimpan pengaturan hero homepage (title, subtitle, description, background, button)
- `profil_sections` - Tabel untuk menyimpan section profil (Tentang, Visi & Misi, Roadmap, Focus & Scope)

#### 9. `hero_button_settings.sql` (OPSIONAL)
**Deskripsi:** Script untuk menambahkan pengaturan tombol "Get Started" ke tabel `hero_settings`.

**Catatan:** 
- File ini menambahkan data ke tabel `hero_settings` yang sudah ada
- Pastikan tabel `hero_settings` sudah dibuat terlebih dahulu (via `profil_sections.sql`)
- **OPSIONAL**: File ini tidak wajib dieksekusi terlebih dahulu karena aplikasi akan otomatis membuat record baru saat admin menyimpan form

## ⚠️ Urutan Eksekusi (Jika Menggunakan File Terpisah)

Jika ada dependensi antar tabel, pastikan urutan eksekusi yang benar:

1. **`berita_table.sql`** - Tabel berita (WAJIB DULUAN)
2. **`berita_settings.sql`** - Tabel pengaturan berita
3. **`berita_komentar.sql`** - Tabel komentar (memerlukan tabel berita)
4. **`berita_views.sql`** - Tabel views (memerlukan tabel berita)
5. **`social_media_settings.sql`** - Tabel social media
6. **`related_posts_settings.sql`** - Tabel related posts
7. **`footer_settings.sql`** - Tabel footer
8. **`profil_sections.sql`** - Tabel profil & hero homepage
9. **`hero_button_settings.sql`** - Data button hero (OPSIONAL, memerlukan tabel hero_settings)

## 📝 Catatan

- Semua file SQL menggunakan `CREATE TABLE IF NOT EXISTS` untuk menghindari error jika tabel sudah ada
- Beberapa file menggunakan `ON CONFLICT DO NOTHING` untuk menghindari duplikasi data
- File SQL ini hanya sebagai **dokumentasi/referensi** dan harus dieksekusi manual di pgAdmin4
- Tidak ada koneksi atau auto-execute dari aplikasi ke folder database ini

## ⚡ Catatan Penting: Auto-Create Records

Beberapa fitur memiliki mekanisme **auto-create records** saat admin menyimpan data:
- **Hero Button Settings**: Jika data belum ada, aplikasi akan otomatis membuat record baru saat admin menyimpan form di halaman "Pengaturan Profil & Beranda"
- Aplikasi juga menggunakan **default values (fallback)** jika data tidak ditemukan di database
- File SQL tetap berguna untuk **initial setup/default values**, tapi tidak wajib dieksekusi terlebih dahulu

**Kenapa admin bisa berjalan tanpa eksekusi SQL?**
1. Aplikasi menggunakan **default values** jika data tidak ada (contoh: 'Get Started', '#profil')
2. Saat admin **menyimpan form**, aplikasi akan otomatis **membuat record baru** di database menggunakan `INSERT ... ON CONFLICT ... DO UPDATE`
3. Jadi file SQL hanya untuk **initial setup**, tapi tidak mandatory

## 🔧 Troubleshooting

### Error: relation does not exist
**Solusi:** Pastikan file SQL yang diperlukan sudah dieksekusi terlebih dahulu

### Error: duplicate key value
**Solusi:** File SQL sudah menggunakan `ON CONFLICT DO NOTHING`, jadi aman untuk dieksekusi ulang

### Error: permission denied
**Solusi:** Pastikan user database memiliki permission untuk CREATE TABLE dan INSERT

## 📚 Dokumentasi Tambahan

Untuk informasi lebih lanjut tentang struktur database, lihat dokumentasi di:
- `models/` - File model PHP yang menggambarkan struktur tabel
- `controllers/` - File controller yang menggunakan model

