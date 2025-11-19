<?php
// Konfigurasi halaman
$page_title = 'Beranda';
$site_title = 'LAB Software Engineering';
$meta_description = 'Website resmi LAB Software Engineering - Informasi kegiatan, profil, dan personil.';
$meta_keywords = 'lab se, software engineering, universitas, teknologi';

// Base URL (ubah sesuai kebutuhan)
define('BASE_URL', 'http://localhost/Lab_SE_Website/');

// Panggil navbar
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<body data-bs-spy="scroll" data-bs-target="#navbarNav" data-bs-offset="100">    
<main data-bs-spy="scroll" data-bs-target="#navbarNav" data-bs-offset="100">
    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">
        <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
            <img src="<?= BASE_URL ?>assets/img/bg_web.webp" class="d-block w-100" alt="Background LAB SE">
            <div class="carousel-container text-center text-light">
                <h2>Laboratorium Software Engineering</h2>
                <h2>Politeknik Negeri Malang</h2>
                <p>Mengembangkan inovasi teknologi untuk masa depan yang lebih cerdas.</p>
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
