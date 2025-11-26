<?php
// 1. SETUP PATH & CONFIG
$root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';

require_once $root . '/config/config.php';
require_once $root . '/models/personil.php'; // <--- Panggil Modelnya

// 2. KONEKSI & AMBIL DATA
$database = new Database();
$db = $database->getConnection();

$personilModel = new PersonilModel($db); // Inisialisasi Model
$all_personnel = $personilModel->getAllPersonil(); // Ambil datanya (Simple kan?)

// 3. JUDUL & HEADER
$page_title = "Daftar Personil - Lab SE";
require_once $root . '/includes/header.php';
require_once $root . '/includes/navbar.php';
?>

<header class="header text-center py-5 text-white" style="background-color: #6096B4;">
    <div class="container">
        <h1><b>Dosen dan Staf Lab SE</b></h1>
        <p class="lead">Tim pengajar dan peneliti yang membimbing kegiatan laboratorium.</p>
    </div>
</header>

<main class="container py-5">
    
    <?php if(empty($all_personnel)): ?>
        <div class="text-center text-muted">
            <p>Belum ada data personil yang tersedia.</p>
        </div>
    <?php else: ?>

    <section class="team-grid">
        <?php foreach ($all_personnel as $member): ?>
        <div class="profile-card">
            <div class="img-wrapper">
                <img src="<?= $member['foto'] ?>" alt="<?= $member['nama'] ?>" onerror="this.src='<?= BASE_URL ?>assets/img/default.png'">
            </div>
            
            <h5 class="fw-bold mt-3"><?= $member['nama'] ?></h5>
            <p class="text-primary fw-semibold mb-1"><?= $member['peran'] ?></p>
            <p class="small text-muted mb-3"><i class="bi bi-code-slash"></i> <?= $member['spesialisasi'] ?></p>
            
            <a href="<?= BASE_URL ?>pages/personil_detail.php?id=<?= $member['id'] ?>" class="btn btn-sm btn-outline-info rounded-pill px-4">
                Lihat Profil
            </a>
        </div>
        <?php endforeach; ?>
    </section>

    <?php endif; ?>

</main>

<style>
/* CSS Grid Responsif */
.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    padding: 20px 0;
}

.profile-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    padding: 30px 20px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #f0f0f0;
}

.profile-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.img-wrapper img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #e3f2fd;
    margin-bottom: 10px;
}
</style>

<?php
// 5. PANGGIL FOOTER
require_once $root . '/includes/footer.php';
?>