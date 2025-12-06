<?php
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

// Increment view count (simple counter - will improve later)
// TODO: Add view counter table

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

// Get view count
$viewCount = $viewsModel->getTotalViews($berita['id']);

// Get comment count
$commentCount = $komentarModel->countByBeritaId($berita['id']);

include '../includes/header.php'; 
include '../includes/navbar.php'; 
?>

<style>
    .berita-detail-header {
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('<?= htmlspecialchars($berita['gambar']) ?>') center/cover no-repeat;
        background-attachment: fixed;
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
        position: relative;
    }
    
    .berita-detail-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 1;
    }
    
    .berita-detail-header .container {
        position: relative;
        z-index: 2;
        color: white;
    }
    
    .berita-detail-header h1,
    .berita-detail-header .display-4,
    .berita-detail-header * {
        color: white !important;
    }
    
    .berita-detail-header .badge {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: white !important;
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    
    .berita-content {
        max-width: 900px;
        margin: 0 auto;
        padding: 3rem 1.5rem;
    }
    
    .berita-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        padding: 1.5rem 0;
        border-bottom: 2px solid #e9ecef;
        margin-bottom: 2rem;
    }
    
    .berita-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .berita-meta-item i {
        color: #0d6efd;
    }
    
    .berita-body {
        line-height: 1.8;
        font-size: 1.1rem;
    }
    
    .berita-body img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
        margin: 1.5rem 0;
    }
    
    .berita-body h1, .berita-body h2, .berita-body h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #2d465e;
    }
    
    .berita-body p {
        margin-bottom: 1.5rem;
    }
    
    .social-share {
        padding: 2rem 0;
        border-top: 2px solid #e9ecef;
        border-bottom: 2px solid #e9ecef;
        margin: 2rem 0;
    }
    
    .social-share h5 {
        margin-bottom: 1rem;
        color: #2d465e;
    }
    
    .social-share-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    
    .social-share-btn {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: transform 0.2s;
    }
    
    .social-share-btn:hover {
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }
    
    .social-share-btn.facebook { background-color: #1877f2; }
    .social-share-btn.twitter { background-color: #1da1f2; }
    .social-share-btn.whatsapp { background-color: #25d366; }
    .social-share-btn.telegram { background-color: #0088cc; }
    .social-share-btn.linkedin { background-color: #0077b5; }
    .social-share-btn.copy { background-color: #6c757d; }
    
    .related-posts {
        margin-top: 4rem;
        padding-top: 3rem;
        border-top: 2px solid #e9ecef;
    }
    
    .related-post-card {
        border: none;
        border-radius: 0.5rem;
        overflow: hidden;
        transition: transform 0.3s;
        height: 100%;
    }
    
    .related-post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .related-post-card img {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }
</style>

<!-- Header dengan Foto Utama -->
<section class="berita-detail-header">
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
        <div id="comments-container">
            <!-- Comments will be loaded here -->
            <p class="text-muted">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
        </div>
        
        <!-- Comment Form -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Tinggalkan Komentar</h5>
                <form id="comment-form">
                    <input type="hidden" name="berita_id" value="<?= $berita['id'] ?>">
                    <div class="mb-3">
                        <label for="commenter_name" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="commenter_name" name="commenter_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="commenter_email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="commenter_email" name="commenter_email" required>
                    </div>
                    <div class="mb-3">
                        <label for="comment_content" class="form-label">Komentar <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="comment_content" name="comment_content" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-2"></i>Kirim Komentar
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
    
    // Load comments
    loadComments();
    
    // Handle comment form
    document.getElementById('comment-form').addEventListener('submit', submitComment);
    
    // Increment view count (only once per session)
    incrementViewCount();
});

// Social media configuration
let socialMediaConfig = [];

function loadSocialShareButtons() {
    const container = document.getElementById('social-share-buttons');
    
    // Load social media settings from API
    fetch('../api/social_media.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                socialMediaConfig = data.platforms;
                renderSocialButtons(container);
            } else {
                // Fallback to default if API fails
                loadDefaultSocialButtons(container);
            }
        })
        .catch(error => {
            console.error('Error loading social media settings:', error);
            loadDefaultSocialButtons(container);
        });
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

function loadComments() {
    fetch(`../api/comments.php?berita_id=<?= $berita['id'] ?>`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.comments && data.comments.length > 0) {
                    displayComments(data.comments);
                    document.getElementById('comment-count').textContent = data.count || data.comments.length;
                } else {
                    document.getElementById('comments-container').innerHTML = '<p class="text-muted">Belum ada komentar. Jadilah yang pertama berkomentar!</p>';
                    document.getElementById('comment-count').textContent = '0';
                }
            }
        })
        .catch(error => console.error('Error loading comments:', error));
}

function displayComments(comments) {
    const container = document.getElementById('comments-container');
    container.innerHTML = '';
    
    comments.forEach(comment => {
        const commentDiv = document.createElement('div');
        commentDiv.className = 'card mb-3';
        commentDiv.innerHTML = `
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="mb-1">${comment.commenter_name}</h6>
                        <small class="text-muted">${comment.created_at}</small>
                    </div>
                </div>
                <p class="mb-0">${comment.comment_content}</p>
            </div>
        `;
        container.appendChild(commentDiv);
    });
}

function submitComment(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    
    // Disable button and show loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
    
    fetch('../api/comments.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reset form
            e.target.reset();
            
            // Add comment immediately to the list
            if (data.comment) {
                const container = document.getElementById('comments-container');
                
                // Remove "no comments" message if exists
                if (container.innerHTML.includes('Belum ada komentar')) {
                    container.innerHTML = '';
                }
                
                // Create and prepend new comment
                const commentDiv = document.createElement('div');
                commentDiv.className = 'card mb-3';
                commentDiv.innerHTML = `
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1">${data.comment.commenter_name}</h6>
                                <small class="text-muted">${data.comment.created_at}</small>
                            </div>
                        </div>
                        <p class="mb-0">${data.comment.comment_content}</p>
                    </div>
                `;
                container.insertBefore(commentDiv, container.firstChild);
                
                // Update comment count
                const currentCount = parseInt(document.getElementById('comment-count').textContent) || 0;
                document.getElementById('comment-count').textContent = currentCount + 1;
                
                // Show success message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                alertDiv.innerHTML = `
                    <i class="bi bi-check-circle me-2"></i>Komentar berhasil dikirim!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                e.target.parentElement.insertBefore(alertDiv, e.target);
                
                // Auto-dismiss after 3 seconds
                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
                
                // Scroll to comment
                commentDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } else {
                // Fallback: reload comments
                loadComments();
                alert('Komentar berhasil dikirim!');
            }
        } else {
            alert('Gagal mengirim komentar: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim komentar');
    })
    .finally(() => {
        // Re-enable button
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    });
}

function incrementViewCount() {
    // Increment view count via AJAX (only once per session)
    fetch('../api/views.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ berita_id: <?= $berita['id'] ?> })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('view-count').textContent = data.view_count || <?= $viewCount ?>;
        }
    })
    .catch(error => console.error('Error incrementing view count:', error));
}
</script>

<?php include '../includes/footer.php'; ?>

