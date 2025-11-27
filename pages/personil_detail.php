<?php
$root = $_SERVER['DOCUMENT_ROOT'] . "/Lab_SE_Website";

require_once $root . "/config/config.php";
require_once $root . "/models/personil.php";
require_once $root . "/controllers/PersonilController.php";

// 1. Inisialisasi Database & Controller
$db = new Database();
$conn = $db->getConnection();
$controller = new PersonilController($conn);

// 2. Ambil ID
$id = $_GET['id'] ?? null;

// 3. Panggil Fungsi Controller 'detail'
// Fungsi ini sudah mengembalikan array lengkap dengan URL gambar yang benar
$data = $controller->detail($id);

$personnel = $data['personnel'];
$error_message = $data['error'];

$page_title = "Detail Personil - Lab SE";

require_once $root . '/includes/header.php';
require_once $root . '/includes/navbar.php';
?>

<main class="container py-5">

    <?php if ($error_message): ?>
        <div class='alert alert-danger text-center'>
            <strong>Gagal Memuat Detail Profil:</strong> <?= $error_message ?>
            <br>
            <a href="<?= BASE_URL ?>pages/personil.php" class="btn btn-sm btn-outline-danger mt-2">Kembali ke Daftar</a>
        </div>
    <?php endif; ?>

    <?php if ($personnel): ?>

        <section id="personnel-detail" class="p-4 p-md-5 rounded shadow-lg bg-light">
            <div class="row">

                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <img src="<?= $personnel['foto'] ?>" 
                         alt="<?= htmlspecialchars($personnel['nama']) ?>" 
                        class="img-fluid rounded shadow-sm w-100"
                        style="aspect-ratio: 1 / 1; object-fit: cover; object-position: top;">
                </div>

                <div class="col-md-8">
                    <h1 class="display-5 text-primary">
                        <strong class="fw-bold"><?= htmlspecialchars($personnel['nama']) ?></strong>
                    </h1>

                    <p class="lead text-secondary"><?= htmlspecialchars($personnel['peran']) ?></p>

                    <hr>

                    <h3 class="mt-4 h5 text-dark">Detail Kontak & Spesialisasi</h3>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-2"><i class="bi bi-person-badge me-2 text-primary"></i> NIP: <?= htmlspecialchars($personnel['nip']) ?></li>

                        <li class="mb-2">
                            <i class="bi bi-envelope me-2 text-primary"></i> Email:
                            <a href="mailto:<?= htmlspecialchars($personnel['email']) ?>" class="text-decoration-none"><?= htmlspecialchars($personnel['email']) ?></a>
                        </li>

                        <li class="mb-2">
                            <i class="bi bi-mortarboard me-2 text-primary"></i> Scholar:
                            <?php if($personnel['google_scholar_url']): ?>
                                <a href="<?= $personnel['google_scholar_url'] ?>" target="_blank" class="text-decoration-none">Google Scholar Profile</a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </li>

                        <li class="mb-2">
                            <i class="bi bi-linkedin me-2 text-primary"></i> LinkedIn:
                            <?php if($personnel['linkedin_url']): ?>
                                <a href="<?= $personnel['linkedin_url'] ?>" target="_blank" class="text-decoration-none">LinkedIn Profile</a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </li>
                    </ul>

                    <div class="mt-4">
                        <h4 class="h6">Spesialisasi:</h4>
                        <?php if (!empty($personnel['spesialisasi'])): ?>
                            <?php foreach ($personnel['spesialisasi'] as $spec): ?>
                                <span class="badge bg-primary me-1 mb-2"><?= htmlspecialchars($spec) ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="text-muted small">Tidak ada spesialisasi tercatat.</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <hr class="mt-5">

            <div class="mt-4">
                <ul class="nav nav-tabs" id="academicTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="publikasi-tab" data-bs-toggle="tab" data-bs-target="#publikasi-pane" type="button">
                            Publikasi (<?= count($personnel['publikasi']) ?>)
                        </button>
                    </li>
                    <li class="nav-item"><button class="nav-link" data-bs-target="#riset-pane" data-bs-toggle="tab">Riset</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-target="#ki-pane" data-bs-toggle="tab">Kekayaan Intelektual</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-target="#ppm-pane" data-bs-toggle="tab">PPM</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-target="#aktivitas-pane" data-bs-toggle="tab">Aktivitas</button></li>
                </ul>

                <div class="tab-content pt-4 bg-white border border-top-0 p-3 rounded-bottom">

                    <div class="tab-pane fade show active" id="publikasi-pane">
                        <?php if (!empty($personnel['publikasi'])): ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:50px;" class="text-center">No</th>
                                            <th>Judul Publikasi</th>
                                            <th style="width:100px;" class="text-center">Tahun</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($personnel['publikasi'] as $pub): ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($pub['judul']) ?></td>
                                            <td class="text-center"><?= htmlspecialchars($pub['tahun']) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-center text-muted py-3">Belum ada data publikasi.</p>
                        <?php endif; ?>
                    </div>

                    <div class="tab-pane fade" id="riset-pane"><p class="text-center text-muted py-3">Belum ada data riset.</p></div>
                    <div class="tab-pane fade" id="ki-pane"><p class="text-center text-muted py-3">Belum ada data KI.</p></div>
                    <div class="tab-pane fade" id="ppm-pane"><p class="text-center text-muted py-3">Belum ada data PPM.</p></div>
                    <div class="tab-pane fade" id="aktivitas-pane"><p class="text-center text-muted py-3">Belum ada aktivitas.</p></div>

                </div>
            </div>

        </section>

    <?php endif; ?>

</main>

<?php require_once $root . '/includes/footer.php'; ?>