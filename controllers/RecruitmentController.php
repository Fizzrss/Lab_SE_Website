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
        // Cek Method Request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Invalid Request Method'];
        }

        try {
            // --- A. VALIDASI INPUT ---
            if (empty($_POST['nama']) || empty($_POST['nim']) || empty($_POST['email'])) {
                throw new Exception("Data wajib (Nama, NIM, Email) tidak boleh kosong.");
            }

            // --- B. PROSES UPLOAD FILE ---
            
            // 1. Upload CV (Wajib)
            if (!isset($_FILES['cv']) || $_FILES['cv']['error'] != 0) {
                throw new Exception("File CV wajib diupload.");
            }
            $cvName = $this->uploadFile($_FILES['cv'], 'cv');

            // 2. Upload Foto (Opsional / Wajib tergantung kebijakan)
            $fotoName = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                $fotoName = $this->uploadFile($_FILES['foto'], 'foto');
            }

            // 3. Upload Portofolio (Opsional)
            $portoName = null;
            if (isset($_FILES['portofolio']) && $_FILES['portofolio']['error'] == 0) {
                $portoName = $this->uploadFile($_FILES['portofolio'], 'portofolio');
            }

            // --- C. PERSIAPAN DATA ---
            // htmlspecialchars digunakan untuk mencegah XSS Attack
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

            // --- D. SIMPAN KE DATABASE ---
            if ($this->model->create($data)) {
                return ['success' => true, 'message' => 'Pendaftaran berhasil! Terima kasih.'];
            } else {
                throw new Exception("Gagal menyimpan data ke database.");
            }

        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }


    /* ============================================================
       ADMIN SECTION
    ============================================================ */

    // Dashboard admin: ambil semua pendaftar
    public function adminIndex() {
        $data = $this->model->getAll();
        include '../admin/pages/recruitment/list_recruitment.php';
    }

    // Lihat detail pendaftar
    public function detail($id) {
        $data = $this->model->getById($id);
        include '../admin/pages/recruitment/detail_recruitment.php';
    }

    // Update status pendaftar
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

        // Redirect kembali ke detail atau list
        header("Location: index.php?action=recruitment_list"); // Atau ke detail jika mau
        exit;
    }

    // Hapus pendaftar
    public function delete($id) {
        if($this->model->delete($id)) {
            return ['success' => true, 'message' => 'Data berhasil dihapus!'];
        }
        return ['success' => false, 'message' => 'Gagal menghapus data'];
    }


    /* ============================================================
       HELPER: Upload File (Modified)
    ============================================================ */

    private function uploadFile($file, $type) {
        // Tentukan folder tujuan (misal: /upload/cv/ atau /upload/foto/)
        $targetDir = $this->root . "/upload/" . $type . "/";

        // Buat folder otomatis jika belum ada
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Ambil ekstensi file
        $fileExt = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        
        // Generate nama file unik
        $fileName = time() . '_' . rand(100, 999) . '.' . $fileExt;
        $targetFile = $targetDir . $fileName;

        // --- VALIDASI EKSTENSI BERDASARKAN TIPE ---
        $allowed = [];

        if ($type == 'foto') {
            // Khusus Foto: Hanya boleh gambar
            $allowed = ['jpg', 'jpeg', 'png'];
        } 
        elseif ($type == 'cv') {
            // Khusus CV: Dokumen
            $allowed = ['pdf', 'doc', 'docx'];
        } 
        elseif ($type == 'portofolio') {
            // Portofolio: Bisa dokumen atau gambar
            $allowed = ['pdf', 'jpg', 'jpeg', 'png'];
        } 
        else {
            // Default (jika ada tipe lain)
            $allowed = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
        }

        // Cek apakah ekstensi ada di daftar yang diperbolehkan
        if (!in_array($fileExt, $allowed)) {
            // Ubah array jadi string agar pesan error lebih jelas (contoh: "jpg, jpeg, png")
            $allowedString = implode(', ', $allowed);
            throw new Exception("Format file salah untuk $type. Hanya diperbolehkan: $allowedString.");
        }

        // Validasi Ukuran (Max 5MB)
        if ($file["size"] > 5000000) {
            throw new Exception("Ukuran file terlalu besar (Max 5MB).");
        }

        // Pindahkan file dari folder sementara ke folder tujuan
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $fileName; 
        }

        throw new Exception("Gagal mengupload file $type.");
    }
}
