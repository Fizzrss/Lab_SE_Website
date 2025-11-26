<?php
// Tentukan path relatif ke root proyek
// PERBAIKAN: Menggunakan dirname(__DIR__) untuk memastikan path absolut yang aman.
define('ROOT_PATH', dirname(__DIR__));

// 1. Panggil file konfigurasi (HARUS ADA KONEKSI $pdo) dan header/struktur HTML dasar
// PERBAIKAN: Menghapus '../' yang berlebihan.
require_once ROOT_PATH . '/config/config.php'; 
require_once ROOT_PATH . '/includes/header.php'; 
require_once ROOT_PATH . '/includes/navbar.php';


// 2. Logika Pengambilan Data dari Database
// =======================================================
// QUERY: Ambil semua dosen aktif beserta jabatannya dan spesialisasi utama
// =======================================================

$all_personnel = [];
// Tambahkan pemeriksaan koneksi $pdo untuk mencegah Fatal Error (jika config gagal)
if (isset($pdo) && $pdo !== null) {
    try {
        // Query untuk mengambil data dasar personil dan jabatan
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

        $stmt = $pdo->query($sql_personnel);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Proses hasil untuk mengambil spesialisasi satu per satu
        foreach ($results as $row) {
            
            // --- Query Tambahan: Ambil Spesialisasi Pertama Saja ---
            $sql_spec_single = "
                SELECT s.nama_spesialisasi 
                FROM personil_spesialisasi ps
                JOIN spesialisasi s ON ps.id_spesialisasi = s.id_spesialisasi
                WHERE ps.id_personil = :id
                LIMIT 1
            ";
            $stmt_spec = $pdo->prepare($sql_spec_single);
            $stmt_spec->execute([':id' => $row['id_personil']]);
            $spesialisasi = $stmt_spec->fetchColumn() ?: 'Belum Ada Spesialisasi';

            // Format data untuk digunakan di HTML
            $member_data = [
                'id' => $row['id_personil'], // Gunakan ID numerik sebagai ID URL
                // Kita hilangkan tag <b> yang statis, biarkan di CSS atau HTML
                'nama' => $row['nama'],
                'peran' => $row['peran'],
                // Menggabungkan BASE_URL dengan nama file foto
                'foto' => BASE_URL . 'assets/img/' . $row['foto_file'], 
                'spesialisasi' => $spesialisasi,
            ];

            // Tambahkan ke array utama
            $all_personnel[] = $member_data;
        }

    } catch (PDOException $e) {
        // Tampilkan pesan error jika query gagal
        echo "<div class='container mt-5'><div class='alert alert-danger'>Kesalahan Query: " . $e->getMessage() . "</div></div>";
    }
} else {
    // Tampilkan pesan jika koneksi gagal (variabel $pdo tidak ada)
    echo "<div class='container mt-5'><div class='alert alert-danger'>Koneksi Database Gagal. Cek config/config.php.</div></div>";
}


// Atur judul halaman
$page_title = "Daftar Personil Dosen LAB SE";

?>

<header class="header text-center py-5 text-white">
    <div class="container">
        <h1><b> Dosen dan Staf Lab SE</b></h1>
        <p>Tim pengajar dan peneliti yang membimbing kegiatan laboratorium.</p>
    </div>
</header>

<main class="container py-5">
    <section class="team-grid">
        
        <?php foreach ($all_personnel as $member): ?>
        
        <div class="profile-card">
            <!-- PENGGUNAAN VARIABEL FOTO DI TAG IMG -->
            <img src="<?= $member['foto'] ?>" alt="Foto Profil <?= $member['nama'] ?>">
            
            <h4><?= $member['nama'] ?></h4>
            <p class="text-secondary"><?= $member['peran'] ?></p>
            
            <p class="small text-muted mb-3"><?= $member['spesialisasi'] ?></p>
            
            <a href="<?= BASE_URL ?>pages/personil_detail.php?id=<?= $member['id'] ?>" class="btn btn-sm btn-outline-primary">
                Lihat Detail Profil
            </a>
        </div>
        
        <?php endforeach; ?>
        
    </section>
    
</main>

<?php
// Include footer
require_once ROOT_PATH . '/includes/footer.php';
?>

<style>
/* CSS Tambahan untuk Tampilan Grid Kartu (Agar tampilan responsif) */
.header {
    background-color: #6096B4;
}
.header h1 {
    color: #ffffff;
}
.header p {
    color: #ffffff;
}

.team-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px; /* Jarak antar kartu */
    padding: 20px 0;
}
.profile-card {
    background-color: white;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    
    /* Menentukan lebar maksimum untuk 3 kolom, mengurangi gap (30px * 2) / 3 */
    width: calc(33.333% - 20px); 
    min-width: 250px; /* Agar tetap terbaca di layar kecil */
    
    text-align: center;
    padding: 20px;
    transition: transform 0.5s;
}

/* ... CSS lainnya (hover, img) tetap sama ... */
.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}
.profile-card img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover; 
    margin-bottom: 15px;
    /* Ubah warna border agar konsisten dengan tema header */
    border: 3px solid #6096B4; 
}

/* OPSIONAL: Pengaturan Responsif untuk Mobile */
@media (max-width: 768px) {
    .profile-card {
        width: 100%; /* Di layar kecil, tampilkan 1 kartu per baris */
    }
}
</style>