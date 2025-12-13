<?php
if (!defined('ROOT_PATH')) {
    exit('Direct access not allowed');
}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Manajemen Berita</h3>
                <p class="text-subtitle text-muted">Kelola berita dan artikel Lab SE</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Berita</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="card-title">Daftar Berita</h5>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="index.php?action=berita_add" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Berita
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <form method="GET" action="">
                            <input type="hidden" name="action" value="berita_list">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari berita..."
                                    value="<?= htmlspecialchars($search ?? '') ?>">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form method="GET" action="">
                            <input type="hidden" name="action" value="berita_list">
                            <select name="kategori" class="form-select" onchange="this.form.submit()">
                                <option value="">Semua Kategori</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= htmlspecialchars($cat) ?>"
                                        <?= $kategori === $cat ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Penulis</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($beritaList)): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
                                        <p class="text-muted mt-2">Tidak ada berita ditemukan</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php
                                $no = $offset + 1;
                                foreach ($beritaList as $berita):
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <img src="<?= htmlspecialchars($berita['gambar']) ?>"
                                                alt="<?= htmlspecialchars($berita['judul']) ?>"
                                                style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;"
                                                onerror="this.src='https://placehold.co/60x60/png?text=No+Image'">
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($berita['judul']) ?></strong>
                                            <br>
                                            <small class="text-muted">
                                                <?= htmlspecialchars(substr($berita['isi_singkat'], 0, 80)) ?>...
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                <?= htmlspecialchars($berita['kategori']) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($berita['penulis']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($berita['tanggal_publikasi'])) ?></td>
                                        <td>
                                            <?php if ($berita['status'] === 'published'): ?>
                                                <span class="badge bg-success">Published</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Draft</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="index.php?action=berita_edit&id=<?= $berita['id'] ?>"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="index.php?action=berita_delete&id=<?= $berita['id'] ?>"
                                                    class="btn btn-sm btn-danger btn-delete"
                                                    data-bs-toggle="tooltip"
                                                    title="Hapus">
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

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <nav aria-label="Page navigation" class="mt-3">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="?action=berita_list&page=<?= $page - 1 ?><?= $kategori ? '&kategori=' . urlencode($kategori) : '' ?><?= $search ? '&search=' . urlencode($search) : '' ?>">
                                    Previous
                                </a>
                            </li>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                    <a class="page-link" href="?action=berita_list&page=<?= $i ?><?= $kategori ? '&kategori=' . urlencode($kategori) : '' ?><?= $search ? '&search=' . urlencode($search) : '' ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                                <a class="page-link" href="?action=berita_list&page=<?= $page + 1 ?><?= $kategori ? '&kategori=' . urlencode($kategori) : '' ?><?= $search ? '&search=' . urlencode($search) : '' ?>">
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

<script src="/Lab_SE_Website/admin/vendor/jquery/jquery.min.js"></script>
<script src="/Lab_SE_Website/admin/assets/extensions/sweetalert2/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {
        <?php if (isset($_SESSION['swal_success'])): ?>
            Swal.fire({
                title: 'Berhasil!',
                text: '<?= $_SESSION['swal_success']; ?>',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
            <?php unset($_SESSION['swal_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['swal_error'])): ?>
            Swal.fire({
                title: 'Gagal!',
                text: '<?= $_SESSION['swal_error']; ?>',
                icon: 'error'
            });
            <?php unset($_SESSION['swal_error']); ?>
        <?php endif; ?>

        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');

            Swal.fire({
                title: 'Yakin hapus data ini?',
                text: "Data berita ini akan dihapus permanen!",
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