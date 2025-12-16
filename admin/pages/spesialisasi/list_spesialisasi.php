<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Spesialisasi Personil</h3>
                <p class="text-subtitle text-muted">Data spesialisasi yang dimiliki oleh Personil laboratorium SE</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Personil</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-success alert-dismissible show fade">
        <?php
        if ($_GET['message'] == 'created') echo "Data spesialisasi berhasil ditambahkan.";
        elseif ($_GET['message'] == 'updated') echo "Data spesialisasi berhasil diperbarui.";
        elseif ($_GET['message'] == 'deleted') echo "Data spesialisasi berhasil dihapus.";
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title m-0">
                    Daftar Spesialisasi
                </h5>
                <a href="index.php?action=spesialisasi_add" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> Tambah Baru
                </a>
            </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Spesialisasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($spesialisasi) && is_array($spesialisasi) && count($spesialisasi) > 0):
                            $no = 1;
                            foreach ($spesialisasi as $row):
                        ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['nama_spesialisasi'] ?? '-'); ?></strong></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="index.php?action=spesialisasi_edit&id=<?= $row['id_spesialisasi']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="index.php?action=spesialisasi_delete&id=<?= $row['id_spesialisasi']; ?>"
                                                class="btn btn-sm btn-danger btn-delete"
                                                title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-folder2-open display-6 text-muted"></i>
                                    <p class="text-muted mt-2">Tidak ada data spesialisasi.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


<script src="/Lab_SE_Website/admin/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/Lab_SE_Website/admin/assets/static/js/pages/simple-datatables.js"></script>

<script src="/Lab_SE_Website/admin/assets/extensions/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/Lab_SE_Website/admin/vendor/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Cek apakah ada session 'swal_success' dari PHP?
        <?php if (isset($_SESSION['swal_success'])): ?>

            Swal.fire({
                title: 'Berhasil!',
                text: '<?= $_SESSION['swal_success']; ?>', // Ambil pesan dari PHP
                icon: 'success',
                timer: 2000, // Otomatis tutup dalam 2 detik
                showConfirmButton: false
            });

            // Hapus session setelah ditampilkan agar tidak muncul lagi saat refresh
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

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');

            Swal.fire({
                title: 'Yakin hapus data ini?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
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