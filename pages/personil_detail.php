<?php
// Tentukan path relatif ke root proyek (asumsi file ini ada di /pages/)
define('ROOT_PATH', __DIR__ . '/..');

// 1. Panggil file konfigurasi dan header/struktur HTML dasar
require_once ROOT_PATH . '/includes/config.php';
require_once ROOT_PATH . '/includes/navbar.php';

// 2. Data Anggota/Dosen
// **CATATAN: Data ini idealnya diambil dari database, tapi kita pakai array untuk contoh.**
$all_personnel = [
    'dosen1' => [
        'nama' => 'Dr. Rahmat Hidayat, M.Kom.',
        'peran' => 'Dosen Penanggung Jawab Lab SE',
        'nip' => '198001012005011002',
        'email' => 'rahmat.hidayat@universitas.ac.id',
        'foto' => BASE_URL . 'assets/img/dosen1_profile.jpg', // Ganti dengan path foto sebenarnya
        'spesialisasi' => ['Software Testing', 'Quality Assurance', 'Project Management'],
        'bio' => 'Dr. Rahmat adalah pakar dalam bidang penjaminan kualitas perangkat lunak. Beliau memegang kendali atas semua penelitian dan kegiatan praktikum di Lab SE.',
    ],
    // ... Tambahkan data untuk dosen2, dosen3, dosen4, dll. di sini
    'dosen2' => [
        'nama' => 'Irfan Maulana, S.Kom., M.TI.',
        'peran' => 'Asisten Koordinator Lab',
        'nip' => '199010052018022003',
        'email' => 'irfan.maulana@universitas.ac.id',
        'foto' => BASE_URL . 'assets/img/dosen2_profile.jpg',
        'spesialisasi' => ['Web Development', 'DevOps', 'Cloud Computing'],
        'bio' => 'Beliau aktif dalam pengembangan infrastruktur teknologi lab dan membimbing proyek mahasiswa dalam implementasi CI/CD.',
    ],
    'dosen3' => [
        'nama' => 'Maya Sari, MT.',
        'peran' => 'Dosen Pembimbing Riset',
        'nip' => '198505152010012004',
        'email' => 'maya.sari@universitas.ac.id',
        'foto' => BASE_URL . 'assets/img/dosen3_profile.jpg',
        'spesialisasi' => ['Requirements Engineering', 'UML', 'Software Architecture'],
        'bio' => 'Beliau aktif dalam pengembangan infrastruktur teknologi lab dan membimbing proyek mahasiswa dalam implementasi CI/CD.',
    ],
    'dosen4' => [
        'nama' => 'Bambang Sudarsono, M.Sc.',
        'peran' => 'Pengajar Praktikum',
        'nip' => '197812302006041001',
        'email' => 'bambang.sudarsono@universitas.ac.id',
        'foto' => BASE_URL . 'assets/img/dosen4_profile.jpg',
        'spesialisasi' => ['Database', 'Software Architecture', 'Project Management'],
        'bio' => 'Beliau aktif dalam pengembangan infrastruktur teknologi lab dan membimbing proyek mahasiswa dalam implementasi CI/CD.',
    ],
    'dosen5' => [
        'nama' => 'Rifqi Nurhakim, M.Sc.',
        'peran' => 'Pengajar Praktikum',
        'nip' => '198807202012021005',
        'email' => 'rifqi.nurhakim@universitas.ac.id',
        'foto' => BASE_URL . 'assets/img/dosen5_profile.jpg',
        'spesialisasi' => ['Database', 'Software Architecture', 'Project Management'],
        'bio' => 'Beliau aktif dalam pengembangan infrastruktur teknologi lab dan membimbing proyek mahasiswa dalam implementasi CI/CD.',
    ],
    'dosen6' => [
        'nama' => 'bambang nur, M.Sc.',
        'peran' => 'Pengajar Praktikum',
        'nip' => '198807202012021005',
        'email' => 'bambang.nur@universitas.ac.id',
        'foto' => BASE_URL . 'assets/img/dosen6_profile.jpg',
        'spesialisasi' => ['Database', 'Software Architecture', 'Project Management'],
        'bio' => 'Beliau aktif dalam pengembangan infrastruktur teknologi lab dan membimbing proyek mahasiswa dalam implementasi CI/CD.',
    ],
];

// 3. Ambil ID dari URL (contoh: ?id=dosen1)
$personnel_id = $_GET['id'] ?? null;
$personnel = $all_personnel[$personnel_id] ?? null;

// Atur judul halaman
$page_title = $personnel ? "Profil Dosen | {$personnel['nama']}" : "Profil Dosen Tidak Ditemukan";
?>

<main class="container py-5">
    <?php if ($personnel): ?>
        <section id="personnel-detail" class="p-4 p-md-5 rounded shadow-lg bg-light">
            <div class="row">
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <img src="<?= $personnel['foto'] ?>" alt="Foto Profil <?= $personnel['nama'] ?>" 
                         class="img-fluid rounded-circle shadow-sm" style="width: 200px; height: 200px; object-fit: cover;">
                </div>
                
                <div class="col-md-8">
                    <h1 class="display-5 text-primary"><?= $personnel['nama'] ?></h1>
                    <p class="lead text-secondary"><?= $personnel['peran'] ?></p>
                    
                    <hr>
                    
                    <h3>Tentang</h3>
                    <p><?= $personnel['bio'] ?></p>
                    
                    <h3 class="mt-4">Detail Kontak & Spesialisasi</h3>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-person-badge me-2"></i> **NIP:** <?= $personnel['nip'] ?></li>
                        <li><i class="bi bi-envelope me-2"></i> **Email:** <a href="mailto:<?= $personnel['email'] ?>"><?= $personnel['email'] ?></a></li>
                    </ul>

                    <div class="mt-4">
                        <h4>Spesialisasi:</h4>
                        <?php foreach ($personnel['spesialisasi'] as $spec): ?>
                            <span class="badge bg-dark me-2 mb-2"><?= $spec ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

    <?php else: ?>
        <div class="alert alert-danger text-center" role="alert">
            <h2>Dosen Tidak Ditemukan</h2>
            <p>ID personil yang Anda cari tidak valid.</p>
            <a href="<?= BASE_URL ?>pages/profil.php" class="btn btn-primary mt-3">Kembali ke Daftar Personil</a>
        </div>
    <?php endif; ?>
</main>

<?php
require_once ROOT_PATH . '/includes/footer.php';
?>