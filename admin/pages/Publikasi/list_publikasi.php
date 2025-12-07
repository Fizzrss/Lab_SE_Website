<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Publikasi</h3>
                <p class="text-subtitle text-muted">Daftar publikasi penelitian personil Lab Software Engineering.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Publikasi</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success alert-dismissible show fade">
            <?php
            if ($_GET['message'] == 'created') echo "Data publikasi berhasil ditambahkan.";
            elseif ($_GET['message'] == 'updated') echo "Data publikasi berhasil diperbarui.";
            elseif ($_GET['message'] == 'deleted') echo "Data publikasi berhasil dihapus.";
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title m-0">
                    Daftar Publikasi
                </h5>
                <a href="index.php?action=publikasi_add" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> Tambah Baru
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Jenis</th>
                            <th>Personil</th>
                            <th>Tahun</th>
                            <th>Link</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($publikasi_list)):
                            $no = 1;
                            foreach ($publikasi_list as $row):
                        ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['judul']) ?></td>
                                    <td>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($row['nama_jenis']) ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <p class="font-bold ms-3 mb-0"><?= htmlspecialchars($row['daftar_penulis']) ?></p>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($row['tahun']) ?></td>
                                    <td>
                                        <?php if (!empty($row['link'])): ?>
                                            <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Buka Link">
                                                <i class="bi bi-link-45deg"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2"> <a href="index.php?action=publikasi_edit&id=<?= $row['id_publikasi'] ?>"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <a href="index.php?action=publikasi_delete&id=<?= $row['id_publikasi'] ?>"
                                                class="btn btn-sm btn-danger btn-delete">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                        else:
                            ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data publikasi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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

        $('.btn-delete').on('click', function(e) {
            e.preventDefault(); // Cegah link langsung jalan
            var url = $(this).attr('href'); // Ambil link dari tombol

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
                    window.location.href = url; // Lanjut ke link penghapusan
                }
            });
        });
    });
</script>