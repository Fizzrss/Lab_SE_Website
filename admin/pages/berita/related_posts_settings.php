<?php
if (!defined('ROOT_PATH')) {
    exit('Direct access not allowed');
}

// Default settings if not set
if (!isset($settings)) {
    $settings = [
        'enabled' => true,
        'max_posts' => 3,
        'show_same_category' => true
    ];
}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pengaturan Related Posts</h3>
                <p class="text-subtitle text-muted">Kelola tampilan berita terkait</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="index.php?action=berita_list">Berita</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Related Posts</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <?php echo getFlashMessage(); ?>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Pengaturan Related Posts</h5>
            </div>
            <div class="card-body">
                <form action="index.php?action=related_posts_update" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Enable/Disable -->
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="enabled" 
                                           value="1"
                                           id="enable_related_posts"
                                           <?= $settings['enabled'] ? 'checked' : '' ?>>
                                    <label class="form-check-label fw-bold" for="enable_related_posts">
                                        Aktifkan Related Posts
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    Jika dinonaktifkan, bagian "Berita Terkait" tidak akan ditampilkan di halaman detail berita.
                                </small>
                            </div>
                            
                            <hr>
                            
                            <!-- Max Posts -->
                            <div class="mb-3">
                                <label for="max_posts" class="form-label">Jumlah Maksimal Berita Terkait</label>
                                <input type="number" 
                                       class="form-control" 
                                       id="max_posts" 
                                       name="max_posts" 
                                       value="<?= $settings['max_posts'] ?? 3 ?>"
                                       min="1"
                                       max="12"
                                       required>
                                <small class="text-muted">
                                    Jumlah maksimal berita terkait yang ditampilkan (1-12)
                                </small>
                            </div>
                            
                            <!-- Same Category -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="show_same_category" 
                                           value="1"
                                           id="show_same_category"
                                           <?= $settings['show_same_category'] ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="show_same_category">
                                        Hanya Tampilkan Berita dari Kategori yang Sama
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    Jika dicentang, hanya menampilkan berita terkait yang memiliki kategori sama. 
                                    Jika tidak dicentang, akan menampilkan berita dari semua kategori.
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Pengaturan
                        </button>
                        <a href="index.php?action=berita_list" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title">Informasi</h5>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li><strong>Related Posts</strong> akan muncul di bagian bawah halaman detail berita</li>
                    <li>Berita yang sedang dibaca tidak akan muncul di list related posts</li>
                    <li>Related posts diurutkan berdasarkan tanggal publikasi (terbaru terlebih dahulu)</li>
                </ul>
            </div>
        </div>
    </section>
</div>

