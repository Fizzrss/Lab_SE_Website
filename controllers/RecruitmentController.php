<?php
require_once '../config/config.php';
require_once '../models/RecruitmentModel.php';

class RecruitmentController {
    private $model;
    private $root;
    
    public function __construct(RecruitmentModel $model) {
        $this->model = $model;
        $this->root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';
    }

    public function daftar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Invalid Request Method'];
        }

        try {
            if (empty($_POST['nama']) || empty($_POST['nim']) || empty($_POST['email'])) {
                throw new Exception("Data wajib (Nama, NIM, Email) tidak boleh kosong.");
            }

            if (!isset($_FILES['cv']) || $_FILES['cv']['error'] != 0) {
                throw new Exception("File CV wajib diupload.");
            }
            $cvName = $this->uploadFile($_FILES['cv'], 'cv');

            $fotoName = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                $fotoName = $this->uploadFile($_FILES['foto'], 'foto');
            }

            $portoName = null;
            if (isset($_FILES['portofolio']) && $_FILES['portofolio']['error'] == 0) {
                $portoName = $this->uploadFile($_FILES['portofolio'], 'portofolio');
            }

            $data = [
                'nama'               => htmlspecialchars($_POST['nama']),
                'nim'                => htmlspecialchars($_POST['nim']),
                'email'              => htmlspecialchars($_POST['email']),
                'prodi'              => htmlspecialchars($_POST['prodi']),
                'no_hp'              => htmlspecialchars($_POST['no_hp']),
                'angkatan'           => htmlspecialchars($_POST['angkatan']),
                'alasan_bergabung'   => htmlspecialchars($_POST['alasan_bergabung']),
                'riwayat_pengalaman' => htmlspecialchars($_POST['riwayat_pengalaman']),
                'foto'               => $fotoName,
                'portofolio'         => $portoName,
                'cv'                 => $cvName
            ];

            if ($this->model->create($data)) {
                return ['success' => true, 'message' => 'Pendaftaran berhasil! Terima kasih.'];
            } else {
                throw new Exception("Gagal menyimpan data ke database.");
            }

        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function adminIndex() {
        $data = $this->model->getAll();
        include '../admin/pages/recruitment/list_recruitment.php';
    }

    public function detail($id) {
        $data = $this->model->getById($id);
        include '../admin/pages/recruitment/detail_recruitment.php';
    }

    public function updateStatus($id, $status, $catatan = '') {
        if (session_status() === PHP_SESSION_NONE) session_start();

        try {
            $this->model->updateStatus($id, $status, $catatan);
            
            $_SESSION['swal_success'] = "Status peserta berhasil diubah menjadi " . ucfirst($status) . ".";

        } catch (Exception $e) {
            $_SESSION['swal_error'] = "Gagal: " . $e->getMessage();
        }

        header("Location: index.php?action=recruitment_list");
        exit();
    }

    public function processStatus($id, $status)
    {
        if (empty($id) || empty($status)) {
            $_SESSION['swal_error'] = "Data tidak valid.";
            header("Location: index.php?action=recruitment_list");
            exit;
        }

        try {
            if ($this->model->processDecision($id, $status)) {
                
                $pesan = ($status == 'lulus') ? "Peserta DITERIMA dan data dipindah ke Mahasiswa Aktif." : "Peserta DITOLAK.";
                $_SESSION['swal_success'] = $pesan;
                
            } else {
                $_SESSION['swal_error'] = "Gagal memproses data.";
            }
        } catch (Exception $e) {
            $_SESSION['swal_error'] = "Error: " . $e->getMessage();
        }

        header("Location: index.php?action=recruitment_list");
        exit;
    }

    public function delete($id) {
        if (empty($id)) {
            $_SESSION['swal_error'] = "ID Personil tidak ditemukan!";
            header("Location: index.php?action=recruitment_list");
            exit;
        }

        if ($this->model->delete($id)) {
            $_SESSION['swal_success'] = "Data recruitment berhasil dihapus!";
        } else {
            $_SESSION['swal_error'] = "Gagal menghapus data! Cek relasi data.";
        }

        header("Location: index.php?action=recruitment_list");
        exit;
    }


    private function uploadFile($file, $type) {
        $targetDir = $this->root . "/upload/" . $type . "/";

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileExt = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

        $fileName = time() . '_' . rand(100, 999) . '.' . $fileExt;
        $targetFile = $targetDir . $fileName;

        $allowed = [];

        if ($type == 'foto') {
            $allowed = ['jpg', 'jpeg', 'png'];
        } 
        elseif ($type == 'cv') {
            $allowed = ['pdf'];
        } 
        elseif ($type == 'portofolio') {
            $allowed = ['pdf'];
        } 
        else {
            $allowed = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
        }

        if (!in_array($fileExt, $allowed)) {
            $allowedString = implode(', ', $allowed);
            throw new Exception("Format file salah untuk $type. Hanya diperbolehkan: $allowedString.");
        }

        if ($file["size"] > 5000000) {
            throw new Exception("Ukuran file terlalu besar (Max 5MB).");
        }

        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $fileName; 
        }

        throw new Exception("Gagal mengupload file $type.");
    }
}
