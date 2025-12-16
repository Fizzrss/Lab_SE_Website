<?php
if (!defined('ROOT_PATH')) {
    exit('Direct access not allowed');
}

// Organize sections by key
$sectionsByKey = [];
foreach ($sections as $section) {
    $sectionsByKey[$section['section_key']] = $section;
}

// Hero settings
$heroTitle = $heroSettings['hero_title'] ?? 'Laboratorium Software Engineering';
$heroSubtitle = $heroSettings['hero_subtitle'] ?? 'Politeknik Negeri Malang';
$heroDescription = $heroSettings['hero_description'] ?? 'Mengembangkan inovasi teknologi untuk masa depan yang lebih cerdas.';
$heroBgImage = $heroSettings['hero_background_image'] ?? 'assets/img/bg_web.webp';
$heroButtonText = $heroSettings['hero_button_text'] ?? 'Get Started';
$heroButtonLink = $heroSettings['hero_button_link'] ?? '#profil';
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pengaturan Profil & Beranda</h3>
                <p class="text-subtitle text-muted">Kelola konten halaman beranda dan profil</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pengaturan Profil</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <?php echo getFlashMessage(); ?>

    <section class="section">
        <!-- Hero Section Settings -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Hero Section (Beranda)</h5>
            </div>
            <div class="card-body">
                <form action="index.php?action=profil_hero_update" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="hero_title" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="hero_title" name="hero_title"
                                value="<?= htmlspecialchars($heroTitle) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hero_subtitle" class="form-label">Subjudul</label>
                            <input type="text" class="form-control" id="hero_subtitle" name="hero_subtitle"
                                value="<?= htmlspecialchars($heroSubtitle) ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="hero_description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="hero_description" name="hero_description"
                                rows="2"><?= htmlspecialchars($heroDescription) ?></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="hero_background_image" class="form-label">Gambar Background</label>

                            <div class="mb-2">
                                <?php
                                $displayHeroImage = $heroBgImage;
                                if (!empty($displayHeroImage) && !preg_match("~^(?:f|ht)tps?://~i", $displayHeroImage)) {
                                    $displayHeroImage = '../' . $displayHeroImage;
                                }
                                ?>
                                <img id="hero_preview"
                                    src="<?= htmlspecialchars($displayHeroImage) ?>"
                                    alt="Preview Hero"
                                    class="img-fluid"
                                    style="max-height: 200px; object-fit: cover;"
                                    onerror="this.src='https://placehold.co/600x400?text=Gambar+Rusak'">
                            </div>

                            <input type="file" class="form-control" id="hero_background_image"
                                name="hero_background_image" accept="image/*"
                                onchange="previewImage(this, 'hero_preview')">

                            <input type="hidden" name="old_hero_background_image" value="<?= htmlspecialchars($heroBgImage) ?>">

                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar. Max 2MB.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hero_button_text" class="form-label">Teks Tombol</label>
                            <input type="text" class="form-control" id="hero_button_text" name="hero_button_text"
                                value="<?= htmlspecialchars($heroButtonText) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hero_button_link" class="form-label">Link Tombol</label>
                            <input type="text" class="form-control" id="hero_button_link" name="hero_button_link"
                                value="<?= htmlspecialchars($heroButtonLink) ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Simpan Hero
                    </button>
                </form>
            </div>
        </div>

        <!-- Tentang Section -->
        <?php
        $tentang = $sectionsByKey['tentang'] ?? null;
        if ($tentang):
            $tentangData = $tentang['content_data'] ?? [];
        ?>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Section: Tentang Kami</h5>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox"
                            id="tentang_active"
                            <?= $tentang['is_active'] ? 'checked' : '' ?>
                            onchange="updateSectionStatus('tentang', this.checked)">
                        <label class="form-check-label" for="tentang_active">Aktif</label>
                    </div>
                </div>
                <div class="card-body">
                    <form action="index.php?action=profil_section_update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="section_key" value="tentang">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" class="form-control" name="section_title"
                                    value="<?= htmlspecialchars($tentang['section_title'] ?? 'Tentang Kami') ?>" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="tentang_description" rows="4" required><?= htmlspecialchars($tentangData['description'] ?? '') ?></textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Gambar Carousel</label>

                                <div class="d-flex flex-wrap gap-2 mb-2">
                                    <?php if (isset($tentangData['images']) && is_array($tentangData['images'])): ?>
                                        <?php foreach ($tentangData['images'] as $img): ?>
                                            <?php
                                            $displayImg = $img;
                                            if (!empty($displayImg) && !preg_match("~^(?:f|ht)tps?://~i", $displayImg)) {
                                                $displayImg = '../' . $displayImg;
                                            }
                                            ?>
                                            <div class="position-relative text-center" style="width: 100px;">
                                                <img src="<?= htmlspecialchars($displayImg) ?>"
                                                    class="img-thumbnail mb-1"
                                                    style="width: 100px; height: 80px; object-fit: cover;">

                                                <input type="hidden" name="existing_images[]" value="<?= htmlspecialchars($img) ?>">

                                                <button type="button" class="btn btn-danger btn-sm w-100 py-0" style="font-size: 0.7rem;" onclick="this.parentElement.remove()">Hapus</button>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <label class="form-label"><small>Upload Gambar Baru (Bisa pilih banyak sekaligus)</small></label>
                                <input type="file" class="form-control" name="tentang_images_new[]" multiple accept="image/*">
                                <small class="text-muted">Gambar baru akan ditambahkan ke daftar gambar yang sudah ada.</small>
                            </div>
                            <input type="hidden" name="section_content" id="tentang_content_json">
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="prepareTentangForm(event)">
                            <i class="bi bi-save me-2"></i>Simpan Tentang
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Visi Misi Section -->
        <?php
        $visiMisi = $sectionsByKey['visi_misi'] ?? null;
        if ($visiMisi):
            $visiMisiData = $visiMisi['content_data'] ?? [];
        ?>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Section: Visi & Misi</h5>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox"
                            id="visi_misi_active"
                            <?= $visiMisi['is_active'] ? 'checked' : '' ?>
                            onchange="updateSectionStatus('visi_misi', this.checked)">
                        <label class="form-check-label" for="visi_misi_active">Aktif</label>
                    </div>
                </div>
                <div class="card-body">
                    <form action="index.php?action=profil_section_update" method="POST">
                        <input type="hidden" name="section_key" value="visi_misi">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" class="form-control" name="section_title"
                                    value="<?= htmlspecialchars($visiMisi['section_title'] ?? 'Visi & Misi') ?>" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Visi</label>
                                <textarea class="form-control" name="visi_text" rows="3" required><?= htmlspecialchars($visiMisiData['visi'] ?? '') ?></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Misi (satu per baris)</label>
                                <textarea class="form-control" name="misi_items" rows="6" required>
                                <?php
                                if (isset($visiMisiData['misi']) && is_array($visiMisiData['misi'])) {
                                    echo htmlspecialchars(implode("\n", $visiMisiData['misi']));
                                }
                                ?></textarea>
                                <small class="text-muted">Satu misi per baris</small>
                            </div>
                            <input type="hidden" name="section_content" id="visi_misi_content_json">
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="prepareVisiMisiForm(event)">
                            <i class="bi bi-save me-2"></i>Simpan Visi & Misi
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Roadmap Section -->
        <?php
        $roadmap = $sectionsByKey['roadmap'] ?? null;
        if ($roadmap):
            $roadmapData = $roadmap['content_data'] ?? [];
        ?>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Section: Roadmap</h5>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox"
                            id="roadmap_active"
                            <?= $roadmap['is_active'] ? 'checked' : '' ?>
                            onchange="updateSectionStatus('roadmap', this.checked)">
                        <label class="form-check-label" for="roadmap_active">Aktif</label>
                    </div>
                </div>
                <div class="card-body">
                    <form action="index.php?action=profil_section_update" method="POST">
                        <input type="hidden" name="section_key" value="roadmap">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" class="form-control" name="section_title"
                                    value="<?= htmlspecialchars($roadmap['section_title'] ?? 'Roadmap') ?>" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Roadmap Items</label>
                                <div id="roadmap_items">
                                    <?php if (isset($roadmapData['items']) && is_array($roadmapData['items'])): ?>
                                        <?php foreach ($roadmapData['items'] as $index => $item): ?>
                                            <div class="roadmap-item mb-3 p-3 border rounded">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Tahun</label>
                                                        <input type="text" class="form-control roadmap-year"
                                                            value="<?= htmlspecialchars($item['year'] ?? '') ?>" required>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <label class="form-label">Deskripsi</label>
                                                        <textarea class="form-control roadmap-desc" rows="2" required><?= htmlspecialchars($item['description'] ?? '') ?></textarea>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeRoadmapItem(this)">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addRoadmapItem()">
                                    <i class="bi bi-plus"></i> Tambah Item
                                </button>
                            </div>
                            <input type="hidden" name="section_content" id="roadmap_content_json">
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="prepareRoadmapForm(event)">
                            <i class="bi bi-save me-2"></i>Simpan Roadmap
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Focus & Scope Section -->
        <?php
        $focusScope = $sectionsByKey['focus_scope'] ?? null;
        if ($focusScope):
            $focusScopeData = $focusScope['content_data'] ?? [];
        ?>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Section: Focus & Scope</h5>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox"
                            id="focus_scope_active"
                            <?= $focusScope['is_active'] ? 'checked' : '' ?>
                            onchange="updateSectionStatus('focus_scope', this.checked)">
                        <label class="form-check-label" for="focus_scope_active">Aktif</label>
                    </div>
                </div>
                <div class="card-body">
                    <form action="index.php?action=profil_section_update" method="POST">
                        <input type="hidden" name="section_key" value="focus_scope">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" class="form-control" name="section_title"
                                    value="<?= htmlspecialchars($focusScope['section_title'] ?? 'Focus & Scope') ?>" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Subtitle</label>
                                <input type="text" class="form-control" name="focus_subtitle"
                                    value="<?= htmlspecialchars($focusScopeData['subtitle'] ?? '') ?>">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Fokus Riset (satu per baris)</label>
                                <textarea class="form-control" name="fokus_riset" rows="4">
                                <?php
                                if (isset($focusScopeData['fokus_riset']) && is_array($focusScopeData['fokus_riset'])) {
                                    echo htmlspecialchars(implode("\n", $focusScopeData['fokus_riset']));
                                }
                                ?></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Lingkup Detail</label>
                                <div id="lingkup_items">
                                    <?php if (isset($focusScopeData['lingkup_detail']) && is_array($focusScopeData['lingkup_detail'])): ?>
                                        <?php foreach ($focusScopeData['lingkup_detail'] as $index => $item): ?>
                                            <div class="lingkup-item mb-3 p-3 border rounded">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Icon (Bootstrap Icons)</label>
                                                        <input type="text" class="form-control lingkup-icon"
                                                            value="<?= htmlspecialchars($item['icon'] ?? 'bi-circle') ?>"
                                                            placeholder="bi-diagram-3">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Judul</label>
                                                        <input type="text" class="form-control lingkup-judul"
                                                            value="<?= htmlspecialchars($item['judul'] ?? '') ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Deskripsi</label>
                                                        <textarea class="form-control lingkup-desc" rows="2" required><?= htmlspecialchars($item['desc'] ?? '') ?></textarea>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeLingkupItem(this)">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addLingkupItem()">
                                    <i class="bi bi-plus"></i> Tambah Item
                                </button>
                            </div>
                            <input type="hidden" name="section_content" id="focus_scope_content_json">
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="prepareFocusScopeForm(event)">
                            <i class="bi bi-save me-2"></i>Simpan Focus & Scope
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>

