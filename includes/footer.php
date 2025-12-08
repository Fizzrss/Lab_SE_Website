<?php
// Load footer settings
// BASE_URL should already be defined by the calling page
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/Lab_SE_Website/');
}

// Determine base path based on where footer is called from
$footerPath = __DIR__;
if (strpos($footerPath, 'includes') !== false) {
    require_once $footerPath . '/../config/config.php';
    require_once $footerPath . '/../models/FooterSettings.php';
} else {
    require_once __DIR__ . '/config/config.php';
    require_once __DIR__ . '/models/FooterSettings.php';
}

try {
    $database = new Database();
    $db = $database->getConnection();
    $footerModel = new FooterSettingsModel($db);
} catch (Exception $e) {
    // Fallback if database fails
    $footerModel = null;
}

// Get footer data
if ($footerModel) {
    $footerAboutTitle = $footerModel->getSetting('footer_about_title', 'Laboratorium Software Engineering');
    $footerAboutAddress = $footerModel->getSetting('footer_about_address', 'Gedung Teknik Sipil dan Teknologi Informasi\nPoliteknik Negeri Malang, Malang');
    $footerAboutPhone = $footerModel->getSetting('footer_about_phone', '+62 341 123456');
    $footerAboutEmail = $footerModel->getSetting('footer_about_email', 'lab.se@polinema.ac.id');

    $footerLinksTitle = $footerModel->getSetting('footer_links_title', 'Useful Links');
    $footerLinks = $footerModel->getFooterLinks();

    $footerSocialTitle = $footerModel->getSetting('footer_social_title', 'Connect With Us');
    $footerSocialDescription = $footerModel->getSetting('footer_social_description', 'Ikuti sosial media kami untuk update terbaru seputar kegiatan lab dan teknologi.');
    $footerSocialMedia = $footerModel->getFooterSocialMedia();

    $footerCopyright = $footerModel->getSetting('footer_copyright', '© Copyright Lab Software Engineering. All Rights Reserved');
} else {
    // Fallback values
    $footerAboutTitle = 'Laboratorium Software Engineering';
    $footerAboutAddress = "Gedung Teknik Sipil dan Teknologi Informasi\nPoliteknik Negeri Malang, Malang";
    $footerAboutPhone = '+62 341 123456';
    $footerAboutEmail = 'lab.se@polinema.ac.id';
    $footerLinksTitle = 'Useful Links';
    $footerLinks = [];
    $footerSocialTitle = 'Connect With Us';
    $footerSocialDescription = 'Ikuti sosial media kami untuk update terbaru seputar kegiatan lab dan teknologi.';
    $footerSocialMedia = [];
    $footerCopyright = '© Copyright Lab Software Engineering. All Rights Reserved';
}

// Platform icons mapping
$platformIcons = [
    'facebook' => 'bi-facebook',
    'twitter' => 'bi-twitter-x',
    'instagram' => 'bi-instagram',
    'linkedin' => 'bi-linkedin',
    'youtube' => 'bi-youtube',
    'tiktok' => 'bi-tiktok',
    'whatsapp' => 'bi-whatsapp',
    'telegram' => 'bi-telegram'
];

// Parse address (split by newline - handle both \n and actual newlines)
$addressLines = preg_split('/\r\n|\r|\n/', $footerAboutAddress);
if (count($addressLines) === 1 && strpos($footerAboutAddress, '\\n') !== false) {
    $addressLines = explode('\\n', $footerAboutAddress);
}
?>

<footer id="footer" class="footer dark-background">

    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-5 col-md-12 footer-about">
            <a href="<?= BASE_URL ?>index.php" class="logo d-flex align-items-center">
              <span class="sitename"><?= htmlspecialchars($footerAboutTitle) ?></span>
            </a>
            <div class="footer-contact pt-3">
              <?php foreach ($addressLines as $line): ?>
                <?php if (!empty(trim($line))): ?>
                  <p><?= htmlspecialchars(trim($line)) ?></p>
                <?php endif; ?>
              <?php endforeach; ?>
              <?php if (!empty($footerAboutPhone)): ?>
                <p class="mt-3"><strong>Phone:</strong> <span><?= htmlspecialchars($footerAboutPhone) ?></span></p>
              <?php endif; ?>
              <?php if (!empty($footerAboutEmail)): ?>
                <p><strong>Email:</strong> <span><?= htmlspecialchars($footerAboutEmail) ?></span></p>
              <?php endif; ?>
            </div>
          </div>

          <?php if (!empty($footerLinks)): ?>
          <div class="col-lg-3 col-md-6 footer-links text-center text-md-start">
            <h4><?= htmlspecialchars($footerLinksTitle) ?></h4>
            <ul>
              <?php foreach ($footerLinks as $link): ?>
                <li><a href="<?= BASE_URL . htmlspecialchars($link['page_url']) ?>"><?= htmlspecialchars($link['page_title']) ?></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <div class="<?= !empty($footerLinks) ? 'col-lg-4' : 'col-lg-7' ?> col-md-12 footer-contact text-center text-md-start">
            <h4><?= htmlspecialchars($footerSocialTitle) ?></h4>
            <?php if (!empty($footerSocialDescription)): ?>
              <p><?= htmlspecialchars($footerSocialDescription) ?></p>
            <?php endif; ?>
            <?php if (!empty($footerSocialMedia)): ?>
              <div class="social-links mt-3">
                <?php foreach ($footerSocialMedia as $social): 
                    $icon = $platformIcons[$social['platform']] ?? 'bi-circle';
                ?>
                  <a href="<?= htmlspecialchars($social['url']) ?>" target="_blank" class="<?= $social['platform'] ?>">
                    <i class="bi <?= $icon ?>"></i>
                  </a>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>

        </div>
      </div>
    </div>

    <div class="copyright text-center">
      <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">
        <div class="d-flex flex-column align-items-center align-items-lg-start">
          <div>
            <?= htmlspecialchars($footerCopyright) ?>
          </div>
        </div>
      </div>
    </div>

  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/@srexi/purecounterjs/dist/purecounter_vanilla.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <script>
    // 1. Inisialisasi AOS (Animasi Scroll)
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 800, easing: 'ease-in-out', once: true, mirror: false });
    }

    // 2. Inisialisasi PureCounter (Animasi Angka)
    if (typeof PureCounter !== 'undefined') {
        new PureCounter();
    } else {
        console.error("PureCounter library not loaded!");
    }

    // 3. Inisialisasi GLightbox (Popup Gambar)
    if (typeof GLightbox !== 'undefined') {
        const lightbox = GLightbox({ selector: '.glightbox' });
    }
  </script>

</body>
</html>