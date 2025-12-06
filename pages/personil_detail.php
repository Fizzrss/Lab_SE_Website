<?php
$root = $_SERVER['DOCUMENT_ROOT'] . "/Lab_SE_Website";

require_once $root . "/config/config.php";
require_once $root . "/models/Personil.php";
require_once $root . "/controllers/PersonilController.php";

$db = new Database();
$conn = $db->getConnection();

$personilModel = new PersonilModel($conn); 
$controller = new PersonilController($personilModel); 

$id = $_GET['id'] ?? null;
if (!isset($personnel)) {
    $data = $controller->getDetailData($id);
    $personnel = $data['personnel'];
    $error_message = $data['error'];
}

$page_title = "Detail Personil - Lab SE";
require_once $root . '/includes/header.php';
require_once $root . '/includes/navbar.php';
?>

<main class="container py-5">

    <?php if (isset($error_message) && $error_message): ?>
        <div class='alert alert-danger text-center shadow-sm'>
            <strong><i class="bi bi-exclamation-triangle"></i> Gagal Memuat Profil:</strong> <?= $error_message ?>
            <br>
            <a href="<?= BASE_URL ?>personil.php" class="btn btn-sm btn-outline-danger mt-3">Kembali ke Daftar</a>
        </div>
    <?php endif; ?>

    <?php if (isset($personnel) && $personnel): ?>

        <section id="personnel-detail" class="p-4 p-md-5 rounded-4 shadow-lg bg-white">
            <div class="row align-items-center">

                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <img src="<?= $personnel['foto'] ?>" 
                         alt="<?= htmlspecialchars($personnel['nama']) ?>" 
                        class="img-fluid rounded shadow-sm w-100"
                        style="aspect-ratio: 1 / 1; object-fit: cover; object-position: top;">
                </div>

                <div class="col-md-8">
                    <h1 class="display-5 text-dark fw-bold mb-1">
                        <?= htmlspecialchars($personnel['nama']) ?>
                    </h1>
                    <p class="lead text-primary fw-semibold mb-3"><?= htmlspecialchars($personnel['peran']) ?></p>

                    <div class="d-flex align-items-center gap-3 mb-4 text-secondary">
                        <span title="NIP"><i class="bi bi-person-badge me-1"></i> <?= htmlspecialchars($personnel['nip']) ?></span>
                        <span class="vr"></span>
                        <a href="mailto:<?= htmlspecialchars($personnel['email']) ?>" class="text-decoration-none text-secondary" title="Email">
                            <i class="bi bi-envelope me-1"></i> <?= htmlspecialchars($personnel['email']) ?>
                        </a>
                    </div>

                    <hr class="my-4 opacity-10">

                    <h5 class="fw-bold mb-3 text-dark">Tautan & Profil</h5>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <?php if (!empty($personnel['sosmed'])): ?>
                            <?php foreach ($personnel['sosmed'] as $sm): ?>
                                <a href="<?= htmlspecialchars($sm['link_sosmed']) ?>" 
                                   target="_blank" 
                                   class="btn btn-outline-dark rounded-pill px-3 d-flex align-items-center gap-2 transition-hover">
                                    <i class="<?= htmlspecialchars($sm['icon']) ?> fs-5"></i>
                                    <span><?= htmlspecialchars($sm['nama_sosmed']) ?></span>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted small fst-italic">Belum ada tautan profil yang ditambahkan.</p>
                        <?php endif; ?>
                    </div>

                    <h5 class="fw-bold mb-3 text-dark">Bidang Keahlian</h5>
                    <div>
                        <?php if (!empty($personnel['spesialisasi'])): ?>
                            <?php foreach ($personnel['spesialisasi'] as $spec): ?>
                                <span class="badge bg-light text-dark border me-1 mb-2 px-3 py-2 rounded-pill fw-normal">
                                    <?= htmlspecialchars($spec) ?>
                                </span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="text-muted small fst-italic">Tidak ada spesialisasi tercatat.</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <hr class="my-5">

            <div class="mt-4">
                <ul class="nav nav-pills mb-4" id="academicTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill px-4" id="publikasi-tab" data-bs-toggle="tab" data-bs-target="#publikasi-pane" type="button">
                            Publikasi (<?= count($personnel['publikasi']) ?>)
                        </button>
                    </li>
                    <li class="nav-item"><button class="nav-link rounded-pill px-4" data-bs-target="#riset-pane" data-bs-toggle="tab">Riset</button></li>
                    <li class="nav-item"><button class="nav-link rounded-pill px-4" data-bs-target="#ki-pane" data-bs-toggle="tab">Kekayaan Intelektual</button></li>
                    <li class="nav-item"><button class="nav-link rounded-pill px-4" data-bs-target="#ppm-pane" data-bs-toggle="tab">PPM</button></li>
                    <li class="nav-item"><button class="nav-link rounded-pill px-4" data-bs-target="#aktivitas-pane" data-bs-toggle="tab">Aktivitas</button></li>
                </ul>

                <div class="tab-content">
                    
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
                                            <td class="text-center text-muted"><?= $no++ ?></td>
                                            <td class="fw-semibold text-dark"><?= htmlspecialchars($pub['judul']) ?></td>
                                            <td class="text-center text-muted"><?= htmlspecialchars($pub['tahun']) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5 bg-light rounded-3">
                                <i class="bi bi-journal-x fs-1 text-muted opacity-50 mb-2"></i>
                                <p class="text-muted">Belum ada data publikasi.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="tab-pane fade" id="riset-pane"><p class="text-center text-muted py-5 bg-light rounded-3">Belum ada data riset.</p></div>
                    <div class="tab-pane fade" id="ki-pane"><p class="text-center text-muted py-5 bg-light rounded-3">Belum ada data KI.</p></div>
                    <div class="tab-pane fade" id="ppm-pane"><p class="text-center text-muted py-5 bg-light rounded-3">Belum ada data PPM.</p></div>
                    <div class="tab-pane fade" id="aktivitas-pane"><p class="text-center text-muted py-5 bg-light rounded-3">Belum ada aktivitas.</p></div>

                </div>
            </div>

        </section>

    <?php endif; ?>

</main>

<?php require_once $root . '/includes/footer.php'; ?>