<?php
class RecruitmentModel
{

    private $conn;
    private $table = 'recruitment';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($data)
    {
        $query = "INSERT INTO {$this->table}
                  (nama, nim, prodi, email, no_hp, alasan_bergabung, 
                   riwayat_pengalaman, portofolio, cv, foto, angkatan, 
                   status, tanggal_daftar)
                  VALUES 
                  (:nama, :nim, :prodi, :email, :no_hp, :alasan_bergabung,
                   :riwayat_pengalaman, :portofolio, :cv, :foto, :angkatan,
                   'pending', NOW())";

        $stmt = $this->conn->prepare($query);

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

    public function getAll($showAll = false)
    {
        $query = "SELECT * FROM {$this->table} ORDER BY tanggal_daftar DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByStatus($status)
    {
        $query = "SELECT * FROM {$this->table} 
                  WHERE status = :status 
                  ORDER BY tanggal_daftar DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status, $catatan = '')
    {
        $query = "UPDATE {$this->table} SET status = :status, catatan = :catatan WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id, ':status' => $status, ':catatan' => $catatan]);
        return true;
    }

    public function processDecision($id, $status)
    {
        try {
            $this->conn->beginTransaction();

            if ($status == 'lulus') {
                $sql_get = "SELECT * FROM recruitment WHERE id = :id";
                $stmt_get = $this->conn->prepare($sql_get);
                $stmt_get->execute([':id' => $id]);
                $pendaftar = $stmt_get->fetch(PDO::FETCH_ASSOC);

                if (!$pendaftar) {
                    throw new Exception("Data pendaftar tidak ditemukan.");
                }

                $sql_check = "SELECT COUNT(*) FROM mahasiswa_aktif WHERE nim = :nim";
                $stmt_check = $this->conn->prepare($sql_check);
                $stmt_check->execute([':nim' => $pendaftar['nim']]);

                if ($stmt_check->fetchColumn() == 0) {

                    $sql_insert = "INSERT INTO mahasiswa_aktif 
                        (recruitment_id, nama, nim, prodi, email, no_hp, angkatan, posisi, status, tanggal_bergabung, foto) 
                        VALUES 
                        (:id, :nama, :nim, :prodi, :email, :hp, :angk, :posisi, 'aktif', NOW(), :foto)";

                    $stmt_ins = $this->conn->prepare($sql_insert);

                    $stmt_ins->execute([
                        ':id' => $id,
                        ':nama' => $pendaftar['nama'],
                        ':nim' => $pendaftar['nim'],
                        ':prodi' => $pendaftar['prodi'],
                        ':email' => $pendaftar['email'],
                        ':hp' => $pendaftar['no_hp'],
                        ':angk' => $pendaftar['angkatan'],
                        ':posisi' => 'anggota',

                        ':foto' => $pendaftar['foto'] ?? null
                    ]);
                }
            }
            
            if ($status == 'tidak_lulus') {
                $status = 'tidak lulus';
            }
            $sql_update = "UPDATE recruitment SET status = :status WHERE id = :id";
            $stmt_upd = $this->conn->prepare($sql_update);
            $stmt_upd->execute([':status' => $status, ':id' => $id]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function countByStatus($status)
    {

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
