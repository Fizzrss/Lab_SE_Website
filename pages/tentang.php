<?php
if (!defined('BASE_URL')) {
  define('BASE_URL', 'http://localhost/Lab_SE_Website/');
}
$current_page = basename($_SERVER['PHP_SELF']);
?>

<section class="section-lab">
  <div class="container">
    <div class="row align-items-center gy-5">

      <div class="col-lg-6 pe-lg-5" data-aos="zoom-out" data-aos-duration="1000">
        <h2 class="lab-title">Tentang Kami</h2>
        <p class="lab-text lead">
          Laboratorium Rekayasa Perangkat Lunak merupakan fasilitas akademik di bawah naungan Jurusan Teknologi Informasi
          di Fakultas Teknik bidang rekayasa perangkat lunak yang mendukung Laboratorium ini dilengkapi tumbuh menjadi pusat aktivitas
          penelitian dan pengabdian masyarakat yang berfokus pada pengembangan teknologi perangkat lunak
        </p>
      </div>
      <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
        <div class="lab-img-wrapper">

          <div id="carouselLab" class="carousel slide carousel-fade lab-carousel" data-bs-ride="carousel">

            <div class="carousel-inner">

              <div class="carousel-item active" data-bs-interval="5000">
                <img src="<?= BASE_URL ?>assets/img/bg_web.webp" alt="Suasana Lab 1">
              </div>

              <div class="carousel-item" data-bs-interval="5000">
                <img src="<?= BASE_URL ?>assets/img/background.jpeg" alt="Suasana Lab 2">
              </div>

              <div class="carousel-item" data-bs-interval="5000">
                <img src="<?= BASE_URL ?>assets/img/lab2.jpeg" alt="Suasana Lab 3">
              </div>
            </div>
          </div>
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
