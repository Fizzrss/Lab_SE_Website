<?php
// Konfigurasi halaman
$page_title = "Berita & Artikel";
$site_title = "Lab SE";

// Load config and database
if (!defined('BASE_URL')) {
    define('BASE_URL', '../');
}

require_once '../config/config.php';
require_once '../models/Berita.php';

// Initialize database and model
$database = new Database();
$db = $database->getConnection();
$beritaModel = new BeritaModel($db);

// Get parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 9;
$offset = ($page - 1) * $limit;
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : null;

// Get berita data
$beritaList = $beritaModel->getAll($limit, $offset, $kategori, $search);
$totalBerita = $beritaModel->countAll($kategori, $search);
$totalPages = ceil($totalBerita / $limit);
$categories = $beritaModel->getCategories();

include '../includes/header.php'; 
include '../includes/navbar.php'; 
?>

<style>
    /* Hero Banner */
    .blog-hero-banner h1, 
    .blog-hero-banner p {
        color: #ffffff !important;
        text-shadow: 0 2px 15px rgba(0, 0, 0, 0.8);
    }

    .blog-hero-banner::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.75); 
        z-index: 1;
    }
    
    .blog-hero-banner {
        background-image: url('../assets/img/lab1.jpg'); 
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        position: relative;
        padding: 6rem 1.5rem;
        text-align: center;
        color: white;
        background-color: #2d465e;
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
        transition: all 0.4s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .blog-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.15);
    }
    
    .blog-card img {
        height: 220px;
        object-fit: cover;
        width: 100%;
        transition: transform 0.5s ease;
    }
    
    .blog-card:hover img {
        transform: scale(1.05);
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

    .category-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-btn {
        transition: all 0.3s ease;
    }

    .filter-btn.active {
        background-color: #0d6efd !important;
        color: white !important;
        border-color: #0d6efd !important;
    }

    .no-results {
        text-align: center;
        padding: 3rem 1rem;
    }

    .no-results i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }
</style>

<section class="blog-hero-banner d-flex align-items-center">
    <div class="container" data-aos="fade-down" data-aos-duration="1000">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <span class="badge bg-primary rounded-pill mb-3 px-3 py-2">News & Updates</span>
                <h1 class="display-4 fw-bold mb-3">Berita & Artikel Terkini</h1>
                <p class="lead mb-4">Berita terbaru, artikel teknis, dan wawasan seputar teknologi dari Laboratorium Software Engineering.</p>
                
                <form method="GET" action="" class="input-group mb-3 shadow-sm">
                    <input type="text" name="search" class="form-control form-control-lg border-0" 
                           placeholder="Cari berita menarik..." value="<?= htmlspecialchars($search ?? '') ?>">
                    <button class="btn btn-primary px-4" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<main>
    <div class="container my-5">
        <!-- Filter Kategori -->
        <div class="row mb-5" data-aos="fade-up">
            <div class="col-12 d-flex justify-content-center flex-wrap gap-2">
                <a href="berita.php" class="btn filter-btn <?= !$kategori ? 'btn-primary active' : 'btn-outline-secondary' ?> rounded-pill">
                    Semua
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="berita.php?kategori=<?= urlencode($cat) ?>" 
                       class="btn filter-btn <?= $kategori === $cat ? 'btn-primary active' : 'btn-outline-secondary' ?> rounded-pill">
                        <?= htmlspecialchars($cat) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Berita List -->
        <?php if (empty($beritaList)): ?>
            <div class="no-results">
                <i class="bi bi-inbox"></i>
                <h3>Tidak ada berita ditemukan</h3>
                <p class="text-muted">Coba ubah filter atau kata kunci pencarian Anda.</p>
                <a href="berita.php" class="btn btn-primary">Reset Filter</a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php 
                $delay = 0; 
                foreach ($beritaList as $berita): 
                    $delay += 100;
                    // Format tanggal
                    $tanggal = date('d M Y', strtotime($berita['tanggal_publikasi']));
                ?>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                        <article class="blog-card">
                            <div class="overflow-hidden">
                                <img src="<?= htmlspecialchars($berita['gambar']) ?>" 
                                     alt="<?= htmlspecialchars($berita['judul']) ?>" 
                                     loading="lazy"
                                     onerror="this.src='https://placehold.co/800x600/png?text=No+Image'">
                            </div>

                            <div class="blog-card-body">
                                <div class="text-primary fw-bold text-uppercase small mb-2 category-badge bg-primary bg-opacity-10">
                                    <?= htmlspecialchars($berita['kategori']) ?>
                                </div>
                                
                                <h3 class="h5 blog-title mb-3">
                                    <a href="berita_detail.php?slug=<?= htmlspecialchars($berita['slug']) ?>">
                                        <?= htmlspecialchars($berita['judul']) ?>
                                    </a>
                                </h3>
                                
                                <p class="text-muted small mb-4 flex-grow-1">
                                    <?= htmlspecialchars($berita['isi_singkat']) ?>
                                </p>

                                <div class="blog-footer">
                                    <span><i class="bi bi-calendar3 me-1"></i> <?= $tanggal ?></span>
                                    <span><i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($berita['penulis']) ?></span>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="row mt-5" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-12 d-flex justify-content-center">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <!-- Previous Button -->
                                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page - 1 ?><?= $kategori ? '&kategori=' . urlencode($kategori) : '' ?><?= $search ? '&search=' . urlencode($search) : '' ?>">
                                        Previous
                                    </a>
                                </li>

                                <!-- Page Numbers -->
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?><?= $kategori ? '&kategori=' . urlencode($kategori) : '' ?><?= $search ? '&search=' . urlencode($search) : '' ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <!-- Next Button -->
                                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page + 1 ?><?= $kategori ? '&kategori=' . urlencode($kategori) : '' ?><?= $search ? '&search=' . urlencode($search) : '' ?>">
                                        Next
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>

