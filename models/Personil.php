<?php

class PersonilModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Fungsi untuk Halaman Depan (List Personil)
    public function getAllPersonil() {
        $sql_personnel = "
            SELECT 
                p.id_personil, 
                p.nama_personil AS nama, 
                pj.jabatan_dosen AS peran,  -- Pastikan nama kolom ini benar di DB
                p.foto_personil AS foto_file
            FROM personil p
            JOIN personil_jabatan pj ON p.id_jabatan = pj.id_jabatan -- PERBAIKAN TYPO DISINI
            ORDER BY p.id_personil ASC
        ";

        $stmt = $this->pdo->query($sql_personnel);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $all_personnel = [];

        foreach ($results as $row) {
            // Ambil Spesialisasi
            $sql_spec = "
                SELECT s.nama_spesialisasi 
                FROM personil_spesialisasi ps
                JOIN spesialisasi s ON ps.id_spesialisasi = s.id_spesialisasi
                WHERE ps.id_personil = :id
                LIMIT 1
            ";
            $stmt_spec = $this->pdo->prepare($sql_spec);
            $stmt_spec->execute([':id' => $row['id_personil']]);
            $spesialisasi = $stmt_spec->fetchColumn() ?: 'Belum Ada Spesialisasi';

            $all_personnel[] = [
                'id' => $row['id_personil'],
                'nama' => $row['nama'],
                'peran' => $row['peran'],
                'foto' => $row['foto_file'], 
                'spesialisasi' => $spesialisasi,
            ];
        }

        return $all_personnel;
    }

    // Fungsi untuk Halaman Detail (Detail Profil)
    public function getPersonilDetail($id) {
        // Ambil Data Diri
        $sql = "
            SELECT 
                p.*, 
                pj.jabatan_dosen AS peran
            FROM personil p
            JOIN personil_jabatan pj ON p.id_jabatan = pj.id_jabatan
            WHERE p.id_personil = :id
        ";
        
        $stmt = $this->pdo->prepare($sql);
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
        $stmt_specs = $this->pdo->prepare($sql_specs);
        $stmt_specs->execute([':id' => $id]);
        $personnel['spesialisasi'] = $stmt_specs->fetchAll(PDO::FETCH_COLUMN);

        // Ambil Publikasi
        $sql_pub = "SELECT * FROM publikasi WHERE id_personil = :id ORDER BY tahun DESC";
        $stmt_pub = $this->pdo->prepare($sql_pub);
        $stmt_pub->execute([':id' => $id]);
        $personnel['publikasi'] = $stmt_pub->fetchAll(PDO::FETCH_ASSOC);

        return $personnel;
    }
}
?>