<?php
if (!defined('ROOT_PATH')) {
    exit('Direct access not allowed');
}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Manajemen Komentar</h3>
                <p class="text-subtitle text-muted">Kelola komentar berita</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="index.php?action=berita_list">Berita</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Komentar</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Daftar Komentar</h5>
                <p class="text-muted small mb-0">Semua komentar langsung tampil. Admin dapat menghapus komentar yang tidak sesuai.</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Berita</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Komentar</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($comments)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
                                        <p class="text-muted mt-2">Tidak ada komentar ditemukan</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php
                                $no = $offset + 1;
                                foreach ($comments as $comment):
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <strong><?= htmlspecialchars($comment['berita_judul'] ?? 'N/A') ?></strong>
                                        </td>
                                        <td><?= htmlspecialchars($comment['commenter_name']) ?></td>
                                        <td>
                                            <a href="mailto:<?= htmlspecialchars($comment['commenter_email']) ?>">
                                                <?= htmlspecialchars($comment['commenter_email']) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis;">
                                                <?= htmlspecialchars(substr($comment['comment_content'], 0, 100)) ?>
                                                <?= strlen($comment['comment_content']) > 100 ? '...' : '' ?>
                                            </div>
                                        </td>
                                        <td><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?></td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">

                                                <a href="index.php?action=komentar_detail&id=<?= $comment['id'] ?>"
                                                    class="btn btn-sm btn-secondary text-white"
                                                    data-bs-toggle="tooltip" title="Lihat Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                <a href="index.php?action=komentar_delete&id=<?= $comment['id'] ?>"
                                                    class="btn btn-sm btn-danger btn-delete"
                                                    data-bs-toggle="tooltip" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="/Lab_SE_Website/admin/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/Lab_SE_Website/admin/assets/static/js/pages/simple-datatables.js"></script>
<script src="/Lab_SE_Website/admin/assets/extensions/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/Lab_SE_Website/admin/vendor/jquery/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        
        // --- 1. ALERT SUKSES / ERROR (Sesuai Controller Baru) ---
        <?php if (isset($_SESSION['swal_icon'])): ?>
            Swal.fire({
                title: '<?= $_SESSION['swal_title']; ?>',
                text: '<?= $_SESSION['swal_text']; ?>',
                icon: '<?= $_SESSION['swal_icon']; ?>',
                timer: 2500,
                showConfirmButton: true
            });
            <?php 
            // Hapus session agar tidak muncul terus
            unset($_SESSION['swal_icon']); 
            unset($_SESSION['swal_title']); 
            unset($_SESSION['swal_text']); 
            ?>
        <?php endif; ?>

        // --- 2. ALERT KHUSUS WARNING (Opsional) ---
        <?php if (isset($_SESSION['swal_warning'])): ?>
            Swal.fire({
                title: 'Perhatian',
                text: '<?= $_SESSION['swal_warning']; ?>',
                icon: 'warning'
            });
            <?php unset($_SESSION['swal_warning']); ?>
        <?php endif; ?>

        // --- 3. KONFIRMASI HAPUS (Tetap Sama) ---
        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');

            Swal.fire({
                title: 'Yakin hapus komentar ini?',
                text: "Data akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
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