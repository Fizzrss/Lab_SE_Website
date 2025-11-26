<?php

// Pastikan PersonilModel sudah di-include
require_once ROOT_PATH . '/models/PersonilModel.php';

/**
 * Kelas Controller untuk mengelola alur data dan permintaan (requests) terkait personil.
 */
class PersonilController {
    private $model;

    public function __construct(PDO $pdo) {
        $this->model = new PersonilModel($pdo);
    }

    /**
     * Memproses permintaan untuk menampilkan daftar semua personil.
     * @return array Data yang akan ditampilkan di View.
     */
    public function index() {
        try {
            $all_personnel = $this->model->getAllPersonil();
            
            // Format URL foto di Controller sebelum dikirim ke View
            foreach ($all_personnel as &$member) {
                $member['foto'] = BASE_URL . 'assets/img/' . $member['foto'];
            }
            unset($member);

            return [
                'all_personnel' => $all_personnel,
                'error' => null
            ];
            
        } catch (PDOException $e) {
            return [
                'all_personnel' => [],
                'error' => "Kesalahan Database: " . $e->getMessage()
            ];
        }
    }

    /**
     * Memproses permintaan untuk menampilkan detail satu personil.
     * @param int $id ID personil dari GET request.
     * @return array Data yang akan ditampilkan di View.
     */
    public function detail($id) {
        if (empty($id)) {
            return [
                'personnel' => null,
                'error' => "ID Personil tidak ditemukan."
            ];
        }

        try {
            $personnel = $this->model->getPersonilDetail($id);

            if ($personnel) {
                // Penyesuaian nama kunci dan format data untuk View
                $personnel['nama'] = $personnel['nama_personil'];
                $personnel['google_scholar_url'] = $personnel['link_gscholar'];
                $personnel['researchgate_url'] = $personnel['linkedin']; 
                $personnel['foto'] = BASE_URL . 'assets/img/' . $personnel['foto_personil'];
                $personnel['bio'] = $personnel['bio'] ?? 'Biografi belum tersedia.';

                return [
                    'personnel' => $personnel,
                    'error' => null
                ];
            }

            return [
                'personnel' => null,
                'error' => "Personil dengan ID {$id} tidak ditemukan di database."
            ];

        } catch (PDOException $e) {
            return [
                'personnel' => null,
                'error' => "Kesalahan Database saat memuat detail: " . $e->getMessage()
            ];
        }
    }
}