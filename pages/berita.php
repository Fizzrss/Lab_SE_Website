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
require_once '../models/BeritaSettings.php';

// Initialize database and model
$database = new Database();
$db = $database->getConnection();
$beritaModel = new BeritaModel($db);
$beritaSettingsModel = new BeritaSettingsModel($db);

// Get hero banner settings
$heroBadge = $beritaSettingsModel->getSetting('hero_badge', 'News & Updates');
$heroTitle = $beritaSettingsModel->getSetting('hero_title', 'Berita & Artikel Terkini');
$heroDescription = $beritaSettingsModel->getSetting('hero_description', 'Berita terbaru, artikel teknis, dan wawasan seputar teknologi dari Laboratorium Software Engineering.');
$heroBackgroundImage = $beritaSettingsModel->getSetting('hero_background_image', '../assets/img/lab1.jpg');

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

<section class="blog-hero-banner d-flex align-items-center" style="background-image: url('<?= htmlspecialchars($heroBackgroundImage) ?>');">
    <div class="container" data-aos="fade-down" data-aos-duration="1000">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <span class="badge bg-primary rounded-pill mb-3 px-3 py-2"><?= htmlspecialchars($heroBadge) ?></span>
                <h1 class="display-4 fw-bold mb-3"><?= htmlspecialchars($heroTitle) ?></h1>
                <p class="lead mb-4"><?= htmlspecialchars($heroDescription) ?></p>
                
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

