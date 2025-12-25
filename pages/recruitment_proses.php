<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';

require_once $root . '/config/config.php';
require_once $root . '/models/RecruitmentModel.php';
require_once $root . '/controllers/RecruitmentController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: recruitment_form.php");
    exit();
}


try {
    $database = new Database();
    $db = $database->getConnection();

    $model = new RecruitmentModel($db);

    $controller = new RecruitmentController($model);
    
    $result = $controller->daftar();

    if ($result['success']) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = $result['message'];
        header("Location: recruitment_form.php?status=success");
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = $result['message'];
        header("Location: recruitment_form.php?status=error");
    }

} catch (Exception $e) {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = "Terjadi kesalahan sistem: " . $e->getMessage();
    header("Location: recruitment_form.php?status=error");
}

exit();
?>