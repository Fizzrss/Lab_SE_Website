<?php
/*
|--------------------------------------------------------------------------
| File: pages/roadmap.php
|--------------------------------------------------------------------------
| Halaman Roadmap LAB Software Engineering
| 1. Menggunakan include navbar & footer (otomatis rapi)
| 2. Tidak perlu koneksi database
| 3. Roadmap dibuat responsif dan animatif
*/

require_once '../includes/config.php'; // pastikan BASE_URL sudah ada
include '../includes/navbar.php';
?>

<!-- ===== STYLE KHUSUS UNTUK ROADMAP ===== -->
<style>
.roadmap-section {
  background: #f8f9fa;
  padding: 100px 20px;
  text-align: center;
}

.roadmap-title {
  font-weight: 700;
  color: #0d6efd;
  margin-bottom: 50px;
}

.roadmap-timeline {
  position: relative;
  max-width: 900px;
  margin: 0 auto;
  padding: 20px 0;
}

.roadmap-line {
  position: absolute;
  left: 50%;
  top: 0;
  transform: translateX(-50%);
  width: 4px;
  height: 100%;
  background-color: #0d6efd;
  z-index: 1;
}

.roadmap-item {
  position: relative;
  width: 50%;
  padding: 30px 40px;
  box-sizing: border-box;
}

.roadmap-item::before {
  content: "";
  position: absolute;
  top: 40px;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background-color: #0d6efd;
  z-index: 2;
}

.roadmap-item.left {
  left: 0;
  text-align: right;
}

.roadmap-item.left::before {
  right: -10px;
}

.roadmap-item.right {
  left: 50%;
}

.roadmap-item.right::before {
  left: -10px;
}

.roadmap-box {
  background: white;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  position: relative;
  z-index: 3;
  animation: fadeUp 0.7s ease forwards;
  opacity: 0;
}

.roadmap-item:nth-child(1) .roadmap-box { animation-delay: 0.2s; }
.roadmap-item:nth-child(2) .roadmap-box { animation-delay: 0.4s; }
.roadmap-item:nth-child(3) .roadmap-box { animation-delay: 0.6s; }
.roadmap-item:nth-child(4) .roadmap-box { animation-delay: 0.8s; }
.roadmap-item:nth-child(5) .roadmap-box { animation-delay: 1s; }

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Responsif Mobile */
@media screen and (max-width: 768px) {
  .roadmap-line {
    left: 8px;
  }
  .roadmap-item {
    width: 100%;
    text-align: left;
    padding-left: 40px;
  }
  .roadmap-item::before {
    left: 0;
  }
}
</style>

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
// Memanggil Footer
include '../includes/footer.php';
?>
