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

    <?php echo getFlashMessage(); ?>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Daftar Komentar</h5>
                <p class="text-muted small mb-0">Semua komentar langsung tampil. Admin dapat menghapus komentar yang tidak sesuai.</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
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
                                        <td>
                                            <a href="index.php?action=komentar_delete&id=<?= $comment['id'] ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Yakin ingin menghapus komentar ini?')"
                                               title="Hapus Komentar">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <nav aria-label="Page navigation" class="mt-3">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="?action=komentar_list&page=<?= $page - 1 ?>">
                                    Previous
                                </a>
                            </li>
                            
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                    <a class="page-link" href="?action=komentar_list&page=<?= $i ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                                <a class="page-link" href="?action=komentar_list&page=<?= $page + 1 ?>">
                                    Next
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

