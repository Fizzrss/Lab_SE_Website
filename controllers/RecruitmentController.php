<?php
require_once '../config/config.php';
require_once '../models/RecruitmentModel.php';

class RecruitmentController {
    private $db;
    private $recruitment;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->recruitment = new RecruitmentModel($this->db);
    }

    /* ============================================================
       PUBLIC / LANDING PAGE SECTION
    ============================================================ */

    // Tampilkan form pendaftaran
    public function showForm() {
        include '../views/landing/form.php';
    }

    // Proses pendaftaran
    public function daftar() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Invalid method'];
        }

        $errors = [];

        if(empty($_POST['nama'])) $errors[] = "Nama harus diisi";
        if(empty($_POST['nim'])) $errors[] = "NIM harus diisi";
        if(empty($_POST['email'])) $errors[] = "Email harus diisi";

        if(!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $cv = $this->uploadFile($_FILES['cv'], 'cv');

        $portofolio = '';
        if(isset($_FILES['portofolio']) && $_FILES['portofolio']['error'] == 0) {
            $portofolio = $this->uploadFile($_FILES['portofolio'], 'portofolio');
        }

        $data = [
            'nama' => htmlspecialchars($_POST['nama']),
            'nim' => htmlspecialchars($_POST['nim']),
            'email' => htmlspecialchars($_POST['email']),
            'prodi' => htmlspecialchars($_POST['prodi']),
            'no_hp' => htmlspecialchars($_POST['no_hp']),
            'alasan_bergabung' => htmlspecialchars($_POST['alasan_bergabung']),
            'riwayat_pengalaman' => htmlspecialchars($_POST['riwayat_pengalaman']),
            'portofolio' => $portofolio,
            'cv' => $cv
        ];

        if($this->recruitment->create($data)) {
            return ['success' => true, 'message' => 'Pendaftaran berhasil!'];
        }

        return ['success' => false, 'message' => 'Pendaftaran gagal!'];
    }


    /* ============================================================
       ADMIN SECTION
    ============================================================ */

    // Dashboard admin: ambil semua pendaftar
    public function adminIndex() {
        $data = $this->recruitment->getAll();
        include '../admin/pages/recruitment/pendaftar.php';
    }

    // Lihat detail pendaftar
    public function detail($id) {
        $data = $this->recruitment->getById($id);
        include '../views/admin/detail.php';
    }

    // Update status pendaftar
    public function updateStatus($id, $status, $catatan = '') {
        if($this->recruitment->updateStatus($id, $status, $catatan)) {
            return ['success' => true, 'message' => 'Status berhasil diupdate!'];
        }
        return ['success' => false, 'message' => 'Status gagal diupdate!'];
    }

    // Hapus pendaftar
    public function delete($id) {
        if($this->recruitment->delete($id)) {
            return ['success' => true, 'message' => 'Data berhasil dihapus!'];
        }
        return ['success' => false, 'message' => 'Gagal menghapus data'];
    }


    /* ============================================================
       HELPER: Upload File
    ============================================================ */

    private function uploadFile($file, $type) {
        $targetDir = "../upload/" . $type . "/";

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . '_' . basename($file["name"]);
        $targetFile = $targetDir . $fileName;

        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $allowed = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
        if(!in_array($fileType, $allowed)) {
            throw new Exception("Format file tidak diizinkan");
        }

        if($file["size"] > 5000000) {
            throw new Exception("File terlalu besar (max 5MB)");
        }

        if(move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $fileName;
        }

        throw new Exception("Upload file gagal");
    }
}
