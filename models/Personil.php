<?php

/**
 * Kelas Model untuk mengelola data Personil (Dosen) dari database.
 * Semua logika query SQL diletakkan di sini.
 */
class PersonilModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Mengambil daftar semua personil beserta jabatan dan spesialisasi utama.
     * Digunakan untuk halaman daftar profil (profil.php).
     * @return array Daftar personil yang sudah diproses.
     */
    public function getAllPersonil() {
        // Query utama untuk data personil dan jabatan
        $sql_personnel = "
            SELECT 
                p.id_personil, 
                p.nama_personil AS nama, 
                pj.jabatan_dosen AS peran,
                p.foto_personil AS foto_file
            FROM personil p
            JOIN personil_jabatan pj ON p.id_jabtan = pj.id_jabatan
            ORDER BY p.id_personil ASC
        ";

        $stmt = $this->pdo->query($sql_personnel);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $all_personnel = [];

        // Loop untuk menambahkan spesialisasi utama
        foreach ($results as $row) {
            
            // Query untuk mengambil Spesialisasi Pertama Saja
            $sql_spec_single = "
                SELECT s.nama_spesialisasi 
                FROM personil_spesialisasi ps
                JOIN spesialisasi s ON ps.id_spesialisasi = s.id_spesialisasi
                WHERE ps.id_personil = :id
                LIMIT 1
            ";
            $stmt_spec = $this->pdo->prepare($sql_spec_single);
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

    /**
     * Mengambil data detail satu personil beserta spesialisasi dan publikasi.
     * Digunakan untuk halaman detail profil (personil_detail.php).
     * @param int $id ID personil yang dicari.
     * @return array|null Data personil lengkap atau null jika tidak ditemukan.
     */
    public function getPersonilDetail($id) {
        
        // --- 1. Ambil Data Dasar Dosen ---
        $sql_personnel = "
            SELECT 
                p.nip, p.nama_personil, p.email, p.linkedin, p.link_gscholar, p.foto_personil, 
                pj.jabatan_dosen AS peran
            FROM personil p
            JOIN personil_jabatan pj ON p.id_jabtan = pj.id_jabatan
            WHERE p.id_personil = :id
        ";
        
        $stmt_personnel = $this->pdo->prepare($sql_personnel);
        $stmt_personnel->execute([':id' => $id]);
        $personnel = $stmt_personnel->fetch(PDO::FETCH_ASSOC);

        if (!$personnel) {
            return null;
        }

        // --- 2. Ambil Spesialisasi ---
        $sql_specs = "
            SELECT s.nama_spesialisasi 
            FROM personil_spesialisasi ps
            JOIN spesialisasi s ON ps.id_spesialisasi = s.id_spesialisasi
            WHERE ps.id_personil = :id
        ";
        $stmt_specs = $this->pdo->prepare($sql_specs);
        $stmt_specs->execute([':id' => $id]);
        $personnel['spesialisasi'] = $stmt_specs->fetchAll(PDO::FETCH_COLUMN, 0); 

        // --- 3. Ambil Publikasi ---
        $sql_publikasi = "
            SELECT judul, tahun
            FROM publikasi
            WHERE id_personil = :id
            ORDER BY tahun DESC
        ";
        $stmt_publikasi = $this->pdo->prepare($sql_publikasi);
        $stmt_publikasi->execute([':id' => $id]);
        $personnel['publikasi'] = $stmt_publikasi->fetchAll(PDO::FETCH_ASSOC);
        
        return $personnel;
    }
}