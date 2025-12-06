<?php

function set_flashdata($key = "", $value = ""){
    if (!empty($key) && !empty($value)) {
        $_SESSION['_flashdata'][$key] = $value;
        return true;
    }
    return false;
}

function get_flashdata($key = "")
{
    if (!empty($key) && isset($_SESSION['_flashdata'][$key])) {
        ($data = $_SESSION['_flashdata'][$key]);
        unset($_SESSION['_flashdata'][$key]);
        return $data;
    } else {
        echo "<script> alert('Flash Message \($key)\ is not defined. ')</script>";
    }
}

function pesan($key = "", $pesan = "")
{
    if ($key == "info") {
        set_flashdata('info', '<div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>Info!</strong> <strong>' . $pesan . '</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>');
    } elseif ($key == "success") {
        set_flashdata('success', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> <strong>' . $pesan . '</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>');
    } elseif ($key == "danger") {
        set_flashdata('danger', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> <strong>' . $pesan . '</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>');
    } elseif ($key == "warning") {
        set_flashdata('warning', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Peringatan!</strong> <strong>' . $pesan . '</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>');
    }
}

// New functions for berita system
function setFlashMessage($type, $message)
{
    $_SESSION['flash_message'] = [
        'type' => $type,
        'message' => $message
    ];
}

function getFlashMessage()
{
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        
        $alertClass = '';
        $title = '';
        
        switch ($flash['type']) {
            case 'success':
                $alertClass = 'alert-success';
                $title = 'Berhasil!';
                break;
            case 'danger':
                $alertClass = 'alert-danger';
                $title = 'Gagal!';
                break;
            case 'warning':
                $alertClass = 'alert-warning';
                $title = 'Peringatan!';
                break;
            case 'info':
                $alertClass = 'alert-info';
                $title = 'Info!';
                break;
            default:
                $alertClass = 'alert-primary';
                $title = 'Notifikasi';
        }
        
        return '<div class="alert ' . $alertClass . ' alert-dismissible fade show" role="alert">
            <strong>' . $title . '</strong> ' . htmlspecialchars($flash['message']) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    return '';
}
?>