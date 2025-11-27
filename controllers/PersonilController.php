<?php

$root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';

require_once $root . '/config/config.php'; 
require_once $root . '/models/personil.php';

class PersonilController {
    private $model;

    public function __construct($conn) {
        if (!$conn || !$conn instanceof PDO) {
            throw new Exception("Koneksi database gagal! Variabel \$conn bernilai NULL.");
        }
        $this->model = new PersonilModel($conn);
    }

    // 1. Halaman Depan (List Semua Personil)
    public function index() {
        try {
            $all_personnel = $this->model->getAllPersonil();

            foreach ($all_personnel as &$member) {
                // Pastikan foto memiliki fallback jika kosong
                $nama_file = !empty($member['foto']) ? $member['foto'] : 'default-profile.png';
                $member['foto'] = BASE_URL . 'assets/img/' . $nama_file;
            }

            return [
                'all_personnel' => $all_personnel,
                'error' => null
            ];

        } catch (PDOException $e) {
            return [
                'all_personnel' => [],
                'error' => "Kesalahan database: " . $e->getMessage()
            ];
        }
    }

    // 2. Halaman Detail Lengkap (Termasuk Publikasi & Spesialisasi)
    public function detail($id) {
        if (empty($id)) {
            return ['personnel' => null, 'error' => "ID personil tidak ditemukan."];
        }

        try {
            // Menggunakan fungsi getPersonilDetail (yang mengambil data lengkap + publikasi)
            $personnel = $this->model->getPersonilDetail($id);

            if ($personnel) {
                // Mapping Data
                $personnel['nama'] = $personnel['nama_personil'];
                $personnel['google_scholar_url'] = $personnel['link_gscholar'];
                $personnel['linkedin_url'] = $personnel['linkedin']; // Perbaikan: linkedin ke linkedin_url
                
                // Logika Gambar (Menggunakan kolom 'foto_personil' dari query p.*)
                $foto_db = $personnel['foto_personil']; 
                $nama_file = !empty($foto_db) ? $foto_db : 'default-profile.png';
                $personnel['foto'] = BASE_URL . 'assets/img/personil/' . $nama_file;

                $personnel['bio'] = $personnel['bio'] ?? 'Biografi belum tersedia.';

                return [
                    'personnel' => $personnel,
                    'error' => null
                ];
            }

            return ['personnel' => null, 'error' => "Personil dengan ID {$id} tidak ditemukan."];

        } catch (PDOException $e) {
            return ['personnel' => null, 'error' => "Kesalahan database: " . $e->getMessage()];
        }
    }
}
?>