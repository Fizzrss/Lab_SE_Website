<?php
// pages/komentar_proses.php

// 1. Mulai Session
if (session_status() === PHP_SESSION_NONE) session_start();

// 2. Setup Path & Load Class
$root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';

// Pastikan urutan load ini benar
require_once $root . '/config/config.php';
require_once $root . '/models/KomentarBerita.php';
require_once $root . '/controllers/KomentarController.php';
require_once $root . '/models/Berita.php';

// 3. Cek Method Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: berita.php");
    exit();
}

// 4. Get berita slug untuk redirect
$berita_slug = '';
if (isset($_POST['berita_slug'])) {
    $berita_slug = $_POST['berita_slug'];
}

// 5. Eksekusi Controller
try {
    // A. Inisialisasi Database
    $database = new Database();
    $db = $database->getConnection();

    // B. Inisialisasi Model
    $komentarModel = new KomentarBeritaModel($db);

    // C. Inisialisasi Controller (Inject Model ke sini)
    $controller = new KomentarController($komentarModel);
    
    // D. Panggil method create()
    $result = $controller->create();

    // E. Cek Hasil
    if ($result['success']) {
        // --- SUKSES ---
        $_SESSION['komentar_status'] = 'success';
        $_SESSION['komentar_message'] = $result['message'];
        
        if (!empty($berita_slug)) {
            header("Location: berita_detail.php?slug=" . urlencode($berita_slug) . "&komentar=success");
        } else {
            header("Location: berita.php?komentar=success");
        }
    } else {
        // --- GAGAL (Validasi Error) ---
        $_SESSION['komentar_status'] = 'error';
        $_SESSION['komentar_message'] = $result['message'];
        
        if (!empty($berita_slug)) {
            header("Location: berita_detail.php?slug=" . urlencode($berita_slug) . "&komentar=error");
        } else {
            header("Location: berita.php?komentar=error");
        }
    }

} catch (Exception $e) {
    // --- ERROR SYSTEM ---
    $_SESSION['komentar_status'] = 'error';
    $_SESSION['komentar_message'] = "Terjadi kesalahan sistem: " . $e->getMessage();
    
    if (!empty($berita_slug)) {
        header("Location: berita_detail.php?slug=" . urlencode($berita_slug) . "&komentar=error");
    } else {
        header("Location: berita.php?komentar=error");
    }
}

exit();
?>

