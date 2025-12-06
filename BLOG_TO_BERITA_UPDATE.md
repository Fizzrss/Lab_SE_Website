# 📝 Update: Blog → Berita

## ✅ File yang Sudah Diupdate

### 1. **includes/navbar.php**
- ✅ Menu "Blog" → "Berita"
- ✅ Link `blog.php` → `berita.php`
- ✅ Active state check: `blog.php` → `berita.php`

### 2. **includes/footer.php**
- ✅ Link "Blog & Berita" → "Berita & Artikel"
- ✅ URL `blog.php` → `berita.php`

### 3. **pages/blog.php**
- ✅ File diubah menjadi redirect ke `berita.php`
- ✅ Preserves query string jika ada
- ✅ Backward compatibility untuk link lama

## 📋 Perubahan Detail

### Navbar (includes/navbar.php)
**Sebelum:**
```php
<a href="<?= BASE_URL ?>pages/blog.php">Blog</a>
```

**Sesudah:**
```php
<a href="<?= BASE_URL ?>pages/berita.php">Berita</a>
```

### Footer (includes/footer.php)
**Sebelum:**
```php
<li><a href="<?= BASE_URL ?>pages/blog.php">Blog & Berita</a></li>
```

**Sesudah:**
```php
<li><a href="<?= BASE_URL ?>pages/berita.php">Berita & Artikel</a></li>
```

### Redirect (pages/blog.php)
File `blog.php` sekarang hanya berisi redirect:
```php
header('Location: berita.php' . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));
exit;
```

## 🔄 Backward Compatibility

Jika ada link lama yang masih mengarah ke `blog.php`, akan otomatis redirect ke `berita.php` dengan query string yang sama.

Contoh:
- `blog.php?kategori=Workshop` → redirect ke `berita.php?kategori=Workshop`
- `blog.php?page=2` → redirect ke `berita.php?page=2`
- `blog.php` → redirect ke `berita.php`

## ✅ Status

Semua referensi `blog.php` sudah diganti menjadi `berita.php`!

---

*Updated: 5 Desember 2025*

