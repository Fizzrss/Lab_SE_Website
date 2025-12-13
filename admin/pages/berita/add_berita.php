<?php
if (!defined('ROOT_PATH')) {
    exit('Direct access not allowed');
}

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$oldInput = isset($_SESSION['old_input']) ? $_SESSION['old_input'] : [];
unset($_SESSION['errors'], $_SESSION['old_input']);
?>

<link rel="stylesheet" href="/Lab_SE_Website/admin/assets/extensions/summernote/summernote-lite.css">
<link rel="stylesheet" href="/Lab_SE_Website/admin/assets/compiled/css/form-editor-summernote.css">

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Berita</h3>
                <p class="text-subtitle text-muted">Buat berita atau artikel baru</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="index.php?action=berita_list">Berita</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Berita</h4>
            </div>
            <div class="card-body">
                <form id="formAddBerita" action="index.php?action=berita_save" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label for="judul" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= isset($errors['judul']) ? 'is-invalid' : '' ?>"
                                    id="judul" name="judul"
                                    value="<?= htmlspecialchars($oldInput['judul'] ?? '') ?>"
                                    placeholder="Masukkan judul berita"
                                    required>
                                <?php if (isset($errors['judul'])): ?>
                                    <div class="invalid-feedback"><?= $errors['judul'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-3">
                                <label for="isi_singkat" class="form-label">Isi Singkat <span class="text-danger">*</span></label>
                                <textarea class="form-control <?= isset($errors['isi_singkat']) ? 'is-invalid' : '' ?>"
                                    id="isi_singkat" name="isi_singkat"
                                    rows="3" placeholder="Ringkasan singkat berita..."
                                    required><?= htmlspecialchars($oldInput['isi_singkat'] ?? '') ?></textarea>
                                <small class="text-muted">Ringkasan singkat yang akan ditampilkan di halaman utama (max 200 karakter)</small>
                                <?php if (isset($errors['isi_singkat'])): ?>
                                    <div class="invalid-feedback"><?= $errors['isi_singkat'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-3">
                                <label for="isi_lengkap" class="form-label">Isi Lengkap <span class="text-danger">*</span></label>
                                <textarea id="summernote" name="isi_lengkap" class="form-control <?= isset($errors['isi_lengkap']) ? 'is-invalid' : '' ?>"><?= htmlspecialchars($oldInput['isi_lengkap'] ?? '') ?></textarea>
                                <?php if (isset($errors['isi_lengkap'])): ?>
                                    <div class="invalid-feedback d-block"><?= $errors['isi_lengkap'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= isset($errors['kategori']) ? 'is-invalid' : '' ?>" 
                                       id="kategori" name="kategori" 
                                       value="<?= htmlspecialchars($oldInput['kategori'] ?? '') ?>" 
                                       list="kategori-list"
                                       required>
                                <datalist id="kategori-list">
                                    <option value="Workshop">
                                    <option value="Artikel Teknis">
                                    <option value="Pengumuman">
                                    <option value="Wawasan">
                                    <option value="Kegiatan">
                                    <option value="Tutorial">
                                </datalist>
                                <small class="text-muted">Pilih atau ketik kategori baru</small>
                                <?php if (isset($errors['kategori'])): ?>
                                    <div class="invalid-feedback"><?= $errors['kategori'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-3">
                                <label for="penulis" class="form-label">Penulis <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= isset($errors['penulis']) ? 'is-invalid' : '' ?>"
                                    id="penulis" name="penulis"
                                    value="<?= htmlspecialchars($oldInput['penulis'] ?? $_SESSION['username'] ?? '') ?>"
                                    required>
                                <?php if (isset($errors['penulis'])): ?>
                                    <div class="invalid-feedback"><?= $errors['penulis'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-3">
                                <label for="tanggal_publikasi" class="form-label">Tanggal Publikasi <span class="text-danger">*</span></label>
                                <input type="date" class="form-control <?= isset($errors['tanggal_publikasi']) ? 'is-invalid' : '' ?>"
                                    id="tanggal_publikasi" name="tanggal_publikasi"
                                    value="<?= htmlspecialchars($oldInput['tanggal_publikasi'] ?? date('Y-m-d')) ?>"
                                    required>
                                <?php if (isset($errors['tanggal_publikasi'])): ?>
                                    <div class="invalid-feedback"><?= $errors['tanggal_publikasi'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <fieldset class="form-group">
                                    <select class="form-select" id="status" name="status">
                                        <option value="draft" <?= ($oldInput['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                                        <option value="published" <?= ($oldInput['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
                                    </select>
                                </fieldset>
                            </div>

                            <div class="form-group mb-3">
                                <label for="gambar" class="form-label">Gambar Utama</label>
                                <input type="file" class="form-control <?= isset($errors['gambar']) ? 'is-invalid' : '' ?>"
                                    id="gambar" name="gambar"
                                    accept="image/jpeg,image/jpg,image/png,image/gif,image/webp">
                                <small class="text-muted d-block mt-1">Format: JPG, PNG, GIF, WEBP (Max 5MB).</small>
                                <?php if (isset($errors['gambar'])): ?>
                                    <div class="invalid-feedback"><?= $errors['gambar'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-3" id="preview-container" style="display: none;">
                                <label class="form-label">Preview Gambar</label>
                                <img id="preview-image" src="" alt="Preview" class="img-fluid rounded" style="width: 100%; height: auto;">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-light-secondary me-1 mb-1" onclick="window.location.href='index.php?action=berita_list'">Batal</button>
                            <button type="submit" class="btn btn-primary me-1 mb-1" id="btnSubmit">Simpan Berita</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script src="/Lab_SE_Website/admin/vendor/jquery/jquery.min.js"></script>
<script src="/Lab_SE_Website/admin/assets/extensions/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/Lab_SE_Website/admin/assets/extensions/summernote/summernote-lite.min.js"></script>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Tulis isi berita lengkap di sini...',
            tabsize: 2,
            height: 350,

            dialogsInBody: true,

            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Inter', 'Merriweather', 'Montserrat', 'Open Sans', 'Poppins', 'Roboto', 'Times New Roman'],
            fontNamesIgnoreCheck: ['Inter', 'Merriweather', 'Montserrat', 'Open Sans', 'Poppins', 'Roboto'],
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        $('#gambar').change(function() {
            const file = this.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire('Error', 'Ukuran gambar maksimal 2MB', 'error');
                    this.value = '';
                    $('#preview-container').hide();
                    return;
                }
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-image').attr('src', e.target.result);
                    $('#preview-container').slideDown();
                }
                reader.readAsDataURL(file);
            }
        });

        $('#formAddBerita').on('submit', function(e) {
            e.preventDefault();

            var form = this;

            Swal.fire({
                title: 'Konfirmasi Simpan',
                text: "Apakah Anda yakin ingin menyimpan berita baru ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#435ebe',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>