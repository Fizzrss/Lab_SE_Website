<?php
// 1. Mulai session (Wajib, biar tahu session mana yang mau dihapus)
session_start();

// 2. Kosongkan semua variabel session
$_SESSION = [];
session_unset();

// 3. Hancurkan session dari server
session_destroy();

// 4. Lempar user kembali ke halaman login
// Sesuaikan path 'login.php' jika letaknya beda folder
header("Location: login.php?pesan=logout");
exit;
?>