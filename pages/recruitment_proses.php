<?php
// pages/recruitment_proses.php

// 1. Mulai Session
if (session_status() === PHP_SESSION_NONE) session_start();

// 2. Setup Path & Load Class
$root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';

// Pastikan urutan load ini benar
require_once $root . '/config/config.php';
require_once $root . '/models/RecruitmentModel.php';
require_once $root . '/controllers/RecruitmentController.php';

// 3. Cek Method Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: recruitment_form.php");
    exit();
}


// 5. Eksekusi Controller
try {
    // A. Inisialisasi Database
    $database = new Database();
    $db = $database->getConnection();

    // B. Inisialisasi Model
    $model = new RecruitmentModel($db);

    // C. Inisialisasi Controller (Inject Model ke sini)
    $controller = new RecruitmentController($model);
    
    // D. Panggil method daftar()
    $result = $controller->daftar();

    // E. Cek Hasil
    if ($result['success']) {
        // --- SUKSES ---
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = $result['message'];
        header("Location: recruitment_form.php?status=success");
    } else {
        // --- GAGAL (Validasi/Upload Error) ---
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = $result['message'];
        header("Location: recruitment_form.php?status=error");
    }

} catch (Exception $e) {
    // --- ERROR SYSTEM ---
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = "Terjadi kesalahan sistem: " . $e->getMessage();
    header("Location: recruitment_form.php?status=error");
}

exit();
?>