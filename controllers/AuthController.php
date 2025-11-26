<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once "../config/config.php";
require_once "../models/User.php";
include "../helpers/flash_message.php"; 

// 1. Koneksi & Model
$database = new Database();
$db = $database->getConnection();
$userModel = new User($db);

// 2. Ambil Input
$username = $_POST['username']; 
$password = $_POST['password']; 

// 3. Cari User di Database
$user = $userModel->getUserByUsername($username);

// 4. Cek Login
if ($user) {
    // Cek apakah password input ("admin123") cocok dengan Hash di Database
    // Makanya langkah 1 di atas WAJIB dilakukan.
    if (password_verify($password, $user['password'])) {
        
        // Simpan sesi
        $_SESSION['username'] = $user['username'];
        $_SESSION['level']    = $user['level'];
        $_SESSION['user_id']  = $user['id'];
        
        // Redirect sesuai level (Opsional)
        if ($user['level'] == 'admin') {
            header("Location: ../admin/pages/dashboard.php");
        } else {
            header("Location: ../admin/index.php");
        }
        exit;

    } else {
        pesan('danger', "Password salah.");
        header("Location: ../admin/login.php");
        exit;
    }
} else {
    pesan('warning', "Username tidak ditemukan.");
    header("Location: ../admin/login.php");
    exit;
}
?>