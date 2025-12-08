<?php
class MahasiswaController {
    private $db;
    private $model;
    private $root;
    
    public function __construct(MahasiswaAktifModel $model) {
        $this->model = $model;
        $this->root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';
    }

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

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = [
                    'nama'               => htmlspecialchars($_POST['nama']),
                    'nim'                => htmlspecialchars($_POST['nim']),
                    'email'              => htmlspecialchars($_POST['email']),
                    'no_hp'              => htmlspecialchars($_POST['no_hp']),
                    'prodi'              => htmlspecialchars($_POST['prodi']),
                    'angkatan'           => htmlspecialchars($_POST['angkatan']),
                    'posisi'             => htmlspecialchars($_POST['posisi']),
                    'status'             => htmlspecialchars($_POST['status'])
                ];

                if ($this->model->update($id, $data)) {
                    $_SESSION['swal_success'] = "Data pendaftar berhasil diperbarui.";
                    header("Location: index.php?action=mahasiswa_list");
                    exit();
                } else {
                    echo "<script>alert('Gagal mengupdate data!'); window.history.back();</script>";
                }

            } catch (Exception $e) {
                $_SESSION['swal_error'] = "Error: " . $e->getMessage();
                echo "<script>window.history.back();</script>";
            }

        }
        $data = $this->model->getById($id);

        if (!$data) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            $_SESSION['swal_error'] = "Data pendaftar tidak ditemukan.";
            header("Location: index.php?action=mahasiswa_list");
            exit();
        }

        include $this->root . '/admin/pages/recruitment/edit_mahasiswa.php';
    }

}
?>