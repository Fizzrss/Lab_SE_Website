<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Pastikan config.php mendefinisikan BASE_URL
require_once "../config/config.php"; 
require_once "../models/User.php";
include "../helpers/flash_message.php"; 

// 1. Koneksi & Model
$database = new Database();
$db = $database->getConnection();
$userModel = new User($db);

// 2. Ambil Input (Gunakan htmlspecialchars atau filter untuk keamanan dasar)
$username = $_POST['username'] ?? ''; 
$password = $_POST['password'] ?? ''; 

// 3. Cari User di Database
$user = $userModel->getUserByUsername($username);

// 4. Cek Login
if ($user) {
    // HAPUS TITIK (.) YANG TADI ADA DISINI
    
    // Verifikasi Password
    if (password_verify($password, $user['password'])) {
        
        // Simpan sesi
        $_SESSION['username'] = $user['username'];
        $_SESSION['level']    = $user['level'];
        $_SESSION['user_id']  = $user['id'];
        
        // --- PERBAIKAN REDIRECT (PENTING) ---
        // Jangan arahkan ke pages/dashboard.php
        // Arahkan SELALU ke index.php dengan parameter action
        
        // Pastikan Anda sudah define('BASE_URL', 'http://localhost/Lab_SE_Website/'); di config.php
        // Jika belum ada BASE_URL, ganti dengan header("Location: ../admin/index.php?action=dashboard");
        
        if (defined('BASE_URL')) {
            header("Location: " . BASE_URL . "admin/index.php?action=dashboard");
        } else {
            // Fallback jika BASE_URL belum didefinisikan
            header("Location: ../admin/index.php?action=dashboard");
        }
        exit;

    } else {
        pesan('danger', "Password salah.");
        // Redirect Login Gagal
        if (defined('BASE_URL')) {
            header("Location: " . BASE_URL . "admin/login.php");
        } else {
            header("Location: ../admin/login.php");
        }
        exit;
    }
} else {
    pesan('warning', "Username tidak ditemukan.");
    // Redirect Username Tidak Ada
    if (defined('BASE_URL')) {
        header("Location: " . BASE_URL . "admin/login.php");
    } else {
        header("Location: ../admin/login.php");
    }
    exit;
}
?>