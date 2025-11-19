<?php
// Definisikan BASE_URL jika belum ada
if (!defined('BASE_URL')) {
    if (file_exists('../includes/config.php')) {
        require_once '../includes/config.php';
    } else {
        define('BASE_URL', '../');
    }
}

// Set judul halaman
$page_title = "Form Pendaftaran";
$site_title = "Lab SE"; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title><?= htmlspecialchars($page_title ?? '') ?> - <?= htmlspecialchars($site_title ?? '') ?></title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">

</head>
<body style="background-color: #f8f9fa;">

  <?php
    if (file_exists('../includes/navbar.php')) {
        include '../includes/navbar.php';
    }
  ?>

  <section class="page-hero-banner">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <h1>Formulir Pendaftaran</h1>
                  <p>Bergabunglah dengan tim Laboratorium Software Engineering.</p>
              </div>
          </div>
      </div>
  </section>

  <main>
    <div class="container mt-5 mb-5">
      
      <div class="card card-floating p-4 p-md-5" style="border: none; box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.08); border-radius: 1rem;">
        <form action="proses_recruitment.php" method="POST" enctype="multipart/form-data">

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
            <label class="col-sm-2 col-form-label fw-semibold">Tahun Masuk</label>
            <div class="col-sm-10">
              <input type="number" name="tahun_masuk" class="form-control" placeholder="Masukkan tahun masuk" required>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label fw-semibold">Semester</label>
            <div class="col-sm-10">
              <select name="semester" class="form-select" required>
                <option value="">-- Pilih Semester --</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label fw-semibold">No. Telepon</label>
            <div class="col-sm-10">
              <input type="text" name="telepon" class="form-control" placeholder="Masukkan nomor telepon aktif" required>
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
              <textarea name="alasan" class="form-control" rows="2" placeholder="Tuliskan alasan kamu ingin bergabung"></textarea>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label fw-semibold">Riwayat Pengalaman</label>
            <div class="col-sm-10">
              <textarea name="pengalaman" class="form-control" rows="2" placeholder="Tuliskan pengalamanmu sebelumnya"></textarea>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label fw-semibold">Portofolio</label>
            <div class="col-sm-10">
              <input type="file" name="portofolio" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label fw-semibold">CV</label>
            <div class="col-sm-10">
              <input type="file" name="cv" class="form-control">
            </div>
          </div>

          <hr class="my-4">

          <div class="text-center">
            <button type="submit" class="btn btn-custom-accent btn-lg">Kirim Pendaftaran</button>
          </div>

        </form>
      </div>
    </div>
  </main>

  <?php
    if (file_exists('../includes/footer.php')) {
        include '../includes/footer.php';
    }
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>