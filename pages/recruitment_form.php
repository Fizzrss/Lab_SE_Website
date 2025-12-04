<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';

require_once $root . '/config/config.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}


$page_title = "Daftar Personil - Lab SE";
require_once $root . '/includes/header.php';
require_once $root . '/includes/navbar.php';
?>


<!-- <section class="page-hero-banner">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1>Formulir Pendaftaran</h1>
        <p>Bergabunglah dengan tim Laboratorium Software Engineering.</p>
      </div>
    </div>
  </div>
</section> -->

<header class="header text-center py-5 text-white" style="background-color: #6096B4;">
  <div class="container">
    <h1>Formulir Pendaftaran</h1>
    <p class="lead">Bergabunglah dengan tim Laboratorium Software Engineering.</p>
  </div>
</header>


<main class="container mt-5 mb-5">

  <?php if (isset($_SESSION['status']) && isset($_SESSION['message'])): ?>

    <div class="alert alert-<?= $_SESSION['status']; ?> alert-dismissible fade show" role="alert" id="flash-alert">
      <?= $_SESSION['message']; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", function() {
        var alertElement = document.getElementById('flash-alert');

        if (alertElement) {
          setTimeout(function() {
            var bsAlert = new bootstrap.Alert(alertElement);
            bsAlert.close();
          }, 5000);
        }
      });
    </script>

    <?php
    unset($_SESSION['status']);
    unset($_SESSION['message']);
    ?>

  <?php endif; ?>

  <div class="card card-floating p-4 p-md-5" style="border: none; box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.08); border-radius: 1rem;">
    <form action="recruitment_proses.php" method="POST" enctype="multipart/form-data">

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label fw-semibold">Nama</label>
        <div class="col-sm-10">
          <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label fw-semibold">NIM</label>
        <div class="col-sm-10">
          <input type="text" name="nim" class="form-control" placeholder="Masukkan NIM" required>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label fw-semibold">Prodi</label>
        <div class="col-sm-10">
          <select name="prodi" class="form-select" required>
            <option value="">-- Pilih Prodi --</option>
            <option>D4 - Teknik Informatika</option>
            <option>D4 - Sistem Informasi Bisnis</option>
          </select>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label fw-semibold">Angkatan</label>
        <div class="col-sm-10">
          <input type="text" name="angkatan" class="form-control" placeholder="Masukkan tahun masuk" required>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label fw-semibold">No. Telepon</label>
        <div class="col-sm-10">
          <input type="text" name="no_hp" class="form-control" placeholder="Masukkan nomor telepon aktif" required>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label fw-semibold">Email</label>
        <div class="col-sm-10">
          <input type="email" name="email" class="form-control" placeholder="Masukkan alamat email" required>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label fw-semibold">Alasan Bergabung</label>
        <div class="col-sm-10">
          <textarea name="alasan_bergabung" class="form-control" rows="2" placeholder="Tuliskan alasan kamu ingin bergabung"></textarea>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label fw-semibold">Riwayat Pengalaman</label>
        <div class="col-sm-10">
          <textarea name="riwayat_pengalaman" class="form-control" rows="2" placeholder="Tuliskan pengalamanmu sebelumnya"></textarea>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label fw-semibold">Pas Foto 3x4</label>
        <div class="col-sm-10">
          <input type="file" name="foto" class="form-control" accept=".jpg, .jpeg, .png" required>
          <small class="text-muted">Format: JPG, JPEG, PNG (Max 5MB)</small>
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-sm-2 col-form-label fw-semibold">Portofolio</label>
        <div class="col-sm-10">
          <input type="file" name="portofolio" class="form-control" accept=".pdf, .jpg, .jpeg, .png">
          <small class="text-muted">Format: PDF, JPG, PNG (Max 5MB)</small>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label fw-semibold">CV</label>
        <div class="col-sm-10">
          <input type="file" name="cv" class="form-control" accept=".pdf, .doc, .docx" required>
          <small class="text-muted">Format: PDF, DOC, DOCX (Max 5MB)</small>
        </div>
      </div>

      <hr class="my-4">

      <div class="text-center">
        <button type="submit" class="btn btn-custom-accent btn-lg">Kirim Pendaftaran</button>
      </div>

    </form>
  </div>
</main>


<?php
require_once $root . '/includes/footer.php';
?>

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->