<?php
class SpesialisasiModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Ambil Semua Data (Untuk List Admin & Dropdown di Form Personil)
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM spesialisasi ORDER BY nama_spesialisasi ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tambah Spesialisasi Baru
    public function insert($nama) {
        $stmt = $this->pdo->prepare("INSERT INTO spesialisasi (nama_spesialisasi) VALUES (:nama)");
        return $stmt->execute([':nama' => $nama]);
    }

    // Hapus Spesialisasi
    public function delete($id) {
        // Hapus dulu relasinya di personil_spesialisasi agar tidak error foreign key
        $this->pdo->prepare("DELETE FROM personil_spesialisasi WHERE id_spesialisasi = ?")->execute([$id]);
        
        // Baru hapus masternya
        return $this->pdo->prepare("DELETE FROM spesialisasi WHERE id_spesialisasi = ?")->execute([$id]);
    }
}
?>