<script src="/Lab_SE_Website/admin/vendor/jquery/jquery.min.js"></script>
<script src="/Lab_SE_Website/admin/assets/extensions/sweetalert2/sweetalert2.all.min.js"></script>
</script>
<script>
    <?php if (isset($_SESSION['swal_icon'])): ?>
        Swal.fire({
            icon: '<?= $_SESSION['swal_icon']; ?>',
            title: '<?= $_SESSION['swal_title']; ?>',
            text: '<?= $_SESSION['swal_text']; ?>',
            showConfirmButton: true,
            timer: 2500
        });
        <?php
        unset($_SESSION['swal_icon']);
        unset($_SESSION['swal_title']);
        unset($_SESSION['swal_text']);
        ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['swal_warning'])): ?>
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: '<?= $_SESSION['swal_warning']; ?>'
        });
        <?php unset($_SESSION['swal_warning']); ?>
    <?php endif; ?>

    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function prepareTentangForm(e) {
        e.preventDefault();
        const form = e.target.closest('form');

        const description = form.querySelector('[name="tentang_description"]').value;

        const existingImagesInputs = form.querySelectorAll('input[name="existing_images[]"]');
        let images = [];
        existingImagesInputs.forEach(input => {
            if (input.value.trim() !== "") {
                images.push(input.value);
            }
        });

        const content = {
            title: form.querySelector('[name="section_title"]').value,
            description: description,
            images: images
        };

        form.querySelector('#tentang_content_json').value = JSON.stringify(content);

        form.submit();
    }

    function prepareVisiMisiForm(e) {
        e.preventDefault();
        const form = e.target.closest('form');
        const visi = form.querySelector('[name="visi_text"]').value;
        const misiText = form.querySelector('[name="misi_items"]').value;
        const misi = misiText.split('\n').filter(m => m.trim() !== '').map(m => m.trim());

        const content = {
            title: form.querySelector('[name="section_title"]').value,
            visi: visi,
            misi: misi
        };

        form.querySelector('#visi_misi_content_json').value = JSON.stringify(content);
        form.submit();
    }

    function updateSectionStatus(key, status) {
        var isActive = status ? 1 : 0;

        $.ajax({
            url: 'index.php?action=profil_section_status_update',
            type: 'POST',
            data: {
                section_key: key,
                is_active: isActive
            },
            success: function(response) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Status berhasil diperbarui'
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Gagal memperbarui status. Periksa koneksi atau server.'
                });
                // Kembalikan status checkbox ke posisi semula
                var checkbox = document.getElementById(key + '_active');
                checkbox.checked = !status;
            }
        });
    }
</script>