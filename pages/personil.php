<?php
// Tentukan path relatif ke root proyek
define('ROOT_PATH', __DIR__ . '/..');

// 1. Panggil file konfigurasi dan header/struktur HTML dasar
require_once ROOT_PATH . '/includes/config.php';
// CATATAN PENTING: Untuk file konten seperti ini, Anda perlu meng-include HEADER.php 
// untuk tag <head> dan CSS, bukan hanya navbar.
// Asumsi navbar.php sudah meng-include header.php, atau Anda perlu mengganti navbar.php dengan header.php
require_once ROOT_PATH . '/includes/header.php'; 
// Jika navbar dipisahkan, include juga:
require_once ROOT_PATH . '/includes/navbar.php';


// 2. Data Anggota/Dosen
// Pastikan file gambar ini (dosenX_profile.jpg) ada di folder:
// [root_proyek]/assets/img/
$all_personnel = [
    'dosen1' => [
        'id' => 'dosen1',
        'nama' => 'Dr. Rahmat Hidayat, M.Kom.',
        'peran' => 'Dosen Penanggung Jawab Lab SE',
        // PENGATURAN PATH GAMBAR:
        // BASE_URL adalah alamat dasar, disambung dengan folder assets/img/ dan nama file.
        'foto' => BASE_URL . 'assets/img/dosen1_profile.jpg', 
        'spesialisasi' => 'Software Testing & QA',
    ],
    'dosen2' => [
        'id' => 'dosen2',
        'nama' => 'Irfan Maulana, S.Kom., M.TI.',
        'peran' => 'Asisten Koordinator Lab',
        'foto' => BASE_URL . 'assets/img/dosen2_profile.jpg',
        'spesialisasi' => 'DevOps & Web Development',
    ],
    'dosen3' => [
        'id' => 'dosen3',
        'nama' => 'Maya Sari, MT.',
        'peran' => 'Dosen Pembimbing Riset',
        'foto' => BASE_URL . 'assets/img/dosen3_profile.jpg',
        'spesialisasi' => 'Requirements Engineering & UML',
    ],
    'dosen4' => [
        'id' => 'dosen4',
        'nama' => 'Bambang Sudarsono, M.Sc.',
        'peran' => 'Pengajar Praktikum',
        'foto' => BASE_URL . 'assets/img/dosen4_profile.jpg',
        'spesialisasi' => 'Database & Software Architecture',
    ],

    'dosen5' => [
        'id' => 'dosen5',
        'nama' => 'Rifqi Nurhakim, M.Sc.',
        'peran' => 'Pengajar Praktikum',
        'foto' => BASE_URL . 'assets/img/dosen5_profile.jpg',
        'spesialisasi' => 'Database & Software Architecture',
    ],
    'dosen6' => [
        'id' => 'dosen6',
        'nama' => 'bambang nur, M.Sc.',
        'peran' => 'Pengajar Praktikum',
        'foto' => BASE_URL . 'assets/img/dosen6_profile.jpg',
        'spesialisasi' => 'Database & Software Architecture',
    ],
];

// Atur judul halaman
$page_title = "Daftar Personil Dosen LAB SE";

?>

<header class="header text-center py-5 text-white">
    <div class="container">
        <h1>Personil Dosen & Staf Lab SE</h1>
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
    
    /* PERUBAHAN UTAMA DI SINI */
    /* Menentukan lebar maksimum untuk 3 kolom, mengurangi gap (30px * 2) / 3 */
    width: calc(33.333% - 20px); 
    min-width: 250px; /* Agar tetap terbaca di layar kecil */
    
    text-align: center;
    padding: 20px;
    transition: transform 0.3s;
}

/* ... CSS lainnya (hover, img) tetap sama ... */
.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}
.profile-card img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover; 
    margin-bottom: 15px;
    border: 3px solid #007bff; 
}

/* OPSIONAL: Pengaturan Responsif untuk Mobile */
@media (max-width: 768px) {
    .profile-card {
        width: 100%; /* Di layar kecil, tampilkan 1 kartu per baris */
    }
}
</style>