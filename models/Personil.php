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
        // 1. Ambil Data Personil Saja (Tanpa Sosmed dulu)
        $sql_personnel = "
            SELECT 
                p.id_personil, 
                p.nip,
                p.nama_personil AS nama, 
                p.email,
                pj.jabatan_dosen AS peran, 
                p.foto_personil AS foto_file
            FROM personil p
            LEFT JOIN personil_jabatan pj ON p.id_jabatan = pj.id_jabatan
            ORDER BY p.id_personil ASC
        ";

        $stmt = $this->conn->query($sql_personnel);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $all_personnel = [];

        // 2. Loop setiap personil untuk ambil detail lainnya
        foreach ($results as $row) {
            
            // A. Ambil Spesialisasi
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

            // B. AMBIL SEMUA SOSMED (DINAMIS)
            // Kita ambil Link, Nama Sosmed, dan Icon-nya sekalian
            $sql_sosmed = "
                SELECT ps.link_sosmed, m.nama_sosmed, m.icon
                FROM personil_sosmed ps
                JOIN sosmed_personil m ON ps.id_sosmed = m.id_sosmed
                WHERE ps.id_personil = :id
            ";
            $stmt_sosmed = $this->conn->prepare($sql_sosmed);
            $stmt_sosmed->execute([':id' => $row['id_personil']]);
            $list_sosmed = $stmt_sosmed->fetchAll(PDO::FETCH_ASSOC);

            // C. Susun Data
            $all_personnel[] = [
                'id' => $row['id_personil'],
                'nip' => $row['nip'],
                'nama' => $row['nama'],
                'email' => $row['email'],
                'peran' => $row['peran'] ?? 'Tidak Ada Jabatan',
                'foto' => $row['foto_file'],
                'spesialisasi' => $spesialisasi,
                'sosmed' => $list_sosmed // <--- Ini sekarang berisi Array List Sosmed
            ];
        }

        return $all_personnel;
    }

    // Fungsi untuk Halaman Detail (Detail Profil)
    public function getPersonilDetail($id)
    {
        // 1. Ambil Data Diri Utama
        $sql = "
            SELECT 
                p.*, 
                pj.jabatan_dosen AS peran
            FROM personil p
            JOIN personil_jabatan pj ON p.id_jabatan = pj.id_jabatan
            WHERE p.id_personil = :id
        ";

        // Pastikan konsisten pakai $this->conn atau $this->pdo (sesuai constructor kamu)
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $personnel = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$personnel) return null;

        // 2. Ambil Semua Spesialisasi
        $sql_specs = "
            SELECT s.nama_spesialisasi 
            FROM personil_spesialisasi ps
            JOIN spesialisasi s ON ps.id_spesialisasi = s.id_spesialisasi
            WHERE ps.id_personil = :id
        ";
        $stmt_specs = $this->conn->prepare($sql_specs);
        $stmt_specs->execute([':id' => $id]);
        $personnel['spesialisasi'] = $stmt_specs->fetchAll(PDO::FETCH_COLUMN);

        // 3. [BARU] Ambil Semua Sosial Media
        // Kita ambil Link, Nama Sosmed, dan Icon-nya
        $sql_sosmed = "
            SELECT ps.link_sosmed, m.nama_sosmed, m.icon
            FROM personil_sosmed ps
            JOIN sosmed_personil m ON ps.id_sosmed = m.id_sosmed
            WHERE ps.id_personil = :id
        ";
        $stmt_sosmed = $this->conn->prepare($sql_sosmed);
        $stmt_sosmed->execute([':id' => $id]);
        $personnel['sosmed'] = $stmt_sosmed->fetchAll(PDO::FETCH_ASSOC);

        // 4. Ambil Publikasi
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
        $search_term = "%" . $keyword . "%";

        $sql_personnel = "
            SELECT 
                p.id_personil, 
                p.nip, 
                p.nama_personil AS nama, 
                p.email, 
                pj.jabatan_dosen AS peran, 
                p.foto_personil AS foto_file
            FROM personil p
            LEFT JOIN personil_jabatan pj ON p.id_jabatan = pj.id_jabatan
            WHERE 
                p.nama_personil ILIKE :k 
                OR p.email ILIKE :k 
                OR CAST(p.nip AS TEXT) ILIKE :k
            ORDER BY p.id_personil ASC
        ";

        $stmt = $this->conn->prepare($sql_personnel);
        $stmt->execute([':k' => $search_term]);
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

            $sql_sosmed = "
                SELECT ps.link_sosmed, m.nama_sosmed, m.icon
                FROM personil_sosmed ps
                JOIN sosmed_personil m ON ps.id_sosmed = m.id_sosmed
                WHERE ps.id_personil = :id
            ";
            $stmt_sosmed = $this->conn->prepare($sql_sosmed);
            $stmt_sosmed->execute([':id' => $row['id_personil']]);
            $list_sosmed = $stmt_sosmed->fetchAll(PDO::FETCH_ASSOC);

            $all_personnel[] = [
                'id' => $row['id_personil'],
                'nip' => $row['nip'],
                'nama' => $row['nama'],
                'email' => $row['email'],
                'peran' => $row['peran'] ?? 'Tidak Ada Jabatan',
                'foto' => $row['foto_file'],
                'spesialisasi' => $spesialisasi,
                'sosmed' => $list_sosmed 
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

    public function getAllMasterSosmed() {
        return $this->conn->query("SELECT * FROM sosmed_personil ORDER BY nama_sosmed ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPersonilSosmed($id_personil) {
        $sql = "SELECT ps.*, m.nama_sosmed 
                FROM personil_sosmed ps
                JOIN sosmed_personil m ON ps.id_sosmed = m.id_sosmed
                WHERE ps.id_personil = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id_personil]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPersonilSpesialisasiIDs($id_personil)
    {
        $sql = "SELECT id_spesialisasi FROM personil_spesialisasi WHERE id_personil = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id_personil]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function insert($data, $spesialisasi_ids = [], $sosmed_data = []) {
        try {
            $this->conn->beginTransaction();

            $sql = "INSERT INTO personil (nama_personil, nip, email, id_jabatan, foto_personil) 
                    VALUES (:nama, :nip, :email, :jabatan, :foto)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            $last_id = $this->conn->lastInsertId();

            if (!empty($spesialisasi_ids)) {
                $sql_spec = "INSERT INTO personil_spesialisasi (id_personil, id_spesialisasi) VALUES (?, ?)";
                $stmt_spec = $this->conn->prepare($sql_spec);
                foreach ($spesialisasi_ids as $sid) {
                    $stmt_spec->execute([$last_id, $sid]);
                }
            }

            if (!empty($sosmed_data)) {
                $sql_sosmed = "INSERT INTO personil_sosmed (id_personil, id_sosmed, link_sosmed) VALUES (?, ?, ?)";
                $stmt_sosmed = $this->conn->prepare($sql_sosmed);
                
                foreach ($sosmed_data as $sm) {
                    if (!empty($sm['link']) && !empty($sm['id_sosmed'])) {
                        $stmt_sosmed->execute([$last_id, $sm['id_sosmed'], $sm['link']]);
                    }
                }
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function update($id, $data, $spesialisasi_ids = [], $sosmed_data = []) {
        try {
            $this->conn->beginTransaction();

            $sql = "UPDATE personil SET nama_personil=:nama, nip=:nip, email=:email, id_jabatan=:jabatan, foto_personil=:foto WHERE id_personil=:id";
            $data['id'] = $id;
            $this->conn->prepare($sql)->execute($data);

            $this->conn->prepare("DELETE FROM personil_spesialisasi WHERE id_personil = ?")->execute([$id]);
            if (!empty($spesialisasi_ids)) {
                $stmt_spec = $this->conn->prepare("INSERT INTO personil_spesialisasi (id_personil, id_spesialisasi) VALUES (?, ?)");
                foreach ($spesialisasi_ids as $sid) {
                    $stmt_spec->execute([$id, $sid]);
                }
            }

            $this->conn->prepare("DELETE FROM personil_sosmed WHERE id_personil = ?")->execute([$id]);
            
            if (!empty($sosmed_data)) {
                $stmt_sosmed = $this->conn->prepare("INSERT INTO personil_sosmed (id_personil, id_sosmed, link_sosmed) VALUES (?, ?, ?)");
                foreach ($sosmed_data as $sm) {
                    if (!empty($sm['link']) && !empty($sm['id_sosmed'])) {
                        $stmt_sosmed->execute([$id, $sm['id_sosmed'], $sm['link']]);
                    }
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

            $sql_sosmed = "DELETE FROM personil_sosmed WHERE id_personil = ?";
            $this->conn->prepare($sql_sosmed)->execute([':id' => $id]);

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
