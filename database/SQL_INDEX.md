# 📋 Index Semua File SQL

Dokumen ini berisi daftar lengkap semua file SQL untuk fitur dinamis website.

## 🎯 File Master (Rekomendasi)

### `all_tables_master.sql`
**File master yang menggabungkan SEMUA tabel dinamis dalam satu file.**

**Tabel yang dibuat:**
1. `berita_settings` - Pengaturan hero banner berita
2. `berita_komentar` - Komentar berita
3. `berita_views` - Counter view berita
4. `social_media_settings` - Pengaturan social media sharing
5. `related_posts_settings` - Pengaturan related posts
6. `footer_settings` - Pengaturan footer (key-value)
7. `footer_available_pages` - Daftar halaman untuk footer
8. `hero_settings` - Pengaturan hero homepage
9. `profil_sections` - Section profil dinamis

**Cara Eksekusi:**
1. Pastikan tabel `berita` sudah dibuat (eksekusi `berita_table.sql` terlebih dahulu)
2. Buka pgAdmin4 → Connect ke database `lab_software_engineering_dev`
3. Query Tool → Buka file `all_tables_master.sql`
4. Execute (F5)

---

## 📁 File SQL Terpisah (Eksekusi Bertahap)

### 1. **berita_table.sql**
- Tabel: `berita`
- Deskripsi: Tabel utama untuk artikel berita + data sample

### 2. **berita_settings.sql**
- Tabel: `berita_settings`
- Deskripsi: Pengaturan hero banner halaman berita

### 3. **berita_komentar.sql**
- Tabel: `berita_komentar`
- Deskripsi: Komentar pada artikel berita
- ⚠️ Memerlukan: Tabel `berita` (foreign key)

### 4. **berita_views.sql**
- Tabel: `berita_views`
- Deskripsi: Counter view berita per hari
- ⚠️ Memerlukan: Tabel `berita` (foreign key)

### 5. **social_media_settings.sql**
- Tabel: `social_media_settings`
- Deskripsi: Pengaturan platform social media untuk sharing

### 6. **related_posts_settings.sql**
- Tabel: `related_posts_settings`
- Deskripsi: Pengaturan tampilan related posts

### 7. **footer_settings.sql**
- Tabel: `footer_settings` + `footer_available_pages`
- Deskripsi: Pengaturan footer dan daftar halaman

### 8. **profil_sections.sql**
- Tabel: `hero_settings` + `profil_sections`
- Deskripsi: Pengaturan homepage hero dan section profil

### 9. **hero_button_settings.sql** (OPSIONAL)
- Data: Insert ke `hero_settings`
- Deskripsi: Default values untuk tombol hero
- ⚠️ Memerlukan: Tabel `hero_settings` (dari `profil_sections.sql`)

---

## ⚠️ Urutan Eksekusi (Jika File Terpisah)

```
1. berita_table.sql           → Tabel berita (WAJIB PERTAMA)
2. berita_settings.sql        → Settings berita
3. berita_komentar.sql        → Komentar (butuh tabel berita)
4. berita_views.sql           → Views (butuh tabel berita)
5. social_media_settings.sql  → Social media
6. related_posts_settings.sql → Related posts
7. footer_settings.sql        → Footer
8. profil_sections.sql        → Profil & Hero
9. hero_button_settings.sql   → Button hero (OPSIONAL)
```

---

## ✅ Ringkasan Tabel

| Tabel | Deskripsi | Dependensi |
|-------|-----------|------------|
| `berita` | Artikel berita | - |
| `berita_settings` | Settings hero banner berita | - |
| `berita_komentar` | Komentar berita | `berita` |
| `berita_views` | Counter view | `berita` |
| `social_media_settings` | Platform social media | - |
| `related_posts_settings` | Config related posts | - |
| `footer_settings` | Settings footer | - |
| `footer_available_pages` | Daftar halaman footer | - |
| `hero_settings` | Settings hero homepage | - |
| `profil_sections` | Section profil dinamis | - |

---

## 📝 Catatan Penting

- Semua file SQL menggunakan `CREATE TABLE IF NOT EXISTS` (aman dieksekusi berulang)
- Foreign key constraint akan gagal jika tabel referensi belum ada
- File SQL ini hanya dokumentasi - **HARUS dieksekusi manual di pgAdmin4**
- Tidak ada auto-execute dari aplikasi

