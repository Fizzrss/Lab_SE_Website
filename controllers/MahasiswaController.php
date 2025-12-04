<?php
class MahasiswaController {
    private $db;
    private $model;
    private $root;
    
    public function __construct(MahasiswaAktifModel $model) {
        $this->model = $model;
        $this->root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';
    }
    
    // Fungsi utama untuk menyiapkan data ke View
    public function index() {
        try {
            $mahasiswa_list = $this->model->getAllMahasiswa();

            include $this->root . '/admin/pages/recruitment/list_mahasiswa.php';
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    }

    public function delete($id) {
        if (empty($id)) {
            $_SESSION['swal_error'] = "ID Mahasiswa tidak ditemukan!";
            header("Location: index.php?action=list_mahasiswa");
            exit;
        }

        if ($this->model->delete($id)) {
            $_SESSION['swal_success'] = "Data Mahasiswa berhasil dihapus!";
        } else {
            $_SESSION['swal_error'] = "Gagal menghapus data! Cek relasi data.";
        }

        header("Location: index.php?action=mahasiswa_list");
        exit;
    }


}
?>