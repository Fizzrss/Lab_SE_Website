<?php
$page_title = 'Roadmap';
$current_page = 'roadmap';
$meta_description = 'Roadmap Pengembangan Laboratorium Software Engineering';

if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/Lab_SE_Website/');
}
$current_page = basename($_SERVER['PHP_SELF']);

// Load roadmap data from database
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/ProfilSections.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    $profilModel = new ProfilSectionsModel($db);
    
    $roadmapSection = $profilModel->getByKey('roadmap');
    $contentData = $roadmapSection ? json_decode($roadmapSection['section_content'], true) : null;
    
    $title = $roadmapSection['section_title'] ?? 'Roadmap Pengembangan LAB Software Engineering';
    $items = $contentData['items'] ?? [
        ['year' => '2021', 'description' => 'Inisiasi pembentukan LAB Software Engineering dan penyusunan struktur organisasi awal.'],
        ['year' => '2022', 'description' => 'Mulai kegiatan riset internal dan pembuatan website resmi LAB Software Engineering.'],
        ['year' => '2023', 'description' => 'Peluncuran sistem informasi internal serta kolaborasi pertama dengan pihak industri.'],
        ['year' => '2024', 'description' => 'Implementasi CI/CD, modernisasi website, dan penguatan kegiatan DevOps untuk anggota.'],
        ['year' => '2025', 'description' => 'Fokus pada riset AI, kolaborasi startup teknologi, dan ekspansi skala proyek nasional.']
    ];
} catch (Exception $e) {
    // Fallback values
    $title = 'Roadmap Pengembangan LAB Software Engineering';
    $items = [
        ['year' => '2021', 'description' => 'Inisiasi pembentukan LAB Software Engineering dan penyusunan struktur organisasi awal.'],
        ['year' => '2022', 'description' => 'Mulai kegiatan riset internal dan pembuatan website resmi LAB Software Engineering.'],
        ['year' => '2023', 'description' => 'Peluncuran sistem informasi internal serta kolaborasi pertama dengan pihak industri.'],
        ['year' => '2024', 'description' => 'Implementasi CI/CD, modernisasi website, dan penguatan kegiatan DevOps untuk anggota.'],
        ['year' => '2025', 'description' => 'Fokus pada riset AI, kolaborasi startup teknologi, dan ekspansi skala proyek nasional.']
    ];
}
?>

<!-- ===== BAGIAN KONTEN ROADMAP ===== -->
<section class="roadmap-section py-5">
  <div class="container">
    <h1 class="roadmap-title" data-aos="fade-down"><?= htmlspecialchars($title) ?></h1>

    <div class="roadmap-timeline">
      <div class="roadmap-line"></div>

      <?php if (!empty($items) && is_array($items)): ?>
        <?php 
        $delay = 0;
        foreach ($items as $index => $item): 
          $delay += 100;
        ?>
          <div class="roadmap-item <?= $index % 2 === 0 ? 'left' : 'right' ?>" data-aos="<?= $index % 2 === 0 ? 'fade-right' : 'fade-left' ?>" data-aos-delay="<?= $delay ?>">
            <div class="roadmap-box roadmap-card">
              <div class="roadmap-year"><?= htmlspecialchars($item['year'] ?? '') ?></div>
              <p class="roadmap-description"><?= htmlspecialchars($item['description'] ?? '') ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

    </div>
  </div>
</section>
