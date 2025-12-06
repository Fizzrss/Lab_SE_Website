<?php
// Konfigurasi halaman
$page_title = 'Beranda';
$site_title = 'LAB Software Engineering';
$meta_description = 'Website resmi LAB Software Engineering - Informasi kegiatan, profil, dan personil.';
$meta_keywords = 'lab se, software engineering, universitas, teknologi';

// Base URL (ubah sesuai kebutuhan)
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/Lab_SE_Website/');
}

// Load hero settings from database
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/models/ProfilSections.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    $profilModel = new ProfilSectionsModel($db);
    $heroSettings = $profilModel->getHeroSettings();
    
    $heroTitle = $heroSettings['hero_title'] ?? 'Laboratorium Software Engineering';
    $heroSubtitle = $heroSettings['hero_subtitle'] ?? 'Politeknik Negeri Malang';
    $heroDescription = $heroSettings['hero_description'] ?? 'Mengembangkan inovasi teknologi untuk masa depan yang lebih cerdas.';
    $heroBgImage = $heroSettings['hero_background_image'] ?? 'assets/img/bg_web.webp';
} catch (Exception $e) {
    // Fallback values
    $heroTitle = 'Laboratorium Software Engineering';
    $heroSubtitle = 'Politeknik Negeri Malang';
    $heroDescription = 'Mengembangkan inovasi teknologi untuk masa depan yang lebih cerdas.';
    $heroBgImage = 'assets/img/bg_web.webp';
}

// Panggil navbar
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<body data-bs-spy="scroll" data-bs-target="#navbarNav" data-bs-offset="100">    
<main data-bs-spy="scroll" data-bs-target="#navbarNav" data-bs-offset="100">
    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">
        <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
            <img src="<?= BASE_URL . htmlspecialchars($heroBgImage) ?>" class="d-block w-100" alt="Background LAB SE">
            <div class="carousel-container text-center text-light">
                <h2><?= htmlspecialchars($heroTitle) ?></h2>
                <?php if (!empty($heroSubtitle)): ?>
                    <h2><?= htmlspecialchars($heroSubtitle) ?></h2>
                <?php endif; ?>
                <?php if (!empty($heroDescription)): ?>
                    <p><?= htmlspecialchars($heroDescription) ?></p>
                <?php endif; ?>
                <a href="#profil" class="btn-get-started">Get Started</a>
            </div>
        </div>
    </section>
    <?php
        require_once __DIR__ . '/pages/profil.php';
    ?>
</main>
<?php
require_once __DIR__ . '/includes/footer.php';
?>
</body>
