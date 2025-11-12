<?php
/*
|--------------------------------------------------------------------------
| File: includes/config.php (VERSI AMAN / DUMMY)
|--------------------------------------------------------------------------
| File ini HANYA mendefinisikan konstanta dasar seperti BASE_URL.
| Semua koneksi database dinonaktifkan (dikomentari)
| agar tidak menyebabkan Fatal Error.
*/

// Tampilkan error (ini bagus untuk debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// 1. TENTUKAN BASE_URL (PENTING!)
// Pastikan path ini adalah folder root proyekmu di htdocs
define('BASE_URL', 'http://localhost/Lab_SE_Website/');


// 2. NONAKTIFKAN KONEKSI DATABASE
// Kita beri komentar (/* ... */) pada semua kode
// yang berhubungan dengan database agar tidak dijalankan.

/*
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_lab_se');

// Baris ini yang menyebabkan FATAL ERROR jika database tidak ada
$koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$koneksi) {
    // Ini pesan yang kamu inginkan, tapi 'die()' menghentikan script
    // dan bisa menyebabkan halaman tetap putih.
    die("Koneksi database gagal: " . mysqli_connect_error());
}
*/

?>