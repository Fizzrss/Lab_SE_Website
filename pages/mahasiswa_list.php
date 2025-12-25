<?php
// Helper warna status
function getStatusColor($status)
{
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

$page_title = "Daftar Mahasiswa - Lab SE";
require_once $root . '/includes/header.php';
require_once $root . '/includes/navbar.php';

?>

<header class="header text-center py-5 text-white">
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
                        <?php
                        $listProdi = [
                            "D4 - Teknik Informatika",
                            "D4 - Sistem Informasi Bisnis"
                        ];

                        foreach ($listProdi as $p) {
                            $selected = ($data['prodi'] == $p) ? 'selected' : '';
                            echo "<option value='$p' $selected>$p</option>";
                        }
                        ?>
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

        <nav aria-label="Page navigation" class="mt-4" id="paginationContainer">
            <ul class="pagination justify-content-center" id="pagination">
                </ul>
        </nav>

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
        const itemsPerPage = 10;
        let currentPage = 1;
        let filteredRows = [];

        const searchInput = document.getElementById('searchInput');
        const prodiFilter = document.getElementById('prodiFilter');
        const studentRows = Array.from(document.querySelectorAll('.student-row'));
        const noResults = document.getElementById('noResults');
        const totalCount = document.getElementById('totalCount');
        const paginationList = document.getElementById('pagination');
        const paginationContainer = document.getElementById('paginationContainer');

        function filterStudents() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedProdi = prodiFilter.value;

            filteredRows = [];

            studentRows.forEach(row => {
                const name = row.dataset.name;
                const nim = row.dataset.nim;
                const prodi = row.dataset.prodi;

                const matchSearch = name.includes(searchTerm) || nim.includes(searchTerm);
                const matchProdi = selectedProdi === 'all' || prodi === selectedProdi;

                if (matchSearch && matchProdi) {
                    filteredRows.push(row);
                }
                row.style.display = 'none';
            });

            totalCount.textContent = filteredRows.length;

            if (filteredRows.length === 0) {
                noResults.classList.remove('d-none');
                paginationContainer.classList.add('d-none');
            } else {
                noResults.classList.add('d-none');
                paginationContainer.classList.remove('d-none');
                
                currentPage = 1;
                
                renderPagination();
                showPage(currentPage);
            }
        }

        function showPage(page) {
            filteredRows.forEach(row => row.style.display = 'none');

            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;

            const pageItems = filteredRows.slice(start, end);

            pageItems.forEach(row => {
                row.style.display = 'flex';
                
                row.classList.remove('aos-animate');
                setTimeout(() => row.classList.add('aos-animate'), 50); 
            });
        }

        function renderPagination() {
            paginationList.innerHTML = '';
            
            const totalPages = Math.ceil(filteredRows.length / itemsPerPage);

            if (totalPages <= 1) return;

            const prevLi = document.createElement('li');
            prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
            prevLi.innerHTML = `<a class="page-link" href="#" aria-label="Previous">&laquo;</a>`;
            prevLi.addEventListener('click', (e) => {
                e.preventDefault();
                if (currentPage > 1) {
                    currentPage--;
                    changePage();
                }
            });
            paginationList.appendChild(prevLi);

            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.addEventListener('click', (e) => {
                    e.preventDefault();
                    currentPage = i;
                    changePage();
                });
                paginationList.appendChild(li);
            }

            const nextLi = document.createElement('li');
            nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
            nextLi.innerHTML = `<a class="page-link" href="#" aria-label="Next">&raquo;</a>`;
            nextLi.addEventListener('click', (e) => {
                e.preventDefault();
                if (currentPage < totalPages) {
                    currentPage++;
                    changePage();
                }
            });
            paginationList.appendChild(nextLi);
        }

        function changePage() {
            renderPagination();
            showPage(currentPage);
        }

        searchInput.addEventListener('keyup', filterStudents);
        prodiFilter.addEventListener('change', filterStudents);

        filterStudents();
    });
</script>

<?php include '../includes/footer.php'; ?>