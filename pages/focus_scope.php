<?php
/*
|--------------------------------------------------------------------------
| File: pages/focus_scope.php (Fokus Riset Menggunakan Style Card)
|--------------------------------------------------------------------------
*/

// 1. CARI ALAMAT PASTI FOLDER PROJECT
$projectRoot = realpath(__DIR__ . '/..');

// 2. Konfigurasi & Config
if (file_exists($projectRoot . '/includes/config.php')) {
    require_once $projectRoot . '/includes/config.php';
} else {
    define('BASE_URL', 'http://localhost/Lab_SE_Website/');
}

$page_title = "Focus & Scope";
$site_title = "Lab SE";

// 3. Panggil Header & Navbar
include $projectRoot . '/includes/header.php'; 
include $projectRoot . '/includes/navbar.php'; 

// 4. DATA DUMMY
$fokus_riset = [
    "Software Engineering Methodologies and Architecture",
    "Domain-Specific Software Engineering Applications",
    "Emerging Technologies in Software Engineering",
];

$lingkup_detail = [
    [ "icon" => "bi-diagram-3", "judul" => "Methodologies", "desc" => "Pengembangan metode Agile, Scrum, dan pendekatan modern dalam SDLC." ],
    [ "icon" => "bi-cpu", "judul" => "Architecture", "desc" => "Perancangan arsitektur Microservices, Monolithic, dan Serverless." ],
    [ "icon" => "bi-bug", "judul" => "Testing & QA", "desc" => "Otomatisasi pengujian perangkat lunak untuk menjamin kualitas sistem." ],
    [ "icon" => "bi-phone", "judul" => "Mobile & Web", "desc" => "Riset implementasi teknologi terbaru pada platform web & seluler." ]
];
?>

<section class="focus-hero-banner d-flex align-items-center">
    <div class="container" data-aos="fade-down">
        <span class="badge bg-light text-primary rounded-pill mb-3 px-3 py-2 border border-white">
            Research Areas
        </span>
        <h1 class="display-4 mb-3">Focus & Scope</h1>
        <p class="lead text-white-50" style="max-width: 700px; margin: 0 auto;">
            Kami berdedikasi untuk mengeksplorasi batas-batas baru dalam rekayasa perangkat lunak.
        </p>
    </div>
</section>

<main>
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12" data-aos="fade-right">
                    <h2 class="section-title">Fokus Riset</h2>
                    <p class="text-muted">
                        Laboratorium kami memprioritaskan penelitian pada area-area kunci berikut 
                        untuk menjawab tantangan industri modern.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <?php 
                $delay = 0;
                foreach ($fokus_riset as $fokus) : 
                    $delay += 50; 
                ?>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                        
                        <div class="scope-card h-100 d-flex flex-column align-items-start text-start">
                            
                            <div class="scope-icon mb-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                <i class="bi bi-search"></i>
                            </div>

                            <h4 class="h5 fw-bold mb-2"><?= $fokus ?></h4>
                            
                            <div style="width: 40px; height: 3px; background-color: var(--accent-color); border-radius: 2px; margin-top: auto; opacity: 0.5;"></div>
                            
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-5 text-center">
                <div class="col-12" data-aos="fade-up">
                    <h2 class="section-title" style="margin: 0 auto 2rem auto;">Lingkup Pengembangan</h2>
                    <p class="text-muted mx-auto" style="max-width: 600px;">
                        Selain riset teoritis, kami juga aktif dalam pengembangan praktis di berbagai domain teknologi.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <?php 
                $cardDelay = 100;
                foreach ($lingkup_detail as $item) : 
                    $cardDelay += 100;
                ?>
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?= $cardDelay ?>">
                        <div class="scope-card">
                            <div class="scope-icon">
                                <i class="bi <?= $item['icon'] ?>"></i>
                            </div>
                            <h4 class="h5 fw-bold mb-3"><?= $item['judul'] ?></h4>
                            <p class="text-muted small mb-0">
                                <?= $item['desc'] ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

</main>

<?php 
include $projectRoot . '/includes/footer.php'; 
?>