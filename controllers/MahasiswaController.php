<?php
// include_once $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website/models/MahasiswaModel.php';

class MahasiswaController {
    private $model;

    public function __construct($db) {
        $this->model = new MahasiswaAktifModel($db);
    }

    // Logic untuk halaman index (List Data)
    public function index() {
        // Panggil model untuk dapat data
        return $this->model->getAllMahasiswa();
    }

    // Logic untuk menghapus data
    public function delete($id) {
        if ($this->model->delete($id)) {
            pesan('success', 'Data anggota berhasil dihapus.');
            return true;
        } else {
            pesan('danger', 'Gagal menghapus data.');
            return false;
        }
    }
}
?>