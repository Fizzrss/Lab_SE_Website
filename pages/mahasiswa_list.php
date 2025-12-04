<?php
// Helper warna status
function getStatusColor($status) {
    $status = strtolower($status['status'] ?? 'aktif');
    if ($status == 'aktif') return 'success';
    if ($status == 'cuti') return 'warning';
    if ($status == 'alumni') return 'secondary';
    return 'primary';
}

$root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';

require_once $root . '/config/config.php';
require_once $root . '/models/MahasiswaAktifModel.php';

$database = new Database();
$db = $database->getConnection();

$mahasiswaAktifModel = new MahasiswaAktifModel($db);
$mahasiswa_list = $mahasiswaAktifModel->getAllPublic();

$page_title = "Daftar Personil - Lab SE";
require_once $root . '/includes/header.php';
require_once $root . '/includes/navbar.php';

?>

<!-- <section class="page-hero-banner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Daftar Mahasiswa Lab SE</h1>
                <p class="opacity-75">Data mahasiswa aktif, cuti, dan alumni.</p>
            </div>
        </div>
    </div>
</section> -->

<header class="header text-center py-5 text-white" style="background-color: #6096B4;">
    <div class="container">
        <h1>Daftar Mahasiswa Lab SE</h1>
        <p class="lead">Data Mahasiswa Anggota laboratorium SE.</p>
    </div>
</header>

<main class="main-content-container py-2">
    <div class="container">

        <!-- FILTER CARD -->
        <div class="filter-card" data-aos="fade-up">
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0 ps-0"
                               placeholder="Cari nama atau NIM...">
                    </div>
                </div>

                <div class="col-md-4">
                    <select id="prodiFilter" class="form-select">
                        <option value="all">Semua Program Studi</option>
                        <?php foreach ($prodi_list as $prodi_name): ?>
                            <option value="<?= htmlspecialchars($prodi_name) ?>">
                                <?= htmlspecialchars($prodi_name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2 text-end">
                    <span class="text-muted small">Total: <strong id="totalCount"><?= count($mahasiswa_list) ?></strong></span>
                </div>
            </div>
        </div>

        <!-- DAFTAR MAHASISWA -->
        <div id="studentList">
            <?php 
            $delay = 100;
            foreach ($mahasiswa_list as $mhs):
                $delay += 50;

                $nama  = $mhs['nama'];
                $nim   = $mhs['nim'];
                $prodi = $mhs['prodi'];
                $status = $mhs['status'];
                $foto = $mhs['foto'];
                $color = getStatusColor($status);
            ?>
                <div class="student-row"
                     data-aos="fade-up"
                     data-aos-delay="<?= $delay ?>"
                     data-name="<?= strtolower($nama) ?>"
                     data-nim="<?= $nim ?>"
                     data-prodi="<?= $prodi ?>">

                     <div class="student-avatar me-md-4 mb-3 mb-md-0">
                        <img src="<?= BASE_URL ?>upload/foto/<?= $foto ?>"
                             alt="<?= htmlspecialchars($nama) ?>"
                             onerror="this.src='<?= BASE_URL ?>assets/img/default.png'">
                    </div>

                    <div class="student-info flex-grow-1 text-md-start mb-2 mb-md-0">
                        <h5 class="student-name"><?= htmlspecialchars($nama) ?></h5>
                        <span class="student-nim"><i class="bi bi-card-heading me-1"></i><?= htmlspecialchars($nim) ?></span>
                    </div>

                    <div class="student-prodi col-md-3 text-md-start mb-2 mb-md-0">
                        <i class="bi bi-mortarboard me-1 text-primary"></i>
                        <?= htmlspecialchars($prodi) ?>
                    </div>

                    <div class="student-status col-md-2 text-md-center mb-2 mb-md-0">
                        <span class="badge bg-<?= $color ?> bg-opacity-10 text-<?= $color ?> status-badge border border-<?= $color ?>">
                            <?= htmlspecialchars($status) ?>
                        </span>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

        <div id="noResults" class="text-center py-5 d-none">
            <i class="bi bi-emoji-frown display-1 text-muted opacity-25"></i>
            <p class="text-muted mt-3">Data mahasiswa tidak ditemukan.</p>
        </div>

        <div class="row mt-5" data-aos="fade-up">
            <div class="col-12">
                <div class="card card-floating bg-light p-4 text-center border-0 shadow-sm">
                    <div class="card-body">
                        <h4 class="fw-bold mb-3">Tertarik Bergabung?</h4>
                        <p class="text-muted mb-4">Jadilah bagian dari inovasi teknologi bersama kami.</p>
                        <a href="<?= BASE_URL ?>pages/recruitment_form.php"
                           class="btn btn-custom-accent px-5 py-2 rounded-pill shadow">
                           Daftar Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const prodiFilter = document.getElementById('prodiFilter');
    const studentRows = document.querySelectorAll('.student-row');
    const noResults = document.getElementById('noResults');
    const totalCount = document.getElementById('totalCount');

    function filterStudents() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedProdi = prodiFilter.value;
        let visible = 0;

        studentRows.forEach(row => {
            const name = row.dataset.name;
            const nim  = row.dataset.nim;
            const prodi = row.dataset.prodi;

            const matchSearch = name.includes(searchTerm) || nim.includes(searchTerm);
            const matchProdi  = selectedProdi === 'all' || prodi === selectedProdi;

            if (matchSearch && matchProdi) {
                row.style.display = 'flex';
                visible++;
            } else {
                row.style.display = 'none';
            }
        });

        if (visible === 0) {
            noResults.classList.remove('d-none');
        } else {
            noResults.classList.add('d-none');
        }

        totalCount.textContent = visible;
    }

    searchInput.addEventListener('keyup', filterStudents);
    prodiFilter.addEventListener('change', filterStudents);
});
</script>

<?php include '../includes/footer.php'; ?>