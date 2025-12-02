<?php
// admin/pages/recruitment/proses_seleksi.php

$root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';
require_once $root . '/config/config.php';
require_once $root . '/helpers/flash_message.php'; 

// Pastikan sudah start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$database = new Database();
$conn = $database->getConnection();

$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
$query = '';

if ($action && $id) {
    
    if ($action == 'lulus') {
        // --- LOGIKA LULUS (3 STEP) ---
        $select_query = "SELECT * FROM recruitment WHERE id = :id";
        $stmt_select = $conn->prepare($select_query);
        $stmt_select->bindParam(':id', $id);
        $stmt_select->execute();
        $pendaftar = $stmt_select->fetch(PDO::FETCH_ASSOC);

        if ($pendaftar) {
            
            $insert_query = "INSERT INTO mahasiswa_aktif 
                             (recruitment_id, nama, nim, prodi, email, no_hp, angkatan, status, tanggal_bergabung, foto)
                             VALUES (:rec_id, :nama, :nim, :prodi, :email, :no_hp, :angkatan, 'aktif', NOW(), :foto)";

            $stmt_insert = $conn->prepare($insert_query);
            
            $data_aktif = [
                ':rec_id' => $id,
                ':nama' => $pendaftar['nama'],
                ':nim' => $pendaftar['nim'],
                ':prodi' => $pendaftar['prodi'],
                ':email' => $pendaftar['email'],
                ':no_hp' => $pendaftar['no_hp'],
                ':angkatan' => $pendaftar['angkatan'],
                // Gunakan kolom CV/Foto yang benar
                ':foto' => $pendaftar['cv'] ?? null 
            ];
            
            if ($stmt_insert->execute($data_aktif)) { // <-- execute dengan array data
                // Berhasil Insert, Lanjutkan Update Status
                $query = "UPDATE recruitment SET status = 'lulus' WHERE id = :id";
                set_flashdata('success', 'Mahasiswa dinyatakan LULUS dan data berhasil dipindahkan ke data Aktif.');
            } else {
                set_flashdata('danger', 'Gagal memindahkan data ke Mahasiswa Aktif.');
                header("Location: pendaftar.php");
                exit;
            }

        } else {
            set_flashdata('danger', 'ID pendaftar tidak ditemukan.');
            header("Location: pendaftar.php");
            exit;
        }

    } 
    elseif ($action == 'tidak_lulus') {
        $query = "UPDATE recruitment SET status = 'tidak lulus' WHERE id = :id";
        set_flashdata('success', 'Mahasiswa dinyatakan TIDAK LULUS.');
    }
    elseif ($action == 'hapus') {
        $query = "DELETE FROM recruitment WHERE id = :id";
        set_flashdata('success', 'Data pendaftar berhasil dihapus.');
    }
    
    // --- EKSEKUSI QUERY UPDATE/DELETE ---
    if ($query) {
        try {
            $stmt = $conn->prepare($query);
            // KARENA HANYA 1 PARAMETER (:id), bindParam AMAN digunakan di sini.
            $stmt->bindParam(':id', $id); 
            
            if($stmt->execute()) {
                header("Location: pendaftar.php");
                exit;
            } else {
                set_flashdata('danger', 'Terjadi kesalahan saat mengeksekusi query.');
                header("Location: pendaftar.php");
                exit;
            }
        } catch(PDOException $e) {
            set_flashdata('danger', 'Error Database: ' . $e->getMessage());
            header("Location: pendaftar.php");
            exit;
        }
    }
} else {
    header("Location: pendaftar.php");
    exit;
}
?>