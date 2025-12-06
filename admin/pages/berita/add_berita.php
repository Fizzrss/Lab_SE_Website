<?php
if (!defined('ROOT_PATH')) {
    exit('Direct access not allowed');
}

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$oldInput = isset($_SESSION['old_input']) ? $_SESSION['old_input'] : [];
unset($_SESSION['errors'], $_SESSION['old_input']);

// Flag untuk load Summernote
$_SESSION['load_summernote'] = true;
?>

<!-- Summernote CSS -->
<link rel="stylesheet" href="/Lab_SE_Website/admin/assets/extensions/summernote/summernote-bs5.min.css">

<style>
/* Fix Summernote styling issues */
.note-editor.note-frame {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}

.note-editor.note-frame.fullscreen {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    z-index: 99999 !important;
    border-radius: 0;
    margin: 0 !important;
}

body.note-fullscreen {
    overflow: hidden !important;
}

body.note-fullscreen .note-editor.note-frame.fullscreen {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    z-index: 99999 !important;
}

.note-popover {
    z-index: 10000;
}

.note-color-palette {
    display: flex;
    flex-wrap: wrap;
}

.note-color-palette button {
    width: 20px;
    height: 20px;
    border: 1px solid #ddd;
    margin: 2px;
    cursor: pointer;
}

.note-color-palette .note-color-btn-group {
    display: flex;
    flex-wrap: wrap;
}

.note-color-palette .note-color-select {
    display: block;
    width: 100%;
    margin-top: 5px;
}

/* Fix dropdown z-index */
.note-dropdown-menu {
    z-index: 10001 !important;
}

/* Fix table popover */
.note-popover.popover {
    z-index: 10002 !important;
}

/* Fix color picker */
.note-color-palette {
    min-width: 200px;
}

.note-color-palette button.note-color-btn {
    width: 20px;
    height: 20px;
    padding: 0;
    border: 1px solid #ccc;
    margin: 2px;
    display: inline-block;
}

.note-color-palette .note-color-select-label {
    display: block;
    margin-top: 5px;
    font-size: 12px;
}

.note-color-palette .note-color-select {
    width: 100%;
    margin-top: 5px;
    padding: 2px;
    font-size: 11px;
}

/* Fix dropdown menus */
.note-dropdown-menu {
    min-width: 150px;
}

.note-dropdown-menu > li > a {
    padding: 5px 15px;
    display: block;
}

