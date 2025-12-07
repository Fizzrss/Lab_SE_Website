<?php
class SpesialisasiModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Ambil Semua Data (Untuk List Admin & Dropdown di Form Personil)
    public function getAll() {
        $query = "SELECT * FROM spesialisasi ORDER BY nama_spesialisasi ASC";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tambah Spesialisasi Baru
    public function create($nama) {
        $query = "INSERT INTO spesialisasi (nama_spesialisasi)
                  VALUES (:nama)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nama', $nama);
        return $stmt->execute([':nama' => $nama]);
    }

    public function getById($id) {
        $query = "SELECT * FROM spesialisasi WHERE id_spesialisasi = :id_spesialisasi";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_spesialisasi', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $query = "UPDATE spesialisasi SET nama_spesialisasi = :nama_spesialisasi WHERE id_spesialisasi = :id_spesialisasi";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_spesialisasi', $id);
        $stmt->bindParam(':nama_spesialisasi', $data['nama_spesialisasi']);
        return $stmt->execute();
    }

    // Hapus Spesialisasi
    public function delete($id) {
        $this->conn->prepare("DELETE FROM personil_spesialisasi WHERE id_spesialisasi = ?")->execute([$id]);
        
        return $this->conn->prepare("DELETE FROM spesialisasi WHERE id_spesialisasi = ?")->execute([$id]);
    }
}
?>