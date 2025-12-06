<?php
if (!defined('ROOT_PATH')) {
    exit('Direct access not allowed');
}

// Default values
$footerAboutTitle = $settings['footer_about_title'] ?? 'Laboratorium Software Engineering';
$footerAboutAddress = $settings['footer_about_address'] ?? '';
$footerAboutPhone = $settings['footer_about_phone'] ?? '+62 341 123456';
$footerAboutEmail = $settings['footer_about_email'] ?? 'lab.se@polinema.ac.id';
$footerLinksTitle = $settings['footer_links_title'] ?? 'Useful Links';
$footerSocialTitle = $settings['footer_social_title'] ?? 'Connect With Us';
$footerSocialDescription = $settings['footer_social_description'] ?? 'Ikuti sosial media kami untuk update terbaru seputar kegiatan lab dan teknologi.';
$footerCopyright = $settings['footer_copyright'] ?? '© Copyright Lab Software Engineering. All Rights Reserved';

// Get selected links
$selectedLinksJson = $settings['footer_links'] ?? '[]';
$selectedLinkIds = json_decode($selectedLinksJson, true);
if (!is_array($selectedLinkIds)) {
    $selectedLinkIds = [];
}

// Get social media settings
$socialMediaJson = $settings['footer_social_media'] ?? '[]';
$socialMediaData = json_decode($socialMediaJson, true);
if (!is_array($socialMediaData)) {
    $socialMediaData = [];
}

// Create map for easy lookup
$socialMediaMap = [];
foreach ($socialMediaData as $item) {
    $socialMediaMap[$item['platform']] = $item;
}

// Available platforms
$availablePlatforms = [
    'facebook' => ['name' => 'Facebook', 'icon' => 'bi-facebook'],
    'twitter' => ['name' => 'Twitter/X', 'icon' => 'bi-twitter-x'],
    'instagram' => ['name' => 'Instagram', 'icon' => 'bi-instagram'],
    'linkedin' => ['name' => 'LinkedIn', 'icon' => 'bi-linkedin'],
    'youtube' => ['name' => 'YouTube', 'icon' => 'bi-youtube'],
    'tiktok' => ['name' => 'TikTok', 'icon' => 'bi-tiktok'],
    'whatsapp' => ['name' => 'WhatsApp', 'icon' => 'bi-whatsapp'],
    'telegram' => ['name' => 'Telegram', 'icon' => 'bi-telegram']
];
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pengaturan Footer</h3>
                <p class="text-subtitle text-muted">Kelola konten dan tampilan footer website</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pengaturan Footer</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <?php echo getFlashMessage(); ?>

    <section class="section">
        <form action="index.php?action=footer_update" method="POST">
            
            <!-- About Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Bagian About</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="footer_about_title" class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="footer_about_title" name="footer_about_title" 
                                   value="<?= htmlspecialchars($footerAboutTitle) ?>" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="footer_about_address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="footer_about_address" name="footer_about_address" 
                                      rows="3"><?= htmlspecialchars($footerAboutAddress) ?></textarea>
                            <small class="text-muted">Gunakan baris baru untuk alamat yang lebih panjang</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="footer_about_phone" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="footer_about_phone" name="footer_about_phone" 
                                   value="<?= htmlspecialchars($footerAboutPhone) ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="footer_about_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="footer_about_email" name="footer_about_email" 
                                   value="<?= htmlspecialchars($footerAboutEmail) ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Links Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Bagian Useful Links</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="footer_links_title" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="footer_links_title" name="footer_links_title" 
                                   value="<?= htmlspecialchars($footerLinksTitle) ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Pilih Halaman yang Ditampilkan</label>
                            <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                <?php foreach ($availablePages as $page): ?>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" 
                                               name="footer_links[]" 
                                               value="<?= $page['id'] ?>" 
                                               id="page_<?= $page['id'] ?>"
                                               <?= in_array($page['id'], $selectedLinkIds) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="page_<?= $page['id'] ?>">
                                            <strong><?= htmlspecialchars($page['page_title']) ?></strong>
                                            <small class="text-muted d-block"><?= htmlspecialchars($page['page_url']) ?></small>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <small class="text-muted">Centang halaman yang ingin ditampilkan di footer</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Bagian Connect With Us</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="footer_social_title" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="footer_social_title" name="footer_social_title" 
                                   value="<?= htmlspecialchars($footerSocialTitle) ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="footer_social_description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="footer_social_description" name="footer_social_description" 
                                      rows="2"><?= htmlspecialchars($footerSocialDescription) ?></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Media Sosial</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="50">Aktif</th>
                                            <th>Platform</th>
                                            <th>URL/Link</th>
                                            <th width="80">Urutan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($availablePlatforms as $platformKey => $platform): 
                                            $platformData = $socialMediaMap[$platformKey] ?? null;
                                            $enabled = $platformData && isset($platformData['enabled']) ? $platformData['enabled'] : false;
                                            $url = $platformData && isset($platformData['url']) ? $platformData['url'] : '';
                                            $order = $platformData && isset($platformData['order']) ? $platformData['order'] : 0;
                                        ?>
                                            <tr>
                                                <td class="text-center">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" 
                                                               name="social_media[<?= $platformKey ?>][enabled]" 
                                                               value="1"
                                                               id="social_<?= $platformKey ?>"
                                                               <?= $enabled ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="social_<?= $platformKey ?>"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <i class="bi <?= $platform['icon'] ?> me-2"></i>
                                                    <strong><?= $platform['name'] ?></strong>
                                                </td>
                                                <td>
                                                    <input type="url" 
                                                           class="form-control form-control-sm" 
                                                           name="social_media[<?= $platformKey ?>][url]" 
                                                           value="<?= htmlspecialchars($url) ?>"
                                                           placeholder="https://...">
                                                </td>
                                                <td>
                                                    <input type="number" 
                                                           class="form-control form-control-sm" 
                                                           name="social_media[<?= $platformKey ?>][order]" 
                                                           value="<?= $order ?>"
                                                           min="0">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted">Centang platform yang ingin ditampilkan dan isi URL/link-nya. Urutan menentukan urutan tampil.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Bagian Copyright</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="footer_copyright" class="form-label">Teks Copyright</label>
                            <input type="text" class="form-control" id="footer_copyright" name="footer_copyright" 
                                   value="<?= htmlspecialchars($footerCopyright) ?>">
                            <small class="text-muted">Contoh: © Copyright Lab Software Engineering. All Rights Reserved</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Simpan Pengaturan
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </a>
                </div>
            </div>

        </form>
    </section>
</div>

