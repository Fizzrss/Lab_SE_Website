<?php
class MahasiswaAktifModel {
    private $conn;
    private $table = 'mahasiswa_aktif';
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (recruitment_id, nama, nim, prodi, email, no_hp, angkatan, posisi, status, tanggal_bergabung, foto) 
                  VALUES (:recruitment_id, :nama, :nim, :prodi, :email, :no_hp, :angkatan, :posisi, :status, :tanggal_bergabung, :foto)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':recruitment_id', $data['recruitment_id']);
        $stmt->bindParam(':nama', $data['nama']);
        $stmt->bindParam(':nim', $data['nim']);
        $stmt->bindParam(':prodi', $data['prodi']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':no_hp', $data['no_hp']);
        $stmt->bindParam(':angkatan', $data['angkatan']);
        $stmt->bindParam(':posisi', $data['posisi']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':tanggal_bergabung', $data['tanggal_bergabung']);
        $stmt->bindParam(':foto', $data['foto']);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function getAllMahasiswa() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllPublic() {
        $query = "SELECT
                    nama,
                    nim,
                    prodi,
                    status,
                    foto    
                FROM " . $this->table . " WHERE status = 'aktif' ORDER BY nama ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByStatusAktif() {
        $query = "SELECT * FROM " . $this->table . " WHERE status = 'aktif' ORDER BY nama ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function getByPosisi($posisi) {
        $query = "SELECT * FROM " . $this->table . " WHERE posisi = :posisi AND status = 'aktif' ORDER BY nama ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':posisi', $posisi);
        $stmt->execute();
        return $stmt;
    }
    
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET nama = :nama, email = :email, no_hp = :no_hp, 
                      posisi = :posisi, status = :status 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $data['nama']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':no_hp', $data['no_hp']);
        $stmt->bindParam(':posisi', $data['posisi']);
        $stmt->bindParam(':status', $data['status']);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function countAktif() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE status = 'aktif'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
?>