/* Ensure style dropdown works */
.note-style h1, .note-style h2, .note-style h3, 
.note-style h4, .note-style h5, .note-style h6,
.note-style p, .note-style blockquote, .note-style pre {
    margin: 0;
    padding: 0;
}
</style>

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
                <h5 class="card-title">Form Tambah Berita</h5>
            </div>
            <div class="card-body">
                <form action="index.php?action=berita_save" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Judul -->
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= isset($errors['judul']) ? 'is-invalid' : '' ?>" 
                                       id="judul" name="judul" 
                                       value="<?= htmlspecialchars($oldInput['judul'] ?? '') ?>" 
                                       required>
                                <?php if (isset($errors['judul'])): ?>
                                    <div class="invalid-feedback"><?= $errors['judul'] ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Isi Singkat -->
                            <div class="mb-3">
                                <label for="isi_singkat" class="form-label">Isi Singkat <span class="text-danger">*</span></label>
                                <textarea class="form-control <?= isset($errors['isi_singkat']) ? 'is-invalid' : '' ?>" 
                                          id="isi_singkat" name="isi_singkat" 
                                          rows="3" required><?= htmlspecialchars($oldInput['isi_singkat'] ?? '') ?></textarea>
                                <small class="text-muted">Ringkasan singkat yang akan ditampilkan di halaman utama (max 200 karakter)</small>
                                <?php if (isset($errors['isi_singkat'])): ?>
                                    <div class="invalid-feedback"><?= $errors['isi_singkat'] ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Isi Lengkap -->
                            <div class="mb-3">
                                <label for="isi_lengkap" class="form-label">Isi Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control <?= isset($errors['isi_lengkap']) ? 'is-invalid' : '' ?>" 
                                          id="isi_lengkap" name="isi_lengkap" 
                                          required><?= htmlspecialchars($oldInput['isi_lengkap'] ?? '') ?></textarea>
                                <small class="text-muted">Konten lengkap berita dengan rich text editor</small>
                                <?php if (isset($errors['isi_lengkap'])): ?>
                                    <div class="invalid-feedback"><?= $errors['isi_lengkap'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Kategori -->
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

                            <!-- Penulis -->
                            <div class="mb-3">
                                <label for="penulis" class="form-label">Penulis <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= isset($errors['penulis']) ? 'is-invalid' : '' ?>" 
                                       id="penulis" name="penulis" 
                                       value="<?= htmlspecialchars($oldInput['penulis'] ?? $_SESSION['username'] ?? '') ?>" 
                                       required>
                                <?php if (isset($errors['penulis'])): ?>
                                    <div class="invalid-feedback"><?= $errors['penulis'] ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Tanggal Publikasi -->
                            <div class="mb-3">
                                <label for="tanggal_publikasi" class="form-label">Tanggal Publikasi <span class="text-danger">*</span></label>
                                <input type="date" class="form-control <?= isset($errors['tanggal_publikasi']) ? 'is-invalid' : '' ?>" 
                                       id="tanggal_publikasi" name="tanggal_publikasi" 
                                       value="<?= htmlspecialchars($oldInput['tanggal_publikasi'] ?? date('Y-m-d')) ?>" 
                                       required>
                                <?php if (isset($errors['tanggal_publikasi'])): ?>
                                    <div class="invalid-feedback"><?= $errors['tanggal_publikasi'] ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="draft" <?= ($oldInput['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                                    <option value="published" <?= ($oldInput['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
                                </select>
                            </div>

                            <!-- Gambar -->
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar Utama</label>
                                <input type="file" class="form-control <?= isset($errors['gambar']) ? 'is-invalid' : '' ?>" 
                                       id="gambar" name="gambar" 
                                       accept="image/jpeg,image/jpg,image/png,image/gif,image/webp">
                                <small class="text-muted">Format: JPG, PNG, GIF, WEBP (Max 5MB)</small>
                                <?php if (isset($errors['gambar'])): ?>
                                    <div class="invalid-feedback"><?= $errors['gambar'] ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Preview Gambar -->
                            <div class="mb-3" id="preview-container" style="display: none;">
                                <label class="form-label">Preview Gambar</label>
                                <img id="preview-image" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Berita
                            </button>
                            <a href="index.php?action=berita_list" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
// Script akan dijalankan setelah footer (jQuery sudah loaded)
var summernoteInitInterval = setInterval(function() {
    if (typeof jQuery !== 'undefined' && typeof jQuery.fn.summernote !== 'undefined') {
        clearInterval(summernoteInitInterval);
        initializeSummernoteEditor();
    }
}, 100);

function initializeSummernoteEditor() {
    jQuery(function($) {
        // Destroy existing instance if any
        if ($('#isi_lengkap').next('.note-editor').length > 0) {
            $('#isi_lengkap').summernote('destroy');
        }
        
        $('#isi_lengkap').summernote({
            height: 350,
            minHeight: 250,
            maxHeight: 600,
            focus: false,
            placeholder: 'Tulis konten berita di sini...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            fontNames: [
                'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 
                'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 
                'Verdana', 'Roboto', 'Open Sans', 'Georgia', 'Palatino'
            ],
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '28', '32', '36', '48', '64'],
            styleTags: ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
            dialogsInBody: true,
            popover: {
                image: [
                    ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                    ['float', ['floatLeft', 'floatRight', 'floatNone']],
                    ['remove', ['removeMedia']]
                ],
                link: [
                    ['link', ['linkDialogShow', 'unlink']]
                ],
                table: [
                    ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                    ['delete', ['deleteRow', 'deleteCol', 'deleteTable']]
                ],
                air: [
                    ['color', ['color']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']]
                ]
            },
            callbacks: {
                onInit: function() {
                    console.log('Summernote initialized');
                    
                    // Custom fullscreen button handler
                    setupCustomFullscreen();
                },
                onImageUpload: function(files) {
                    for (let i = 0; i < files.length; i++) {
                        uploadImageToEditor(files[i], $(this));
                    }
                },
                onFocus: function() {
                    $('body').addClass('summernote-active');
                },
                onBlur: function() {
                    $('body').removeClass('summernote-active');
                }
            }
        });
        
        // Fix fullscreen - handle both browser fullscreen and Summernote fullscreen
        $(document).on('summernote.fullscreen.show', function() {
            var $editor = $('.note-editor.note-frame.fullscreen');
            $editor.css({
                'position': 'fixed',
                'top': '0',
                'left': '0',
                'width': '100vw',
                'height': '100vh',
                'z-index': '99999',
                'margin': '0',
                'border-radius': '0'
            });
            $('body').addClass('note-fullscreen');
            
            // Force scroll to top
            window.scrollTo(0, 0);
            
            // Prevent body scroll
            $('body').css('overflow', 'hidden');
        });
        
        $(document).on('summernote.fullscreen.hide', function() {
            $('body').removeClass('note-fullscreen');
            $('body').css('overflow', '');
            
            var $editor = $('.note-editor.note-frame');
            $editor.css({
                'position': '',
                'top': '',
                'left': '',
                'width': '',
                'height': '',
                'z-index': '',
                'margin': '',
                'border-radius': ''
            });
        });
        
        // Fix color picker - remove color on second click
        $(document).on('click', '.note-color-palette button', function(e) {
            var $btn = $(this);
            var $editor = $('#isi_lengkap');
            var color = $btn.data('value');
            
            // If clicking same color, remove it
            if ($btn.hasClass('active')) {
                $editor.summernote('removeFormat');
                $btn.removeClass('active');
                e.preventDefault();
                return false;
            }
        });
        
        // Ensure all dropdowns work
        setTimeout(function() {
            $('.note-dropdown-menu').each(function() {
                $(this).css('z-index', '10001');
            });
        }, 500);
        
        // Preview gambar utama
        $('#gambar').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-image').attr('src', e.target.result);
                    $('#preview-container').show();
                }
                reader.readAsDataURL(file);
            }
        });
    });
}

