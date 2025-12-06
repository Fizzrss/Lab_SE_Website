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
                <form action="index.php?action=profil_hero_update" method="POST">
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
                            <input type="text" class="form-control" id="hero_background_image" name="hero_background_image" 
                                   value="<?= htmlspecialchars($heroBgImage) ?>" 
                                   placeholder="assets/img/bg_web.webp">
                            <small class="text-muted">Path relatif dari root website</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hero_button_text" class="form-label">Teks Tombol</label>
                            <input type="text" class="form-control" id="hero_button_text" name="hero_button_text" 
                                   value="<?= htmlspecialchars($heroButtonText) ?>" 
                                   placeholder="Get Started" required>
                            <small class="text-muted">Teks yang akan ditampilkan pada tombol</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hero_button_link" class="form-label">Link Tombol</label>
                            <input type="text" class="form-control" id="hero_button_link" name="hero_button_link" 
                                   value="<?= htmlspecialchars($heroButtonLink) ?>" 
                                   placeholder="#profil" required>
                            <small class="text-muted">Link/tujuan ketika tombol diklik (contoh: #profil, /pages/berita.php, dll)</small>
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
                <form action="index.php?action=profil_section_update" method="POST">
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
                            <label class="form-label">Gambar Carousel (satu per baris, path relatif)</label>
                            <textarea class="form-control" name="tentang_images" rows="5" 
                                      placeholder="assets/img/bg_web.webp&#10;assets/img/background.jpeg&#10;assets/img/lab2.jpeg"><?php
                                if (isset($tentangData['images']) && is_array($tentangData['images'])) {
                                    echo htmlspecialchars(implode("\n", $tentangData['images']));
                                }
                            ?></textarea>
                            <small class="text-muted">Satu gambar per baris</small>
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
                            <textarea class="form-control" name="misi_items" rows="6" required><?php
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
                            <textarea class="form-control" name="fokus_riset" rows="4"><?php
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

<script>
// Helper functions to prepare form data as JSON before submit
function prepareTentangForm(e) {
    e.preventDefault();
    const form = e.target.closest('form');
    const description = form.querySelector('[name="tentang_description"]').value;
    const imagesText = form.querySelector('[name="tentang_images"]').value;
    const images = imagesText.split('\n').filter(img => img.trim() !== '').map(img => img.trim());
    
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

function prepareRoadmapForm(e) {
    e.preventDefault();
    const form = e.target.closest('form');
    const items = [];
    
    form.querySelectorAll('.roadmap-item').forEach(item => {
        const year = item.querySelector('.roadmap-year').value;
        const desc = item.querySelector('.roadmap-desc').value;
        if (year && desc) {
            items.push({ year: year, description: desc });
        }
    });
    
    const content = {
        title: form.querySelector('[name="section_title"]').value,
        items: items
    };
    
    form.querySelector('#roadmap_content_json').value = JSON.stringify(content);
    form.submit();
}

function prepareFocusScopeForm(e) {
    e.preventDefault();
    const form = e.target.closest('form');
    const fokusRisetText = form.querySelector('[name="fokus_riset"]').value;
    const fokusRiset = fokusRisetText.split('\n').filter(f => f.trim() !== '').map(f => f.trim());
    
    const lingkupItems = [];
    form.querySelectorAll('.lingkup-item').forEach(item => {
        const icon = item.querySelector('.lingkup-icon').value;
        const judul = item.querySelector('.lingkup-judul').value;
        const desc = item.querySelector('.lingkup-desc').value;
        if (judul && desc) {
            lingkupItems.push({
                icon: icon || 'bi-circle',
                judul: judul,
                desc: desc
            });
        }
    });
    
    const content = {
        title: form.querySelector('[name="section_title"]').value,
        subtitle: form.querySelector('[name="focus_subtitle"]').value || '',
        fokus_riset: fokusRiset,
        lingkup_detail: lingkupItems
    };
    
    form.querySelector('#focus_scope_content_json').value = JSON.stringify(content);
    form.submit();
}

// Add/Remove roadmap items
function addRoadmapItem() {
    const container = document.getElementById('roadmap_items');
    const item = document.createElement('div');
    item.className = 'roadmap-item mb-3 p-3 border rounded';
    item.innerHTML = `
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">Tahun</label>
                <input type="text" class="form-control roadmap-year" required>
            </div>
            <div class="col-md-9">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control roadmap-desc" rows="2" required></textarea>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeRoadmapItem(this)">
            <i class="bi bi-trash"></i> Hapus
        </button>
    `;
    container.appendChild(item);
}

function removeRoadmapItem(btn) {
    btn.closest('.roadmap-item').remove();
}

// Add/Remove lingkup items
function addLingkupItem() {
    const container = document.getElementById('lingkup_items');
    const item = document.createElement('div');
    item.className = 'lingkup-item mb-3 p-3 border rounded';
    item.innerHTML = `
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">Icon</label>
                <input type="text" class="form-control lingkup-icon" 
                       value="bi-circle" placeholder="bi-diagram-3">
            </div>
            <div class="col-md-3">
                <label class="form-label">Judul</label>
                <input type="text" class="form-control lingkup-judul" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control lingkup-desc" rows="2" required></textarea>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeLingkupItem(this)">
            <i class="bi bi-trash"></i> Hapus
        </button>
    `;
    container.appendChild(item);
}

function removeLingkupItem(btn) {
    btn.closest('.lingkup-item').remove();
}

// Update section status (for future implementation)
function updateSectionStatus(sectionKey, isActive) {
    // This can be implemented later with AJAX if needed
    console.log(`Section ${sectionKey} status: ${isActive}`);
}
</script>

