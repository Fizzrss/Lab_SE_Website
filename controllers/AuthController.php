<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once "../config/config.php"; 
require_once "../models/User.php";
include "../helpers/flash_message.php"; 

$database = new Database();
$db = $database->getConnection();
$userModel = new User($db);

$username = $_POST['username'] ?? ''; 
$password = $_POST['password'] ?? ''; 

$user = $userModel->getUserByUsername($username);

if ($user) {
    if (password_verify($password, $user['password'])) 
    {
        $_SESSION['username'] = $user['username'];
        $_SESSION['level']    = $user['level'];
        $_SESSION['user_id']  = $user['id'];
        
        if (defined('BASE_URL')) {
            header("Location: " . BASE_URL . "admin/index.php?action=dashboard");
        } else {
            header("Location: ../admin/index.php?action=dashboard");
        }
        exit;

    } else {
        pesan('danger', "Password salah.");
        
        if (defined('BASE_URL')) {
            header("Location: " . BASE_URL . "admin/login.php");
        } else {
            header("Location: ../admin/login.php");
        }
        exit;
    }
} else {
    pesan('warning', "Username tidak ditemukan.");
    
    if (defined('BASE_URL')) {
        header("Location: " . BASE_URL . "admin/login.php");
    } else {
        header("Location: ../admin/login.php");
    }
    exit;
}
?>