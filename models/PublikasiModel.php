<?php
class PublikasiModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Ambil Semua Publikasi (Untuk Tabel Utama)
    public function getAllPublikasi()
    {
        $query = "SELECT 
                    pb.id_publikasi,
                    pb.judul,
                    pb.link,
                    pb.tahun,
                    jp.nama_jenis, 
                    p.nama_personil,
                    p.nip
                FROM publikasi pb
                LEFT JOIN personil p ON p.id_personil = pb.id_personil
                LEFT JOIN jenis_publikasi jp ON jp.id_jenis = pb.id_jenis
                ORDER BY pb.tahun DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // [BARU] Ambil List Personil untuk Dropdown
    public function getListPersonil()
    {
        $query = "SELECT id_personil, nama_personil FROM personil ORDER BY nama_personil ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // [BARU] Ambil List Jenis Publikasi untuk Dropdown
    public function getListJenisPublikasi()
    {
        $query = "SELECT id_jenis, nama_jenis FROM jenis_publikasi ORDER BY nama_jenis ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $query = "INSERT INTO publikasi (id_personil, id_jenis, judul, tahun, link) 
                  VALUES (:id_personil, :id_jenis, :judul, :tahun, :link)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':id_personil', $data['id_personil']);
        $stmt->bindParam(':id_jenis', $data['id_jenis']);
        $stmt->bindParam(':judul', $data['judul']);
        $stmt->bindParam(':tahun', $data['tahun']);
        $stmt->bindParam(':link', $data['link']);

        return $stmt->execute();
    }

    public function getPublikasiById($id)
    {
        $query = "SELECT * FROM publikasi WHERE id_publikasi = :id_publikasi LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_publikasi', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data)
    {
        $query = "UPDATE publikasi SET 
                  id_personil = :id_personil, 
                  id_jenis = :id_jenis, 
                  judul = :judul, 
                  tahun = :tahun, 
                  link = :link 
                  WHERE id_publikasi = :id_publikasi";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_personil', $data['id_personil']);
        $stmt->bindParam(':id_jenis', $data['id_jenis']);
        $stmt->bindParam(':judul', $data['judul']);
        $stmt->bindParam(':tahun', $data['tahun']);
        $stmt->bindParam(':link', $data['link']);
        $stmt->bindParam(':id_publikasi', $id);

        return $stmt->execute();
    }

    public function delete($id)
    {
        $query = "DELETE FROM publikasi WHERE id_publikasi = :id_publikasi";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_publikasi', $id);
        return $stmt->execute();
    }
}
?>