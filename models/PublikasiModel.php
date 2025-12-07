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
                    STRING_AGG(p.nama_personil, ', ') as daftar_penulis
                FROM publikasi pb
                LEFT JOIN jenis_publikasi jp ON jp.id_jenis = pb.id_jenis
                LEFT JOIN personil_publikasi pp ON pp.id_publikasi = pb.id_publikasi
                LEFT JOIN personil p ON p.id_personil = pp.id_personil
                GROUP BY pb.id_publikasi, jp.nama_jenis
                ORDER BY pb.tahun DESC";
                
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function create($data, $personil_id)
    {
        try {
            $this->conn->beginTransaction();
            
            $query = "INSERT INTO publikasi (id_jenis, judul, tahun, link) 
                      VALUES (:id_jenis, :judul, :tahun, :link)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_jenis', $data['id_jenis']);
            $stmt->bindParam(':judul', $data['judul']);
            $stmt->bindParam(':tahun', $data['tahun']);
            $stmt->bindParam(':link', $data['link']);
            $stmt->execute();
            $id_publikasi = $this->conn->lastInsertId();

            if (!empty($personil_id)) {
                $queryRel = "INSERT INTO personil_publikasi (id_publikasi, id_personil) 
                             VALUES (:pub_id, :pers_id)";
                $stmtRel = $this->conn->prepare($queryRel);
    
                foreach ($personil_id as $p_id) {
                    $stmtRel->execute([
                        ':pub_id'  => $id_publikasi,
                        ':pers_id' => $p_id
                    ]);
                }
            }

            $this->conn->commit();
            return true;
            
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
    // [BARU] Ambil List Personil untuk Dropdown
    public function getListPersonil()
    {
        $query = "SELECT id_personil, nama_personil FROM personil ORDER BY nama_personil ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update($id, $data, $personil_id)
    {
        try {
            $this->conn->beginTransaction();
            $query = "UPDATE publikasi 
                      SET id_jenis = :id_jenis, 
                          judul = :judul, 
                          tahun = :tahun, 
                          link = :link 
                      WHERE id_publikasi = :id_publikasi";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_jenis', $data['id_jenis']);
            $stmt->bindParam(':judul', $data['judul']);
            $stmt->bindParam(':tahun', $data['tahun']);
            $stmt->bindParam(':link', $data['link']);
            $stmt->bindParam(':id_publikasi', $id); 
            
            $stmt->execute();

            $queryDelete = "DELETE FROM personil_publikasi WHERE id_publikasi = :id_publikasi";
            $stmtDelete = $this->conn->prepare($queryDelete);
            $stmtDelete->execute([':id_publikasi' => $id]);

            if (!empty($personil_id) && is_array($personil_id)) {
                $queryRel = "INSERT INTO personil_publikasi (id_publikasi, id_personil) 
                             VALUES (:pub_id, :pers_id)";
                $stmtRel = $this->conn->prepare($queryRel);
    
                foreach ($personil_id as $p_id) {
                    $stmtRel->execute([
                        ':pub_id'  => $id,
                        ':pers_id' => $p_id
                    ]);
                }
            }

            $this->conn->commit();
            return true;
            
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function delete($id)
    {
        $query = "DELETE FROM publikasi WHERE id_publikasi = :id_publikasi";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_publikasi', $id);
        return $stmt->execute();
    }

    // Ambil Publikasi Berdasarkan ID Personil
    public function getPublikasiByPersonil($id_personil)
    {
        $query = "SELECT 
                    pb.id_publikasi,
                    pb.judul,
                    pb.tahun,
                    pb.link,
                    jp.nama_jenis
                  FROM publikasi pb
                  JOIN jenis_publikasi jp ON jp.id_jenis = pb.id_jenis
                  JOIN publikasi_penulis pp ON pp.id_publikasi = pb.id_publikasi
                  WHERE pp.id_personil = :id_personil
                  ORDER BY pb.tahun DESC";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_personil', $id_personil);
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

    public function getSelectedAuthors($id_publikasi)
    {
        $query = "SELECT id_personil FROM personil_publikasi WHERE id_publikasi = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id_publikasi);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getPublikasiById($id)
    {
        $query = "SELECT * FROM publikasi WHERE id_publikasi = :id_publikasi LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_publikasi', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
?>