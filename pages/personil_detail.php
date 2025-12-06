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

            <?php
            $list_publikasi = [];
            $list_riset     = [];
            $list_ppm       = [];
            $list_ki        = [];
            $list_buku      = [];

            if (!empty($personnel['publikasi'])) {
                foreach ($personnel['publikasi'] as $item) {

                    // Ubah nama jenis ke huruf kecil agar pencarian mudah
                    $jenis = strtolower($item['nama_jenis'] ?? '');

                    // A. Cek PPM (Gunakan huruf kecil 'ppm')
                    if (strpos($jenis, 'pengabdian') !== false || strpos($jenis, 'ppm') !== false) {
                        $list_ppm[] = $item;
                    }
                    // B. Cek HKI (Gunakan huruf kecil)
                    elseif (strpos($jenis, 'hki') !== false || strpos($jenis, 'hak cipta') !== false || strpos($jenis, 'paten') !== false || strpos($jenis, 'kekayaan') !== false) {
                        $list_ki[] = $item;
                    }
                    // C. Cek Riset (Gunakan huruf kecil 'riset')
                    elseif (strpos($jenis, 'riset') !== false || strpos($jenis, 'penelitian') !== false) {
                        $list_riset[] = $item;
                    } elseif (strpos($jenis, 'buku') !== false || strpos($jenis, 'ajar') !== false || strpos($jenis, 'modul') !== false) {
                        $list_buku[] = $item;
                    } else {
                        $list_publikasi[] = $item;
                    }
                }
            }
            ?>

            <div class="row">
                <div class="col-12">

                    <ul class="nav nav-pills gap-4 mb-4 align-items-center custom-nav" id="profileTabs" role="tablist">

                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-tab active"
                                id="pills-publikasi-tab" data-bs-toggle="pill" data-bs-target="#pills-publikasi" type="button">
                                Publikasi (<?= count($list_publikasi) ?>)
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-tab" id="pills-riset-tab" data-bs-toggle="pill" data-bs-target="#pills-riset" type="button">
                                Riset (<?= count($list_riset) ?>)
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-tab" id="pills-ki-tab" data-bs-toggle="pill" data-bs-target="#pills-ki" type="button">
                                Kekayaan Intelektual (<?= count($list_ki) ?>)
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-tab" id="pills-ppm-tab" data-bs-toggle="pill" data-bs-target="#pills-ppm" type="button">
                                PPM (<?= count($list_ppm) ?>)
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-tab" id="pills-buku-tab" data-bs-toggle="pill" data-bs-target="#pills-buku" type="button">
                                Buku (<?= count($list_buku) ?>)
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">

                        <div class="tab-pane fade show active" id="pills-publikasi">
                            <div class="card border-0">
                                <div class="card-body p-0">
                                    <?php if (!empty($list_publikasi)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px; font-weight: 700;">No</th>
                                                        <th style="font-weight: 700;">Judul Publikasi</th>
                                                        <th class="text-end" style="font-weight: 700; width: 100px;">Tahun</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($list_publikasi as $pub): ?>
                                                        <tr>
                                                            <td class="text-muted"><?= $no++ ?></td>
                                                            <td class="fw-normal text-dark">
                                                                <?= htmlspecialchars($pub['judul']) ?>
                                                            </td>
                                                            <td class="text-end text-muted"><?= htmlspecialchars($pub['tahun']) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="py-5 text-center text-muted">Belum ada data publikasi.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-riset">
                            <div class="card border-0">
                                <div class="card-body p-0">
                                    <?php if (!empty($list_riset)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px; font-weight: 700;">No</th>
                                                        <th style="font-weight: 700;">Judul Riset / Penelitian</th>
                                                        <th class="text-end" style="font-weight: 700; width: 100px;">Tahun</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($list_riset as $riset): ?>
                                                        <tr>
                                                            <td class="text-muted"><?= $no++ ?></td>
                                                            <td class="fw-normal text-dark">
                                                                <?= htmlspecialchars($riset['judul']) ?>
                                                            </td>
                                                            <td class="text-end text-muted"><?= htmlspecialchars($riset['tahun']) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="py-5 text-center text-muted">Belum ada data riset.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-ki">
                            <div class="card border-0">
                                <div class="card-body p-0">
                                    <?php if (!empty($list_ki)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px; font-weight: 700;">No</th>
                                                        <th style="font-weight: 700;">Judul HKI / Paten</th>
                                                        <th class="text-end" style="font-weight: 700; width: 100px;">Tahun</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($list_ki as $ki): ?>
                                                        <tr>
                                                            <td class="text-muted"><?= $no++ ?></td>
                                                            <td class="fw-normal text-dark">
                                                                <?= htmlspecialchars($ki['judul']) ?>
                                                            </td>
                                                            <td class="text-end text-muted"><?= htmlspecialchars($ki['tahun']) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="py-5 text-center text-muted">Belum ada data HKI.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-ppm">
                            <div class="card border-0">
                                <div class="card-body p-0">
                                    <?php if (!empty($list_ppm)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px; font-weight: 700;">No</th>
                                                        <th style="font-weight: 700;">Judul Pengabdian</th>
                                                        <th class="text-end" style="font-weight: 700; width: 100px;">Tahun</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($list_ppm as $ppm): ?>
                                                        <tr>
                                                            <td class="text-muted"><?= $no++ ?></td>
                                                            <td class="fw-normal text-dark">
                                                                <?= htmlspecialchars($ppm['judul']) ?>
                                                            </td>
                                                            <td class="text-end text-muted"><?= htmlspecialchars($ppm['tahun']) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="py-5 text-center text-muted">Belum ada data PPM.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-buku">
                            <div class="card border-0">
                                <div class="card-body p-0">
                                    <?php if (!empty($list_buku)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px; font-weight: 700;">No</th>
                                                        <th style="font-weight: 700;">Judul Buku</th>
                                                        <th class="text-end" style="font-weight: 700; width: 100px;">Tahun</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($list_buku as $buku): ?>
                                                        <tr>
                                                            <td class="text-muted"><?= $no++ ?></td>
                                                            <td class="fw-normal text-dark">
                                                                <?= htmlspecialchars($buku['judul']) ?>
                                                                <br><small class="text-muted badge bg-light text-secondary border"><?= htmlspecialchars($buku['nama_jenis']) ?></small>
                                                            </td>
                                                            <td class="text-end text-muted"><?= htmlspecialchars($buku['tahun']) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="py-5 text-center text-muted">Belum ada data Buku Ajar/Modul.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <?php endif; ?>

</main>

<style>
    /* Sedikit CSS Tambahan agar tombol lebih cantik */
    .transition-hover {
        transition: all 0.2s ease-in-out;
    }

    .transition-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>

<?php require_once $root . '/includes/footer.php'; ?>