function uploadImageToEditor(file, editor) {
    if (!file.type.match('image.*')) {
        alert('Pilih file gambar');
        return;
    }
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran gambar maksimal 2MB');
        return;
    }
    let reader = new FileReader();
    reader.onloadend = function() {
        editor.summernote('insertImage', reader.result, function($image) {
            $image.css('max-width', '100%');
            $image.css('height', 'auto');
        });
    }
    reader.readAsDataURL(file);
}

function setupCustomFullscreen() {
    jQuery(function($) {
        // Override fullscreen button behavior
        $(document).on('click', '.note-btn-fullscreen', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var $editor = $('#isi_lengkap').next('.note-editor');
            var $frame = $editor.find('.note-frame');
            
            if ($frame.hasClass('fullscreen')) {
                // Exit fullscreen
                $frame.removeClass('fullscreen');
                $('body').removeClass('note-fullscreen');
                $('body').css('overflow', '');
                
                $editor.css({
                    'position': '',
                    'top': '',
                    'left': '',
                    'width': '',
                    'height': '',
                    'z-index': '',
                    'margin': '',
                    'border-radius': ''
                });
                
                $frame.css({
                    'position': '',
                    'top': '',
                    'left': '',
                    'width': '',
                    'height': '',
                    'z-index': '',
                    'margin': '',
                    'border-radius': ''
                });
            } else {
                // Enter fullscreen
                $frame.addClass('fullscreen');
                $('body').addClass('note-fullscreen');
                
                var windowWidth = $(window).width();
                var windowHeight = $(window).height();
                
                $editor.css({
                    'position': 'fixed',
                    'top': '0',
                    'left': '0',
                    'width': windowWidth + 'px',
                    'height': windowHeight + 'px',
                    'z-index': '99999',
                    'margin': '0',
                    'border-radius': '0'
                });
                
                $frame.css({
                    'position': 'absolute',
                    'top': '0',
                    'left': '0',
                    'width': '100%',
                    'height': '100%',
                    'z-index': '99999',
                    'margin': '0',
                    'border-radius': '0'
                });
                
                $('body').css('overflow', 'hidden');
                window.scrollTo(0, 0);
            }
            
            return false;
        });
    });
}
</script>

