<?php
if (!defined('ROOT_PATH')) {
    exit('Direct access not allowed');
}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pengaturan Hero Banner Berita</h3>
                <p class="text-subtitle text-muted">Kelola tampilan hero banner di halaman berita</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="index.php?action=berita_list">Berita</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Hero Banner</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <?php echo getFlashMessage(); ?>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Hero Banner Settings</h5>
            </div>
            <div class="card-body">
                <form action="index.php?action=berita_hero_update" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="hero_badge" class="form-label">Badge Text</label>
                            <input type="text" class="form-control" id="hero_badge" name="hero_badge" 
                                   value="<?= htmlspecialchars($heroBadge) ?>" required>
                            <small class="text-muted">Text yang muncul di badge (contoh: "News & Updates")</small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="hero_title" class="form-label">Judul Hero</label>
                            <input type="text" class="form-control" id="hero_title" name="hero_title" 
                                   value="<?= htmlspecialchars($heroTitle) ?>" required>
                            <small class="text-muted">Judul utama di hero banner</small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="hero_description" class="form-label">Deskripsi Hero</label>
                            <textarea class="form-control" id="hero_description" name="hero_description" 
                                      rows="3" required><?= htmlspecialchars($heroDescription) ?></textarea>
                            <small class="text-muted">Deskripsi yang muncul di bawah judul</small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="hero_background_image" class="form-label">Background Image URL</label>
                            <input type="text" class="form-control" id="hero_background_image" name="hero_background_image" 
                                   value="<?= htmlspecialchars($heroBackgroundImage) ?>" required>
                            <small class="text-muted">URL atau path ke gambar background (contoh: ../assets/img/lab1.jpg)</small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="hero_background_image_file" class="form-label">Atau Upload Gambar Baru</label>
                            <input type="file" class="form-control" id="hero_background_image_file" name="hero_background_image_file" 
                                   accept="image/*">
                            <small class="text-muted">Jika diisi, akan menggantikan URL di atas</small>
                        </div>

                        <?php if ($heroBackgroundImage && file_exists(__DIR__ . '/../../' . $heroBackgroundImage)): ?>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Preview Gambar Saat Ini</label>
                            <div>
                                <img src="<?= htmlspecialchars($heroBackgroundImage) ?>" 
                                     alt="Current Background" 
                                     style="max-width: 100%; max-height: 300px; border-radius: 8px; border: 1px solid #ddd;">
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="index.php?action=berita_list" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

