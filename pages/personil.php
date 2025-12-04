<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';

require_once $root . '/config/config.php';
require_once $root . '/models/personil.php';

$database = new Database();
$db = $database->getConnection();

$personilModel = new PersonilModel($db);
$all_personnel = $personilModel->getAllPersonil();

$page_title = "Daftar Personil - Lab SE";
require_once $root . '/includes/header.php';
require_once $root . '/includes/navbar.php';
?>

<header class="header text-center py-5 text-white" style="background-color: #6096B4;">
    <div class="container">
        <h1>Dosen dan Staf Lab SE</h1>
        <p class="lead">Tim pengajar dan peneliti yang membimbing kegiatan laboratorium.</p>
    </div>
</header>


<main class="container py-3">

    <?php if (empty($all_personnel)): ?>
        <div class="text-center text-muted">
            <p>Belum ada data personil yang tersedia.</p>
        </div>

    <?php else: ?>

        <section class="team-grid">
            <?php foreach ($all_personnel as $index => $member): ?>

            
                <div class="profile-card">

                    <!-- Foto -->
                    <div class="img-wrapper">
                        <img src="<?= BASE_URL ?>assets/img/personil/<?= $member['foto'] ?>"
                             alt="<?= htmlspecialchars($member['nama']) ?>"
                             class="img-fluid"
                             onerror="this.src='<?= BASE_URL ?>assets/img/default.png'">
                    </div>

                    <!-- Nama & Peran -->
                    <h5 class="fw-bold mt-3"><?= htmlspecialchars($member['nama']) ?></h5>
                    <p class="text-primary fw-semibold mb-1"><?= htmlspecialchars($member['peran']) ?></p>

                    <!-- Spesialisasi -->
                    <p class="small text-muted mb-3">
                        <i class="bi bi-code-slash"></i>
                        <?= htmlspecialchars($member['spesialisasi']) ?>
                    </p>

                    <!-- Tombol Profil -->
                    <a href="<?= BASE_URL ?>pages/personil_detail.php?id=<?= $member['id'] ?>"
                       class="btn btn-sm btn-outline-info rounded-pill px-4">
                        Lihat Profil
                    </a>

                </div>

            <?php endforeach; ?>
        </section>

    <?php endif; ?>

</main>

<?php require_once $root . '/includes/footer.php'; ?>
