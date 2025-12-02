<?php
// File: ../controllers/MahasiswaController.php

require_once '../config/config.php';
require_once '../models/MahasiswaModel.php';

class MahasiswaController {
    private $db;
    private $model;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->model = new MahasiswaModel($this->db);
    }
    
    // Fungsi utama untuk menyiapkan data ke View
    public function index() {
        $data = [
            'mahasiswa_list' => [],
            'prodi_list' => [],
            'default_foto_url' => 'https://images.unsplash.com/photo-1599566150163-29194dcaad36?auto=format&fit=crop&w=100&q=80',
        ];

        if ($this->db) {
            try {
                // Ambil data dari Model
                $data['mahasiswa_list'] = $this->model->getAllMahasiswa();
                $data['prodi_list'] = $this->model->getUniqueProdi();
                
            } catch (Exception $e) {
                // Biarkan array kosong jika gagal koneksi/query
                // Log the error here if needed
            }
        }

        return $data;
    }
}
?>