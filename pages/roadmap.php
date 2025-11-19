<?php
$page_title = 'Roadmap';
$current_page = 'roadmap';
$meta_description = 'Roadmap Pengembangan Laboratorium Software Engineering';

if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/pbl/');
}
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- ===== BAGIAN KONTEN ROADMAP ===== -->
<section class="roadmap-section">
  <div class="container">
    <h1 class="roadmap-title">Roadmap Pengembangan LAB Software Engineering</h1>

    <div class="roadmap-timeline">
      <div class="roadmap-line"></div>

      <div class="roadmap-item left">
        <div class="roadmap-box">
          <h4>2021</h4>
          <p>Inisiasi pembentukan LAB Software Engineering dan penyusunan struktur organisasi awal.</p>
        </div>
      </div>

      <div class="roadmap-item right">
        <div class="roadmap-box">
          <h4>2022</h4>
          <p>Mulai kegiatan riset internal dan pembuatan website resmi LAB Software Engineering.</p>
        </div>
      </div>

      <div class="roadmap-item left">
        <div class="roadmap-box">
          <h4>2023</h4>
          <p>Peluncuran sistem informasi internal serta kolaborasi pertama dengan pihak industri.</p>
        </div>
      </div>

      <div class="roadmap-item right">
        <div class="roadmap-box">
          <h4>2024</h4>
          <p>Implementasi CI/CD, modernisasi website, dan penguatan kegiatan DevOps untuk anggota.</p>
        </div>
      </div>

      <div class="roadmap-item left">
        <div class="roadmap-box">
          <h4>2025</h4>
          <p>Fokus pada riset AI, kolaborasi startup teknologi, dan ekspansi skala proyek nasional.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<?php
?>
