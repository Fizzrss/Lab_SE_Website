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

    public function index() {
        try {
            $all_personnel = $this->model->getAllPersonil();

            foreach ($all_personnel as &$member) {
                $member['foto'] = BASE_URL . 'assets/img/' . $member['foto'];
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

    public function detail($id) {
        if (empty($id)) {
            return [
                'personnel' => null,
                'error' => "ID personil tidak ditemukan."
            ];
        }

        try {
            $personnel = $this->model->getPersonilDetail($id);

            if ($personnel) {
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
                'error' => "Personil dengan ID {$id} tidak ditemukan."
            ];

        } catch (PDOException $e) {
            return [
                'personnel' => null,
                'error' => "Kesalahan database: " . $e->getMessage()
            ];
        }
    }
}
