<?php
// Definisikan BASE_URL
if (!defined('BASE_URL')) {
    if (file_exists('../config/config.php')) {
        require_once '../config/config.php';
    } else {
        define('BASE_URL', '../');
    }
}

// Panggil Controller
require_once '../controllers/RecruitmentController.php'; 

$page_title = "Pendaftaran";
$site_title = "Lab SE"; 
$status_pendaftaran = 'gagal';
$pesan = 'Terjadi kesalahan saat memproses data.';

// Cek apakah formulir telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        $data_to_controller = $_POST;

        // Mapping input
        $data_to_controller['no_hp'] = $data_to_controller['telepon'] ?? null;
        unset($data_to_controller['telepon']);

        $data_to_controller['alasan_bergabung'] = $data_to_controller['alasan'] ?? null;
        unset($data_to_controller['alasan']);

        $data_to_controller['riwayat_pengalaman'] = $data_to_controller['pengalaman'] ?? null;
        unset($data_to_controller['pengalaman']);

        $_POST = $data_to_controller;

        // Proses controller
        $controller = new RecruitmentController();
        $hasil = $controller->daftar();

        if ($hasil['success']) {
            $status_pendaftaran = 'sukses';
            $pesan = $hasil['message'];
        } else {
            $pesan = $hasil['message'] ?? 'Pendaftaran gagal!';
            if (!empty($hasil['errors'])) {
                $pesan .= "<br><br>Detail:<br><ul><li>"
                        . implode('</li><li>', $hasil['errors'])
                        . "</li></ul>";
            }
        }

    } catch (Exception $e) {
        $pesan = "Terjadi kesalahan sistem: " . $e->getMessage();
    }

} else {
    $pesan = 'Akses tidak sah.';
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($page_title) ?> - <?= htmlspecialchars($site_title) ?></title>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #eef1f4;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
    }

    .card {
        background: #fff;
        width: 90%;
        max-width: 600px;
        padding: 30px;
        border-radius: 14px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        text-align: center;
    }

    .icon {
        font-size: 70px;
        margin-bottom: 10px;
    }

    .success {
        color: #28a745;
    }

    .error {
        color: #dc3545;
    }

    h2 {
        margin-top: 0;
        margin-bottom: 10px;
        font-size: 28px;
        font-weight: bold;
    }

    .message {
        font-size: 16px;
        margin-bottom: 20px;
    }

    .alert {
        background: #ffe5e5;
        color: #a10000;
        padding: 12px;
        border-radius: 6px;
        text-align: left;
        font-size: 14px;
        margin-top: 15px;
    }

    .btn {
        display: inline-block;
        padding: 12px 20px;
        background: #007bff;
        color: #fff;
        font-size: 16px;
        border-radius: 8px;
        text-decoration: none;
        transition: 0.3s;
        margin-top: 15px;
    }

    .btn:hover {
        background: #0056b3;
    }
</style>
</head>

<body>

<div class="card">

    <?php if ($status_pendaftaran == 'sukses'): ?>
        
        <div class="icon success">✔</div>
        <h2 style="color:#28a745;">Pendaftaran Berhasil!</h2>
        <p class="message"><?= $pesan ?></p>

        <a href="recruitment_form.php" class="btn">← Kembali ke Formulir</a>

    <?php else: ?>

        <div class="icon error">✖</div>
        <h2 style="color:#dc3545;">Pendaftaran Gagal</h2>

        <div class="alert">
            <strong>Detail Kesalahan:</strong>
            <div><?= $pesan ?></div>
        </div>

        <a href="recruitment_form.php" class="btn">⟳ Coba Lagi</a>

    <?php endif; ?>

</div>

</body>
</html>
