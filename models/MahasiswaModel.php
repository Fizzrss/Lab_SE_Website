<?php
// File: ../models/MahasiswaModel.php

class MahasiswaModel {
    private $conn;
    private $table = 'mahasiswa_list';
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // READ: Ambil semua data mahasiswa
    public function getAllMahasiswa() {
        // Query disesuaikan dengan kolom di tabel: nama, nim, program_studi, status
        $query = "SELECT nama, nim, program_studi, status 
                  FROM public." . $this->table . " 
                  ORDER BY nim ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // READ: Ambil daftar program studi unik untuk filter
    public function getUniqueProdi() {
        $query = "SELECT DISTINCT program_studi 
                  FROM public." . $this->table . " 
                  WHERE program_studi IS NOT NULL 
                  ORDER BY program_studi ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        // Menggunakan FETCH_COLUMN untuk mendapatkan array 1 dimensi berisi nama prodi
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0); 
    }
}
?>