<?php
// Start session for flash messages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load config and database
if (!defined('BASE_URL')) {
    define('BASE_URL', '../');
}

require_once '../config/config.php';
require_once '../models/Berita.php';
require_once '../models/RelatedPostsSettings.php';
require_once '../models/BeritaViews.php';
require_once '../models/KomentarBerita.php';

// Get slug from URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

if (empty($slug)) {
    header('Location: berita.php');
    exit;
}

// Initialize database and model
$database = new Database();
$db = $database->getConnection();
$beritaModel = new BeritaModel($db);

// Get berita by slug
$berita = $beritaModel->getBySlug($slug);

if (!$berita || $berita['status'] !== 'published') {
    header('Location: berita.php');
    exit;
}

// Konfigurasi halaman - set page title sesuai judul berita
$page_title = htmlspecialchars($berita['judul']);
$site_title = "Lab SE";

// Format tanggal
$tanggal = date('d F Y', strtotime($berita['tanggal_publikasi']));

// Get related posts settings
$relatedPostsModel = new RelatedPostsSettingsModel($db);
$relatedSettings = $relatedPostsModel->getSettings();

// Get related posts based on settings
$relatedPosts = [];
if ($relatedSettings['enabled']) {
    $maxPosts = $relatedSettings['max_posts'] ?? 3;
    $sameCategory = $relatedSettings['show_same_category'] ?? true;
    
    // Get more posts than needed to filter out current post
    if ($sameCategory) {
        $relatedPosts = $beritaModel->getAll($maxPosts + 5, 0, $berita['kategori'], null, 'published');
    } else {
        $relatedPosts = $beritaModel->getAll($maxPosts + 5, 0, null, null, 'published');
    }
    
    // Remove current post from related
    $relatedPosts = array_filter($relatedPosts, function($post) use ($berita) {
        return $post['id'] != $berita['id'];
    });
    $relatedPosts = array_slice($relatedPosts, 0, $maxPosts);
}

// Initialize views and comments models
$viewsModel = new BeritaViewsModel($db);
$komentarModel = new KomentarBeritaModel($db);

// Increment view count directly (server-side) - every time page loads/reloads
// Counter will increment every time the page is accessed (normal behavior)
$viewsModel->incrementView($berita['id']);

// Get view count (after increment)
$viewCount = $viewsModel->getTotalViews($berita['id']);

// Get comment count
$commentCount = $komentarModel->countByBeritaId($berita['id']);

// Get comments for this berita
$comments = $komentarModel->getByBeritaId($berita['id'], 'approved');

include '../includes/header.php'; 
include '../includes/navbar.php'; 
?>

<!-- Header dengan Foto Utama -->
<section class="berita-detail-header" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('<?= htmlspecialchars($berita['gambar']) ?>') center/cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="badge bg-primary mb-3"><?= htmlspecialchars($berita['kategori']) ?></div>
                <h1 class="display-4 fw-bold mb-3"><?= htmlspecialchars($berita['judul']) ?></h1>
            </div>
        </div>
    </div>
</section>

<!-- Content Area -->
<main class="berita-content">
    <!-- Meta Information -->
    <div class="berita-meta">
        <div class="berita-meta-item">
            <i class="bi bi-calendar3"></i>
            <span>Dipublikasikan: <?= $tanggal ?></span>
        </div>
        <div class="berita-meta-item">
            <i class="bi bi-person-circle"></i>
            <span>Oleh: <?= htmlspecialchars($berita['penulis']) ?></span>
        </div>
                                        <div class="berita-meta-item">
            <i class="bi bi-chat-left-text"></i>
            <span>Komentar: <span id="comment-count"><?= $commentCount ?></span></span>
        </div>
        <div class="berita-meta-item">
            <i class="bi bi-eye"></i>
            <span>Dilihat: <span id="view-count"><?= $viewCount ?></span> kali</span>
        </div>
    </div>
    
    <!-- Content Body -->
    <div class="berita-body">
        <?= $berita['isi_lengkap'] ?>
    </div>
    
    <!-- Social Share -->
    <div class="social-share">
        <h5><i class="bi bi-share-fill me-2"></i>Bagikan Berita</h5>
        <div class="social-share-buttons" id="social-share-buttons">
            <!-- Buttons will be loaded dynamically -->
        </div>
    </div>
    
    <!-- Comments Section -->
    <div class="comments-section mt-5">
        <h4 class="mb-4"><i class="bi bi-chat-left-text me-2"></i>Komentar</h4>
        
        <!-- Display flash messages -->
        <?php if (isset($_SESSION['komentar_status'])): ?>
            <div class="alert alert-<?= $_SESSION['komentar_status'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['komentar_message'] ?? '') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php 
            unset($_SESSION['komentar_status']);
            unset($_SESSION['komentar_message']);
            ?>
        <?php endif; ?>
        
        <!-- Comments List -->
        <div id="comments-container">
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1"><?= htmlspecialchars($comment['commenter_name']) ?></h6>
                                    <small class="text-muted"><?= date('d M Y, H:i', strtotime($comment['created_at'])) ?></small>
                                </div>
                            </div>
                            <p class="mb-0"><?= nl2br(htmlspecialchars($comment['comment_content'])) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
            <?php endif; ?>
        </div>
        
        <!-- Comment Form -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Tinggalkan Komentar</h5>
                <form method="POST" action="komentar_proses.php">
                    <input type="hidden" name="berita_id" value="<?= $berita['id'] ?>">
                    <input type="hidden" name="berita_slug" value="<?= htmlspecialchars($berita['slug']) ?>">
                    <div class="mb-3">
                        <label for="commenter_name" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="commenter_name" name="commenter_name" 
                               value="<?= isset($_POST['commenter_name']) ? htmlspecialchars($_POST['commenter_name']) : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="commenter_email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="commenter_email" name="commenter_email" 
                               value="<?= isset($_POST['commenter_email']) ? htmlspecialchars($_POST['commenter_email']) : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="comment_content" class="form-label">Komentar <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="comment_content" name="comment_content" rows="4" required><?= isset($_POST['comment_content']) ? htmlspecialchars($_POST['comment_content']) : '' ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" id="submit-btn">
                        <i class="bi bi-send me-2"></i><span id="btn-text">Kirim Komentar</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Related Posts -->
    <?php if ($relatedSettings['enabled'] && !empty($relatedPosts)): ?>
    <div class="related-posts">
        <h4 class="mb-4"><i class="bi bi-grid-3x3-gap me-2"></i>Berita Terkait</h4>
        <div class="row g-4">
            <?php foreach ($relatedPosts as $related): ?>
            <div class="col-md-4">
                <div class="card related-post-card">
                    <img src="<?= htmlspecialchars($related['gambar']) ?>" 
                         alt="<?= htmlspecialchars($related['judul']) ?>"
                         onerror="this.src='https://placehold.co/400x200/png?text=No+Image'">
                    <div class="card-body">
                        <div class="badge bg-info mb-2"><?= htmlspecialchars($related['kategori']) ?></div>
                        <h5 class="card-title">
                            <a href="berita_detail.php?slug=<?= htmlspecialchars($related['slug']) ?>" 
                               class="text-decoration-none">
                                <?= htmlspecialchars($related['judul']) ?>
                            </a>
                        </h5>
                        <p class="card-text text-muted small">
                            <?= htmlspecialchars(substr($related['isi_singkat'], 0, 100)) ?>...
                        </p>
                        <small class="text-muted">
                            <i class="bi bi-calendar3"></i> <?= date('d M Y', strtotime($related['tanggal_publikasi'])) ?>
                        </small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</main>

