<?php
class RecruitmentModel {

    private $conn;
    private $table = 'recruitment';
    
    public function __construct($db) {
        $this->conn = $db;
    }

    // =====================================================
    // CREATE - Tambah pendaftar baru
    // =====================================================
    public function create($data) {
        $query = "INSERT INTO {$this->table}
                  (nama, nim, prodi, email, no_hp, alasan_bergabung, 
                   riwayat_pengalaman, portofolio, cv, foto, angkatan, 
                   status, tanggal_daftar)
                  VALUES 
                  (:nama, :nim, :prodi, :email, :no_hp, :alasan_bergabung,
                   :riwayat_pengalaman, :portofolio, :cv, :foto, :angkatan,
                   'pending', NOW())";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':nama', $data['nama']);
        $stmt->bindParam(':nim', $data['nim']);
        $stmt->bindParam(':prodi', $data['prodi']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':no_hp', $data['no_hp']);
        $stmt->bindParam(':alasan_bergabung', $data['alasan_bergabung']);
        $stmt->bindParam(':riwayat_pengalaman', $data['riwayat_pengalaman']);
        $stmt->bindParam(':portofolio', $data['portofolio']);
        $stmt->bindParam(':cv', $data['cv']);
        $stmt->bindParam(':foto', $data['foto']);
        $stmt->bindParam(':angkatan', $data['angkatan']);

        return $stmt->execute();
    }

    // =====================================================
    // READ - Ambil semua pendaftar
    // =====================================================
    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY tanggal_daftar DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =====================================================
    // READ - Ambil pendaftar berdasarkan status
    // =====================================================
    public function getByStatus($status) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE status = :status 
                  ORDER BY tanggal_daftar DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =====================================================
    // READ - Ambil detail pendaftar
    // =====================================================
    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // =====================================================
    // UPDATE - Update status pendaftar
    // (Trigger SQL akan berjalan otomatis bila status = 'lulus')
    // =====================================================
    public function updateStatus($id, $status, $catatan = '') {

        $query = "UPDATE {$this->table}
                  SET status = :status, catatan = :catatan
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':catatan', $catatan);

        return $stmt->execute();
    }

    // =====================================================
    // DELETE - Hapus pendaftar
    // =====================================================
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // =====================================================
    // COUNT - Hitung jumlah pendaftar berdasarkan status
    // =====================================================
    public function countByStatus($status) {

        $query = "SELECT COUNT(*) as total 
                  FROM {$this->table} 
                  WHERE status = :status";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
?>
