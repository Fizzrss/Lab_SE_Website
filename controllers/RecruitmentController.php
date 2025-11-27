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
    
    // Proses pendaftaran
    public function daftar() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validasi input
            $errors = [];
            
            if(empty($_POST['nama'])) $errors[] = "Nama harus diisi";
            if(empty($_POST['nim'])) $errors[] = "NIM harus diisi";
            if(empty($_POST['email'])) $errors[] = "Email harus diisi";
            
            if(!empty($errors)) {
                return ['success' => false, 'errors' => $errors];
            }
            
            // Upload CV
            $cv = $this->uploadFile($_FILES['cv'], 'cv');
            
            // Upload Portofolio (opsional)
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
            } else {
                return ['success' => false, 'message' => 'Pendaftaran gagal!'];
            }
        }
    }
    
    // Update status pendaftar
    public function updateStatus($id, $status, $catatan = '') {
        if($this->recruitment->updateStatus($id, $status, $catatan)) {
            return ['success' => true, 'message' => 'Status berhasil diupdate!'];
        } else {
            return ['success' => false, 'message' => 'Status gagal diupdate!'];
        }
    }
    
    // Hapus pendaftar
    public function delete($id) {
        if($this->recruitment->delete($id)) {
            return ['success' => true, 'message' => 'Data berhasil dihapus!'];
        } else {
            return ['success' => false, 'message' => 'Data gagal dihapus!'];
        }
    }
    
    // Upload file helper
    private function uploadFile($file, $type) {
        $targetDir = "../upload/" . $type . "/";
        
        // Buat folder jika belum ada
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        $fileName = time() . '_' . basename($file["name"]);
        $targetFile = $targetDir . $fileName;
        
        // Validasi file
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
        
        if(!in_array($fileType, $allowedTypes)) {
            throw new Exception("Format file tidak diizinkan");
        }
        
        // Max 5MB
        if($file["size"] > 5000000) {
            throw new Exception("File terlalu besar (max 5MB)");
        }
        
        if(move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $fileName;
        } else {
            throw new Exception("Upload file gagal");
        }
    }
}
?>