<script>
// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Load social share buttons
    loadSocialShareButtons();
    
    // Handle form submission with loading state
    const form = document.querySelector('form[action="komentar_proses.php"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('#submit-btn');
            const btnText = form.querySelector('#btn-text');
            
            if (submitBtn && btnText) {
                submitBtn.disabled = true;
                btnText.textContent = 'Mengirim...';
            }
        });
    }
    
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
    
    // Scroll to comments section if there's a komentar parameter in URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('komentar')) {
        const commentsSection = document.querySelector('.comments-section');
        if (commentsSection) {
            setTimeout(() => {
                commentsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        }
    }
});

// Social media configuration
let socialMediaConfig = [];

function loadSocialShareButtons() {
    const container = document.getElementById('social-share-buttons');
    // Use default social buttons (no API needed)
    loadDefaultSocialButtons(container);
}

function renderSocialButtons(container) {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent(document.title);
    
    const shareUrls = {
        facebook: `https://www.facebook.com/sharer/sharer.php?u=${url}`,
        twitter: `https://twitter.com/intent/tweet?url=${url}&text=${title}`,
        whatsapp: `https://wa.me/?text=${title}%20${url}`,
        telegram: `https://t.me/share/url?url=${url}&text=${title}`,
        linkedin: `https://www.linkedin.com/sharing/share-offsite/?url=${url}`,
        copy: '#'
    };
    
    const icons = {
        facebook: 'bi-facebook',
        twitter: 'bi-twitter',
        whatsapp: 'bi-whatsapp',
        telegram: 'bi-telegram',
        linkedin: 'bi-linkedin',
        copy: 'bi-link-45deg'
    };
    
    const labels = {
        facebook: 'Facebook',
        twitter: 'Twitter',
        whatsapp: 'WhatsApp',
        telegram: 'Telegram',
        linkedin: 'LinkedIn',
        copy: 'Salin Link'
    };
    
    // Sort by display_order
    socialMediaConfig.sort((a, b) => a.order - b.order);
    
    socialMediaConfig.forEach(social => {
        if (social.enabled) {
            const btn = document.createElement('a');
            btn.href = shareUrls[social.platform] || '#';
            btn.className = `social-share-btn ${social.platform}`;
            btn.target = social.platform === 'copy' ? '' : '_blank';
            btn.innerHTML = `<i class="bi ${icons[social.platform]}"></i> ${labels[social.platform] || social.platform}`;
            
            if (social.platform === 'copy') {
                btn.onclick = function(e) {
                    e.preventDefault();
                    copyToClipboard(window.location.href);
                };
            }
            
            container.appendChild(btn);
        }
    });
}

function loadDefaultSocialButtons(container) {
    const defaultConfig = [
        { platform: 'facebook', enabled: true },
        { platform: 'twitter', enabled: true },
        { platform: 'whatsapp', enabled: true },
        { platform: 'telegram', enabled: true },
        { platform: 'linkedin', enabled: true },
        { platform: 'copy', enabled: true }
    ];
    socialMediaConfig = defaultConfig;
    renderSocialButtons(container);
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Link berhasil disalin!');
    });
}

// View count is handled server-side directly on page load
</script>

<?php include '../includes/footer.php'; ?>

