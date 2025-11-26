<footer id="footer" class="footer dark-background">

    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-5 col-md-12 footer-about">
            <a href="<?= BASE_URL ?>index.php" class="logo d-flex align-items-center">
              <span class="sitename">Laboratorium Software Engineering</span>
            </a>
            <div class="footer-contact pt-3">
              <p>Gedung Teknik Sipil dan Teknologi Informasi</p>
              <p>Politeknik Negeri Malang, Malang</p>
              <p class="mt-3"><strong>Phone:</strong> <span>+62 341 123456</span></p>
              <p><strong>Email:</strong> <span>lab.se@polinema.ac.id</span></p>
            </div>
          </div>

          <div class="col-lg-2 col-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><a href="<?= BASE_URL ?>index.php">Beranda</a></li>
              <li><a href="<?= BASE_URL ?>pages/tentang.php">Tentang Kami</a></li>
              <li><a href="<?= BASE_URL ?>pages/blog.php">Blog & Berita</a></li>
              <li><a href="<?= BASE_URL ?>pages/recruitment_form.php">Join Us</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-6 footer-links">
            <h4>Layanan Lab</h4>
            <ul>
              <li><a href="#">Riset & Pengembangan</a></li>
              <li><a href="#">Workshop Teknologi</a></li>
              <li><a href="#">Software Testing</a></li>
              <li><a href="#">Konsultasi TI</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
            <h4>Connect With Us</h4>
            <p>Ikuti sosial media kami untuk update terbaru seputar kegiatan lab dan teknologi.</p>
            <div class="social-links mt-3">
                <a href="https://x.com/rippkhace/" target="blank" class="twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="https://www.facebook.com/p/BEM-Politeknik-Negeri-Malang-100069699428621/" target="blank" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="https://instagram.com/rifqihilmim/" target="blank" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="https://linkedin.com/in/desssyys/" target="blank" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="copyright text-center">
      <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

        <div class="d-flex flex-column align-items-center align-items-lg-start">
          <div>
            © Copyright <strong><span>Lab Software Engineering</span></strong>. All Rights Reserved
          </div>
        </div>

      </div>
    </div>

  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <script>
    // Cek apakah library AOS sudah terload
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,    // Durasi animasi (ms)
            easing: 'ease-in-out', // Jenis transisi
            once: true,       // Animasi hanya sekali saat scroll ke bawah
            mirror: false     // Jangan animasi ulang saat scroll ke atas
        });
    }
  </script>

</body>
</html>