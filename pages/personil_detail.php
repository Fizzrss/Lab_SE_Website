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
        
        // Tambahkan URL placeholder untuk kontak riset
        'google_scholar_url' => 'https://scholar.google.com/citations?user=contoh_user_id', 
        'researchgate_url' => 'https://www.researchgate.net/profile/Rahmat-Hidayat',

        'publikasi' => [
            ['judul' => 'LINGUISTIK FORENSIK DALAM MENGIDENTIFIKASI BAHASA YANG DIGUNAKAN DALAM BIDANG KEJAHATAN TRANSAKSI ELEKTRONIK', 'tahun' => 2025],
            ['judul' => 'Utilizing OpenStreetMap for Collaborative Mobile Reporting System in Irrigation Infrastructure Management', 'tahun' => 2025],
            ['judul' => 'An Application of SEMAR IoT Application Server Platform to Drone-Based Wall Inspection System Using AI Model', 'tahun' => 2025],
            ['judul' => 'A Proposal of In Situ Authoring Tool with Visual-Inertial Sensor Fusion for Outdoor Location-Based Augmented Reality', 'tahun' => 2025],
            ['judul' => 'Real-time server monitoring and notification system with prometheus, grafana, and telegram integration', 'tahun' => 2024],
            ['judul' => 'An implementation of web-based personal platform for programming learning assistant system with instance file update function', 'tahun' => 2024],
        ],
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
        'google_scholar_url' => '#', 
        'researchgate_url' => '#',
        'publikasi' => [],
    ],
    'dosen3' => [
        'nama' => 'Maya Sari, MT.',
        'peran' => 'Dosen Pembimbing Riset',
        'nip' => '198505152010012004',
        'email' => 'maya.sari@universitas.ac.id',
        'foto' => BASE_URL . 'assets/img/dosen3_profile.jpg',
        'spesialisasi' => ['Requirements Engineering', 'UML', 'Software Architecture'],
        'bio' => 'Beliau aktif dalam pengembangan infrastruktur teknologi lab dan membimbing proyek mahasiswa dalam implementasi CI/CD.',
        'google_scholar_url' => '#', 
        'researchgate_url' => '#',
    ],
    // ... data dosen lainnya
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

                    <h3 class="mt-4">Detail Kontak & Spesialisasi</h3>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-person-badge me-2"></i> NIP: <?= $personnel['nip'] ?></li>
                        <li><i class="bi bi-envelope me-2"></i> Email: <a href="mailto:<?= $personnel['email'] ?>"><?= $personnel['email'] ?></a></li>
    
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 1em; height: 1em; vertical-align: -0.125em; margin-right: 0.5rem;">
                                <path fill="currentColor" d="M390.9 298.5s0 .1 .1 .1c9.2 19.4 14.4 41.1 14.4 64-.1 82.5-66.9 149.4-149.4 149.4S106.7 445.1 106.7 362.7c0-22.9 5.2-44.6 14.4-64 1.7-3.6 3.6-7.2 5.6-10.7 4.4-7.6 9.4-14.7 15-21.3 27.4-32.6 68.5-53.3 114.4-53.3 33.6 0 64.6 11.1 89.6 29.9 9.1 6.9 17.4 14.7 24.8 23.5 5.6 6.6 10.6 13.8 15 21.3 2 3.4 3.8 7 5.5 10.5l-.1-.1zm26.4-18.8c-30.1-58.4-91-98.4-161.3-98.4s-131.2 40-161.3 98.4l-94.7-77 256-202.7 256 202.7-94.7 77.1 0-.1z"/>
                            </svg>
                            Scholar: <a href="<?= $personnel['google_scholar_url'] ?? 'https://scholar.google.com/' ?>" target="_blank">Google Scholar</a>
                        </li>

                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" style="width: 1em; height: 1em; vertical-align: -0.125em; margin-right: 0.5rem;">
                                <path fill="currentColor" d="M96 96L96 544L544 544L544 96L96 96zM358.2 430.4C351.6 433.4 325 436.4 308.2 416.2C299 405.6 282.9 382.9 266 352.6C257.1 352.6 251.3 352.6 244.6 352L244.6 398.4C244.6 421.9 250.6 419.6 270.4 422.3L270.4 430.4C263.5 430.1 247.3 429.6 234.8 429.6C221.7 429.6 208.7 430.2 201.2 430.4L201.2 422.3C216.7 419.4 223.2 421 223.2 398.4L223.2 289C223.2 266.4 216.8 268 201.2 265.1L201.2 257C227 258 254.3 256.4 272.1 256.4C303.8 256.4 328 270.8 328 302C328 323.1 311.3 344.2 288.8 349.5C302.4 373.7 318.8 395.1 331 408.4C338.2 416.2 348.2 423.1 358.2 423.1L358.2 430.4zM381.1 295.4C357.8 295.4 348.9 279.7 348.9 263.2L348.9 231C348.9 218.8 357.7 200.6 382.9 200.6C408.1 200.6 413.3 218.5 413.3 218.5L402.6 225.7C402.6 225.7 397.1 213.2 382.9 213.2C375 213.2 363.2 220.5 363.2 232.9L363.2 259.7C363.2 273.1 369.8 283 381.1 283C395.2 283 402.6 272.1 402.6 256.2L384.7 256.2L384.7 245.5L415.1 245.5C415.1 266 419.8 295.4 381.1 295.4zM264.6 340.1C255.2 340.1 251 339.8 244.6 339.3L244.6 269.6C251 269 259.6 269 267.1 269C290.4 269 304.3 281.2 304.3 303.5C304.3 325.4 289.3 340.1 264.6 340.1z"/>
                            </svg>
                            ResearchGate: <a href="<?= $personnel['researchgate_url'] ?? 'https://www.researchgate.net/' ?>" target="_blank">ResearchGate</a>
                        </li>
                    </ul>

                    <div class="mt-4">
                        <h4>Spesialisasi:</h4>
                        <?php foreach ($personnel['spesialisasi'] as $spec): ?>
                            <span class="badge bg-dark me-2 mb-2"><?= $spec ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <hr class="mt-4"> 

            <div class="mt-4">
                <ul class="nav nav-tabs" id="academicTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="publikasi-tab" data-bs-toggle="tab" data-bs-target="#publikasi-pane" type="button" role="tab" aria-controls="publikasi-pane" aria-selected="true">Publikasi</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="riset-tab" data-bs-toggle="tab" data-bs-target="#riset-pane" type="button" role="tab" aria-controls="riset-pane" aria-selected="false">Riset</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ki-tab" data-bs-toggle="tab" data-bs-target="#ki-pane" type="button" role="tab" aria-controls="ki-pane" aria-selected="false">Kekayaan Intelektual</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ppm-tab" data-bs-toggle="tab" data-bs-target="#ppm-pane" type="button" role="tab" aria-controls="ppm-pane" aria-selected="false">PPM</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="aktivitas-tab" data-bs-toggle="tab" data-bs-target="#aktivitas-pane" type="button" role="tab" aria-controls="aktivitas-pane" aria-selected="false">Aktivitas</button>
                    </li>
                </ul>
                
                <div class="tab-content pt-4" id="academicTabsContent">
                    
                    <div class="tab-pane fade show active" id="publikasi-pane" role="tabpanel" aria-labelledby="publikasi-tab" tabindex="0">
                        <?php if (!empty($personnel['publikasi'])): ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <label>
                                        <select class="form-select form-select-sm d-inline w-auto me-1">
                                            <option value="10">10</option>
                                        </select> 
                                        entries per page
                                    </label>
                                </div>
                                <div>
                                    <label>
                                        Search: <input type="search" class="form-control form-control-sm d-inline w-auto ms-1">
                                    </label>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle">
                                    <thead class="table-info">
                                        <tr>
                                            <th scope="col" style="width: 50px;">NO</th>
                                            <th scope="col">JUDUL</th>
                                            <th scope="col" style="width: 100px;">TAHUN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        foreach ($personnel['publikasi'] as $pub): 
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $pub['judul'] ?></td>
                                            <td class="text-center"><?= $pub['tahun'] ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-center text-muted">Belum ada data publikasi yang tersedia.</p>
                        <?php endif; ?>
                    </div>

                    <div class="tab-pane fade" id="riset-pane" role="tabpanel" aria-labelledby="riset-tab" tabindex="0">
                        <p class="text-center text-muted">Belum ada data publikasi yang tersedia..</p>
                    </div>
                    
                    <div class="tab-pane fade" id="ki-pane" role="tabpanel" aria-labelledby="ki-tab" tabindex="0">
                        <p class="text-center text-muted">Belum ada data publikasi yang tersedia.</p>
                    </div>

                    <div class="tab-pane fade" id="ppm-pane" role="tabpanel" aria-labelledby="ppm-tab" tabindex="0">
                        <p class="text-center text-muted">Belum ada data publikasi yang tersedia.</p>
                    </div>

                    <div class="tab-pane fade" id="aktivitas-pane" role="tabpanel" aria-labelledby="aktivitas-tab" tabindex="0">
                        <p class="text-center text-muted">Belum ada data publikasi yang tersedia.</p>
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