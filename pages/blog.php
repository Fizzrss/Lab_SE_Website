<?php
// Definisikan BASE_URL
if (!defined('BASE_URL')) {
    if (file_exists('../includes/config.php')) {
        require_once '../includes/config.php';
    } else {
        define('BASE_URL', '../');
    }
}

$page_title = "Blog & Berita";
$site_title = "Lab SE";

include '../includes/header.php'; 
include '../includes/navbar.php'; 

$articles = [
    [ "id" => 1, "judul" => "Workshop Pengenalan Framework Laravel 10", "kategori" => "Workshop", "tanggal" => "12 Nov 2025", "penulis" => "Admin Lab", "gambar" => "https://placehold.co/800x600/png?text=Laravel+Workshop", "isi_singkat" => "Mahasiswa diajak menyelami fitur-fitur terbaru dari Laravel 10 dalam workshop intensif..." ],
    [ "id" => 2, "judul" => "Pentingnya Software Testing dalam Siklus DevOps", "kategori" => "Artikel Teknis", "tanggal" => "10 Nov 2025", "penulis" => "Dr. Rahmat Hidayat", "gambar" => "https://placehold.co/800x600/png?text=Software+Testing", "isi_singkat" => "Mengapa pengujian otomatis menjadi kunci keberhasilan implementasi DevOps..." ],
    [ "id" => 3, "judul" => "Lab SE Membuka Pendaftaran Asisten Baru 2026", "kategori" => "Pengumuman", "tanggal" => "05 Nov 2025", "penulis" => "Koordinator Lab", "gambar" => "https://placehold.co/800x600/png?text=Open+Recruitment", "isi_singkat" => "Kesempatan emas bagi mahasiswa tingkat 2 dan 3 untuk bergabung menjadi bagian dari keluarga..." ],
    [ "id" => 4, "judul" => "Tren UI/UX Design di Tahun 2025", "kategori" => "Wawasan", "tanggal" => "01 Nov 2025", "penulis" => "Maya Sari, MT", "gambar" => "https://placehold.co/800x600/png?text=UI+UX+Design", "isi_singkat" => "Membahas pergeseran tren dari minimalisme menuju desain yang lebih ekspresif..." ]
];
?>

<style>
    /* 1. Paksa Judul & Teks jadi Putih */
    .blog-hero-banner h1, 
    .blog-hero-banner p {
        color: #ffffff !important; /* !important memaksa warna jadi putih */
        text-shadow: 0 2px 15px rgba(0, 0, 0, 0.8); /* Bayangan hitam di belakang teks */
    }

    /* 2. (Opsional) Gelapkan lagi overlay-nya sedikit */
    .blog-hero-banner::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        /* Ubah 0.6 jadi 0.75 agar background lebih gelap & teks lebih jelas */
        background: rgba(0, 0, 0, 0.75); 
        z-index: 1;
    }
    .blog-hero-banner {
        background-image: url('../assets/img/lab1.jpg'); 
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        position: relative;
        padding: 6rem 1.5rem; /* Lebih tinggi */
        text-align: center;
        color: white;
        background-color: #2d465e;
    }
    .blog-hero-banner::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.65); /* Overlay lebih gelap */
        z-index: 1;
    }
    .blog-hero-banner .container {
        position: relative;
        z-index: 2;
    }
    
    /* Blog Card Styles */
    .blog-card {
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        background-color: #fff;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        transition: all 0.4s ease; /* Transisi lebih halus */
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .blog-card:hover {
        transform: translateY(-10px); /* Naik lebih tinggi */
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.15);
    }
    .blog-card img {
        height: 220px;
        object-fit: cover;
        width: 100%;
        transition: transform 0.5s ease;
    }
    .blog-card:hover img {
        transform: scale(1.05); /* Zoom in gambar */
    }
    .blog-card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .blog-title a {
        color: #2d465e;
        text-decoration: none;
        font-weight: 700;
        transition: color 0.3s;
    }
    .blog-title a:hover {
        color: var(--accent-color, #0d6efd);
    }
    .blog-footer {
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px solid #eee;
        font-size: 0.85rem;
        color: #6c757d;
        display: flex;
        justify-content: space-between;
    }
</style>

<section class="blog-hero-banner d-flex align-items-center">
    <div class="container" data-aos="fade-down" data-aos-duration="1000">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <span class="badge bg-primary rounded-pill mb-3 px-3 py-2">News & Updates</span>
                <h1 class="display-4 fw-bold mb-3">Jelajahi Dunia Software Engineering</h1>
                <p class="lead mb-4">Berita terbaru, artikel teknis, dan wawasan seputar teknologi dari Laboratorium Software Engineering.</p>
                
                <div class="input-group mb-3 shadow-sm">
                    <input type="text" class="form-control form-control-lg border-0" placeholder="Cari artikel menarik...">
                    <button class="btn btn-primary px-4" type="button"><i class="bi bi-search"></i> Cari</button>
                </div>
            </div>
        </div>
    </div>
</section>


<main>
    <div class="container my-5">

        <div class="row mb-5" data-aos="fade-up">
            <div class="col-12 d-flex justify-content-center flex-wrap gap-2">
                <button class="btn btn-outline-primary active rounded-pill">Semua</button>
                <button class="btn btn-outline-secondary rounded-pill">Workshop</button>
                <button class="btn btn-outline-secondary rounded-pill">Artikel Teknis</button>
                <button class="btn btn-outline-secondary rounded-pill">Kegiatan</button>
            </div>
        </div>

        <div class="row g-4">
            <?php 
            // Variabel untuk delay animasi berurutan
            $delay = 0; 
            foreach ($articles as $artikel) : 
                $delay += 100; // Tambah 100ms untuk setiap kartu
            ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                    <article class="blog-card">
                        
                        <div class="overflow-hidden">
                            <img src="<?= $artikel['gambar'] ?>" alt="<?= htmlspecialchars($artikel['judul']) ?>" loading="lazy">
                        </div>

                        <div class="blog-card-body">
                            <div class="text-primary fw-bold text-uppercase small mb-2"><?= $artikel['kategori'] ?></div>
                            
                            <h3 class="h5 blog-title mb-3">
                                <a href="#"><?= $artikel['judul'] ?></a>
                            </h3>
                            
                            <p class="text-muted small mb-4 flex-grow-1">
                                <?= $artikel['isi_singkat'] ?>
                            </p>

                            <div class="blog-footer">
                                <span><i class="bi bi-calendar3 me-1"></i> <?= $artikel['tanggal'] ?></span>
                                <span><i class="bi bi-person-circle me-1"></i> <?= $artikel['penulis'] ?></span>
                            </div>
                        </div>

                    </article>
                </div>
            <?php endforeach; ?>
        </div> <div class="row mt-5" data-aos="fade-up" data-aos-delay="200">
            <div class="col-12 d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>

    </div>
</main>

<?php include '../includes/footer.php'; ?>