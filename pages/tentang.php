<?php
if (!defined('BASE_URL')) {
  define('BASE_URL', 'http://localhost/Lab_SE_Website/');
}
$current_page = basename($_SERVER['PHP_SELF']);

// Load tentang data from database
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/ProfilSections.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    $profilModel = new ProfilSectionsModel($db);
    
    $tentangSection = $profilModel->getByKey('tentang');
    $contentData = $tentangSection ? json_decode($tentangSection['section_content'], true) : null;
    
    $title = $tentangSection['section_title'] ?? 'Tentang Kami';
    $description = $contentData['description'] ?? 'Laboratorium Rekayasa Perangkat Lunak merupakan fasilitas akademik di bawah naungan Jurusan Teknologi Informasi di Fakultas Teknik bidang rekayasa perangkat lunak yang mendukung Laboratorium ini dilengkapi tumbuh menjadi pusat aktivitas penelitian dan pengabdian masyarakat yang berfokus pada pengembangan teknologi perangkat lunak';
    $images = $contentData['images'] ?? ['assets/img/bg_web.webp', 'assets/img/background.jpeg', 'assets/img/lab2.jpeg'];
} catch (Exception $e) {
    // Fallback values
    $title = 'Tentang Kami';
    $description = 'Laboratorium Rekayasa Perangkat Lunak merupakan fasilitas akademik di bawah naungan Jurusan Teknologi Informasi di Fakultas Teknik bidang rekayasa perangkat lunak yang mendukung Laboratorium ini dilengkapi tumbuh menjadi pusat aktivitas penelitian dan pengabdian masyarakat yang berfokus pada pengembangan teknologi perangkat lunak';
    $images = ['assets/img/bg_web.webp', 'assets/img/background.jpeg', 'assets/img/lab2.jpeg'];
}
?>

<section class="section-lab">
  <div class="container">
    <div class="row align-items-center gy-5">

      <div class="col-lg-6 pe-lg-5" data-aos="zoom-out" data-aos-duration="1000">
        <h2 class="lab-title"><?= htmlspecialchars($title) ?></h2>
        <p class="lab-text lead">
          <?= htmlspecialchars($description) ?>
        </p>
      </div>
      <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
        <div class="lab-img-wrapper">
          <?php if (!empty($images)): ?>
          <div id="carouselLab" class="carousel slide carousel-fade lab-carousel" data-bs-ride="carousel">
            <div class="carousel-inner">
              <?php foreach ($images as $index => $image): ?>
              <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>" data-bs-interval="5000">
                <img src="<?= BASE_URL . htmlspecialchars($image) ?>" alt="Suasana Lab <?= $index + 1 ?>" onerror="this.src='<?= BASE_URL ?>assets/img/bg_web.webp'">
              </div>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  // Inisialisasi Animasi
  AOS.init({
    once: true, // Animasi hanya terjadi sekali saat scroll ke bawah
  });
</script>
