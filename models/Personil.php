<?php

class PersonilModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Fungsi untuk Halaman Depan (List Personil)
    public function getAllPersonil()
    {
        $sql_personnel = "
            SELECT 
                p.id_personil, 
                p.nip,           
                p.nama_personil AS nama, 
                p.email,         
                p.link_gscholar, 
                p.linkedin,      
                pj.jabatan_dosen AS peran, 
                p.foto_personil AS foto_file
            FROM personil p
            LEFT JOIN personil_jabatan pj ON p.id_jabatan = pj.id_jabatan
            ORDER BY p.id_personil ASC
        ";

        $stmt = $this->conn->query($sql_personnel);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $all_personnel = [];

        foreach ($results as $row) {
            $sql_spec = "
                SELECT s.nama_spesialisasi 
                FROM personil_spesialisasi ps
                JOIN spesialisasi s ON ps.id_spesialisasi = s.id_spesialisasi
                WHERE ps.id_personil = :id
                LIMIT 1
            ";
            $stmt_spec = $this->conn->prepare($sql_spec);
            $stmt_spec->execute([':id' => $row['id_personil']]);
            $spesialisasi = $stmt_spec->fetchColumn() ?: '-';

            $all_personnel[] = [
                'id' => $row['id_personil'],
                'nip' => $row['nip'],
                'nama' => $row['nama'],
                'email' => $row['email'],
                'gscholar' => $row['link_gscholar'],
                'linkedin' => $row['linkedin'],
                'peran' => $row['peran'] ?? 'Tidak Ada Jabatan',
                'foto' => $row['foto_file'],
                'spesialisasi' => $spesialisasi,
            ];
        }

        return $all_personnel;
    }

    // Fungsi untuk Halaman Detail (Detail Profil)
    public function getPersonilDetail($id)
    {
        // Ambil Data Diri
        $sql = "
            SELECT 
                p.*, 
                pj.jabatan_dosen AS peran
            FROM personil p
            JOIN personil_jabatan pj ON p.id_jabatan = pj.id_jabatan
            WHERE p.id_personil = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $personnel = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$personnel) return null;

        // Ambil Semua Spesialisasi
        $sql_specs = "
            SELECT s.nama_spesialisasi 
            FROM personil_spesialisasi ps
            JOIN spesialisasi s ON ps.id_spesialisasi = s.id_spesialisasi
            WHERE ps.id_personil = :id
        ";
        $stmt_specs = $this->conn->prepare($sql_specs);
        $stmt_specs->execute([':id' => $id]);
        $personnel['spesialisasi'] = $stmt_specs->fetchAll(PDO::FETCH_COLUMN);

        // Ambil Publikasi
        $sql_pub = "SELECT * FROM publikasi WHERE id_personil = :id ORDER BY tahun DESC";
        $stmt_pub = $this->conn->prepare($sql_pub);
        $stmt_pub->execute([':id' => $id]);
        $personnel['publikasi'] = $stmt_pub->fetchAll(PDO::FETCH_ASSOC);

        return $personnel;
    }

    // Fungsi baru: Ambil satu data personil berdasarkan ID
    public function getById($id)
    {
        $sql = "
            SELECT 
                p.*, 
                p.foto_personil AS foto_file,  -- Kita samakan aliasnya agar konsisten
                pj.jabatan_dosen AS peran
            FROM personil p
            LEFT JOIN personil_jabatan pj ON p.id_jabatan = pj.id_jabatan
            WHERE p.id_personil = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    // Fungsi baru: Pencarian personil berdasarkan nama atau NIP
    public function searchPersonil($keyword)
    {
        $keyword = "%" . $keyword . "%";
        $sql_personnel = "
            SELECT 
                p.id_personil, 
                p.nip,           
                p.nama_personil AS nama, 
                p.email,         
                p.link_gscholar, 
                p.linkedin,      
                pj.jabatan_dosen AS peran, 
                p.foto_personil AS foto_file
            FROM personil p
            LEFT JOIN personil_jabatan pj ON p.id_jabatan = pj.id_jabatan
            WHERE 
                p.nama_personil ILIKE :keyword
                OR p.nip ILIKE :keyword
            ORDER BY p.id_personil ASC
        ";

        $stmt = $this->conn->prepare($sql_personnel);
        $stmt->execute([':keyword' => $keyword]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $all_personnel = [];

        foreach ($results as $row) {
            $spesialisasi = '-';
            $all_personnel[] = [
                'id' => $row['id_personil'],
                'nip' => $row['nip'],
                'nama' => $row['nama'],
                'email' => $row['email'],
                'gscholar' => $row['link_gscholar'],
                'linkedin' => $row['linkedin'],
                'peran' => $row['peran'] ?? 'Tidak Ada Jabatan',
                'foto' => $row['foto_file'],
                'spesialisasi' => $spesialisasi,
            ];
        }

        return $all_personnel;
    }

    public function getAllJabatan()
    {
        $stmt = $this->conn->query("SELECT * FROM personil_jabatan ORDER BY id_jabatan ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSpesialisasi()
    {
        return $this->conn->query("SELECT * FROM spesialisasi ORDER BY nama_spesialisasi ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPersonilSpesialisasiIDs($id_personil)
    {
        $sql = "SELECT id_spesialisasi FROM personil_spesialisasi WHERE id_personil = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id_personil]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function insert($data, $spesialisasi_ids = [])
    {
        try {
            $this->conn->beginTransaction();

            // 1. Insert Personil
            $sql = "INSERT INTO personil (nama_personil, nip, email, id_jabatan, link_gscholar, linkedin, foto_personil) 
                    VALUES (:nama, :nip, :email, :jabatan, :gscholar, :linkedin, :foto)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            $last_id = $this->conn->lastInsertId();

            // 2. Insert Spesialisasi (Looping ID dari Dropdown)
            if (!empty($spesialisasi_ids)) {
                $sql_rel = "INSERT INTO personil_spesialisasi (id_personil, id_spesialisasi) VALUES (:pid, :sid)";
                $stmt_rel = $this->conn->prepare($sql_rel);

                foreach ($spesialisasi_ids as $sid) {
                    // Langsung simpan ID-nya
                    $stmt_rel->execute([':pid' => $last_id, ':sid' => $sid]);
                }
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function update($id, $data, $spesialisasi_ids = [])
    {
        try {
            $this->conn->beginTransaction();

            // 1. Update Personil
            $sql = "UPDATE personil SET 
                    nama_personil = :nama, nip = :nip, email = :email, 
                    id_jabatan = :jabatan, link_gscholar = :gscholar, linkedin = :linkedin, foto_personil = :foto 
                    WHERE id_personil = :id";
            $data['id'] = $id;
            $this->conn->prepare($sql)->execute($data);

            // 2. Reset Spesialisasi Lama
            $this->conn->prepare("DELETE FROM personil_spesialisasi WHERE id_personil = ?")->execute([$id]);

            // 3. Insert Spesialisasi Baru
            if (!empty($spesialisasi_ids)) {
                $sql_rel = "INSERT INTO personil_spesialisasi (id_personil, id_spesialisasi) VALUES (:pid, :sid)";
                $stmt_rel = $this->conn->prepare($sql_rel);

                foreach ($spesialisasi_ids as $sid) {
                    $stmt_rel->execute([':pid' => $id, ':sid' => $sid]);
                }
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $this->conn->beginTransaction();

            $sql_spesiali = "DELETE FROM personil_spesialisasi WHERE id_personil = :id";
            $this->conn->prepare($sql_spesiali)->execute([':id' => $id]);

            $sql_publikasi = "DELETE FROM publikasi WHERE id_personil = :id";
            $this->conn->prepare($sql_publikasi)->execute([':id' => $id]);

            $sql_personil = "DELETE FROM personil WHERE id_personil = :id";
            $this->conn->prepare($sql_personil)->execute([':id' => $id]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
