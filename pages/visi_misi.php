<?php
$page_title = 'Visi & Misi';
$current_page = 'visi_misi';
$meta_description = 'Visi dan Misi Laboratorium Software Engineering';

if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/Lab_SE_Website/');
}
$current_page = basename($_SERVER['PHP_SELF']);

// Load visi misi data from database
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/ProfilSections.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    $profilModel = new ProfilSectionsModel($db);
    
    $visiMisiSection = $profilModel->getByKey('visi_misi');
    $contentData = $visiMisiSection ? json_decode($visiMisiSection['section_content'], true) : null;
    
    $visi = $contentData['visi'] ?? 'Menjadi laboratorium software engineering terdepan yang menghasilkan lulusan berkompeten, inovatif, dan profesional dalam bidang rekayasa perangkat lunak untuk berkontribusi pada kemajuan teknologi informasi di Indonesia.';
    $misi = $contentData['misi'] ?? [
        'Menyelenggarakan pendidikan dan pelatihan berkualitas dalam bidang software engineering',
        'Mengembangkan penelitian dan inovasi dalam rekayasa perangkat lunak',
        'Membangun kolaborasi dengan industri dan institusi lain',
        'Menghasilkan produk software yang bermanfaat bagi masyarakat',
        'Membentuk komunitas developer yang solid dan profesional'
    ];
} catch (Exception $e) {
    // Fallback values
    $visi = 'Menjadi laboratorium software engineering terdepan yang menghasilkan lulusan berkompeten, inovatif, dan profesional dalam bidang rekayasa perangkat lunak untuk berkontribusi pada kemajuan teknologi informasi di Indonesia.';
    $misi = [
        'Menyelenggarakan pendidikan dan pelatihan berkualitas dalam bidang software engineering',
        'Mengembangkan penelitian dan inovasi dalam rekayasa perangkat lunak',
        'Membangun kolaborasi dengan industri dan institusi lain',
        'Menghasilkan produk software yang bermanfaat bagi masyarakat',
        'Membentuk komunitas developer yang solid dan profesional'
    ];
}
?>

<!-- Visi Misi Content -->
<section class="visi-misi-content py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Visi -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-5">
                        <div class="card-item">
                            <h2 class="mb-4">Visi</h2>
                            <p class="lead text-muted mb-0">
                                <?= htmlspecialchars($visi) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Misi -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-5">
                        <div class="card-item">
                            <h2 class="mb-4">Misi</h2>
                            <?php if (!empty($misi) && is_array($misi)): ?>
                            <ol class="misi-list lead text-muted ps-3">
                                <?php foreach ($misi as $misiItem): ?>
                                <li class="mb-2">
                                    <p class="mb-0">
                                        <?= htmlspecialchars($misiItem) ?>
                                    </p>
                                </li>
                                <?php endforeach; ?>
                            </ol>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>