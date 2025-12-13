<?php
if (empty($comment)) {
    echo "<div class='alert alert-danger'>Data komentar tidak ditemukan.</div>";
    return;
}

$initial = strtoupper(substr($comment['commenter_name'], 0, 1));
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Detail Komentar</h3>
                <p class="text-subtitle text-muted">Melihat detail isi komentar dan informasi pengirim.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="index.php?action=komentar_list">Komentar</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Informasi Pengirim</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="avatar avatar-2xl bg-warning mb-3">
                                <span class="avatar-content fs-2"><?= $initial ?></span>
                            </div>

                            <h5 class="mt-3 mb-0"><?= htmlspecialchars($comment['commenter_name']) ?></h5>
                            <p class="text-muted small">Pengunjung</p>
                        </div>

                        <hr>

                        <div class="info-list">
                            <div class="mb-3">
                                <strong class="text-muted d-block mb-1">Email:</strong>
                                <span><?= htmlspecialchars($comment['commenter_email']) ?></span>
                            </div>
                            <div class="mb-3">
                                <strong class="text-muted d-block mb-1">Waktu Kirim:</strong>
                                <span><?= date('d F Y', strtotime($comment['created_at'])) ?></span>
                                <br>
                                <small class="text-muted"><?= date('H:i:s', strtotime($comment['created_at'])) ?> WIB</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Isi Komentar</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-light-primary color-primary d-flex align-items-center">
                            <div>
                                <span class="d-block text-muted small">Komentar pada berita:</span>
                                <h6 class="mb-0">
                                    <?= htmlspecialchars($comment['berita_judul'] ?? 'Judul Berita Tidak Tersedia') ?>
                                </h6>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label class="form-label text-muted">Pesan / Komentar:</label>
                            <div class="p-4 bg-light rounded border">
                                <i class="bi bi-quote fs-2 text-muted opacity-25 d-block mb-2"></i>
                                <p class="mb-0 fs-6" style="white-space: pre-line; line-height: 1.6;">
                                    <?= htmlspecialchars($comment['comment_content']) ?>
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 d-flex justify-content-end gap-2">
                            <a href="index.php?action=komentar_list" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            
                            <a href="index.php?action=komentar_delete&id=<?= $comment['id'] ?>" 
                               class="btn btn-danger btn-delete">
                                <i class="bi bi-trash"></i> Hapus Komentar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="assets/extensions/jquery/jquery.min.js"></script>
<script src="assets/extensions/sweetalert2/sweetalert2.min.js"></script>

<script>
    $(document).ready(function() {
        // Event Listener untuk Tombol Hapus
        $('.btn-delete').on('click', function(e) {
            e.preventDefault(); // Mencegah link langsung jalan
            var url = $(this).attr('href');

            Swal.fire({
                title: 'Hapus Komentar?',
                text: "Komentar ini akan dihapus permanen dari database.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });
</script>