<?php
/*
|--------------------------------------------------------------------------
| File: pages/mahasiswa_list.php (Clean Version)
|--------------------------------------------------------------------------
| Tampilan List Modern & Interaktif.
| CSS dipisah ke assets/css/style.css
*/

// 1. Konfigurasi
require_once '../includes/config.php';

$page_title = "Daftar Mahasiswa"; 

include '../includes/header.php'; 
include '../includes/navbar.php'; 

// 2. DATA DUMMY
$dummy_mahasiswa_list = [
    [ 
        "nama" => "Ahmad Fauzi", 
        "nim" => "2241720001",
        "prodi" => "D-IV Sistem Informasi Bisnis", 
        "status" => "Aktif",
        "foto" => "https://images.unsplash.com/photo-1599566150163-29194dcaad36?auto=format&fit=crop&w=100&q=80"
    ],
    [ 
        "nama" => "Siti Nurhaliza", 
        "nim" => "2241720002",
        "prodi" => "D-IV Sistem Informasi Bisnis", 
        "status" => "Aktif",
        "foto" => "https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80"
    ],
    [ 
        "nama" => "Budi Santoso", 
        "nim" => "2241720123",
        "prodi" => "D-IV Teknik Informatika", 
        "status" => "Cuti",
        "foto" => "https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=100&q=80"
    ],
    [ 
        "nama" => "Dewi Lestari", 
        "nim" => "2041720099",
        "prodi" => "D-IV Sistem Informasi Bisnis", 
        "status" => "Alumni",
        "foto" => "https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=100&q=80"
    ],
    [ 
        "nama" => "Rian Hidayat", 
        "nim" => "2341720011",
        "prodi" => "D-IV Teknik Informatika", 
        "status" => "Aktif",
        "foto" => "https://images.unsplash.com/photo-1527980965255-d3b416303d12?auto=format&fit=crop&w=100&q=80"
    ]
];

// Helper Warna Status
function getStatusColor($status) {
    if ($status == 'Aktif') return 'success'; 
    if ($status == 'Cuti') return 'warning';  
    if ($status == 'Alumni') return 'secondary'; 
    return 'primary';
}
?>

<section class="page-hero-banner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Daftar Mahasiswa Lab SE</h1>
                <p class="opacity-75">Data mahasiswa aktif, cuti, dan alumni.</p>
            </div>
        </div>
    </div>
</section>

<main class="main-content-container">
    <div class="container">

        <div class="filter-card" data-aos="fade-up">
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Cari nama atau NIM...">
                    </div>
                </div>
                <div class="col-md-4">
                    <select id="prodiFilter" class="form-select">
                        <option value="all">Semua Program Studi</option>
                        <option value="D-IV Sistem Informasi Bisnis">D-IV Sistem Informasi Bisnis</option>
                        <option value="D-IV Teknik Informatika">D-IV Teknik Informatika</option>
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    <span class="text-muted small">Total: <strong id="totalCount"><?= count($dummy_mahasiswa_list) ?></strong></span>
                </div>
            </div>
        </div>

        <div id="studentList">
            <?php 
            $delay = 100;
            foreach ($dummy_mahasiswa_list as $mhs) : 
                $delay += 50;
                $badgeColor = getStatusColor($mhs['status']);
            ?>
                <div class="student-row" 
                     data-aos="fade-up" 
                     data-aos-delay="<?= $delay ?>"
                     data-name="<?= strtolower($mhs['nama']) ?>"
                     data-nim="<?= $mhs['nim'] ?>"
                     data-prodi="<?= $mhs['prodi'] ?>">
                    
                    <div class="student-avatar me-md-4 mb-3 mb-md-0">
                        <img src="<?= $mhs['foto'] ?>" alt="<?= htmlspecialchars($mhs['nama']) ?>">
                    </div>

                    <div class="student-info flex-grow-1 text-md-start mb-2 mb-md-0">
                        <h5 class="student-name"><?= htmlspecialchars($mhs['nama']) ?></h5>
                        <span class="student-nim"><i class="bi bi-card-heading me-1"></i><?= htmlspecialchars($mhs['nim']) ?></span>
                    </div>

                    <div class="student-prodi col-md-3 text-md-start mb-2 mb-md-0">
                        <i class="bi bi-mortarboard me-1 text-primary"></i> <?= htmlspecialchars($mhs['prodi']) ?>
                    </div>

                    <div class="student-status col-md-2 text-md-center mb-2 mb-md-0">
                        <span class="badge bg-<?= $badgeColor ?> bg-opacity-10 text-<?= $badgeColor ?> status-badge border border-<?= $badgeColor ?>">
                            <?= htmlspecialchars($mhs['status']) ?>
                        </span>
                    </div>

                    <div class="ms-md-4">
                        <a href="#" class="btn-action shadow-sm">
                            <i class="bi bi-chevron-right"></i>
                        </a>
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
                        <a href="<?= BASE_URL ?>pages/recruitment_form.php" class="btn btn-custom-accent px-5 py-2 rounded-pill shadow">
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
        let visibleCount = 0;

        studentRows.forEach(row => {
            const name = row.getAttribute('data-name');
            const nim = row.getAttribute('data-nim');
            const prodi = row.getAttribute('data-prodi');

            const matchesSearch = name.includes(searchTerm) || nim.includes(searchTerm);
            const matchesProdi = selectedProdi === 'all' || prodi === selectedProdi;

            if (matchesSearch && matchesProdi) {
                row.style.display = 'flex'; 
                visibleCount++;
            } else {
                row.style.display = 'none'; 
            }
        });

        if (visibleCount === 0) {
            noResults.classList.remove('d-none');
        } else {
            noResults.classList.add('d-none');
        }
        totalCount.textContent = visibleCount;
    }

    searchInput.addEventListener('keyup', filterStudents);
    prodiFilter.addEventListener('change', filterStudents);
});
</script>

<?php
include '../includes/footer.php';
?>