<?php
$page_title = "Data Personil";
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Personil Lab</h3>
                <p class="text-subtitle text-muted">Data dosen, teknisi, dan asisten laboratorium.</p>
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
        if ($_GET['message'] == 'created') echo "Data personil berhasil ditambahkan.";
        elseif ($_GET['message'] == 'updated') echo "Data personil berhasil diperbarui.";
        elseif ($_GET['message'] == 'deleted') echo "Data personil berhasil dihapus.";
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0">
                Daftar Personil
            </h5>
            <a href="index.php?action=personil_add" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Baru
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>NIP</th>
                            <th>Nama & Email</th>
                            <th>Jabatan</th>
                            <th>Tautan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($all_personnel) && is_array($all_personnel) && count($all_personnel) > 0):
                            $no = 1;
                            foreach ($all_personnel as $row):
                        ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <div class="avatar avatar-lg">
                                            <?php if (!empty($row['foto'])): ?>
                                                <img src="<?= $row['foto']; ?>" alt="Foto" style="object-fit: cover;">
                                            <?php else: ?>
                                                <span class="avatar-content bg-secondary text-white"><i class="bi bi-person"></i></span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><strong><?= htmlspecialchars($row['nip'] ?? '-'); ?></strong></td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold"><?= htmlspecialchars($row['nama']); ?></span>
                                            <small class="text-muted"><?= htmlspecialchars($row['email'] ?? '-'); ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light-primary text-primary">
                                            <?= htmlspecialchars($row['peran']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 flex-wrap">
                                            <?php if (!empty($row['sosmed'])): ?>
                                                <?php foreach ($row['sosmed'] as $sm): ?>
                                                    <a href="<?= htmlspecialchars($sm['link_sosmed']) ?>"
                                                        target="_blank"
                                                        class="btn btn-sm btn-outline-primary py-0 px-1"
                                                        title="<?= htmlspecialchars($sm['nama_sosmed']) ?>">
                                                        <?php if ($sm['icon'] === 'custom-sinta'): ?>
                                                            <img src="../assets/icon/logo-sinta.svg" style="width:20px; height:20px;">
                                                        <?php elseif ($sm['icon'] === 'custom-rg'): ?>
                                                            <img src="../assets/icon/logo-researchgate.svg" style="width:20px; height:20px;">
                                                        <?php else: ?>
                                                            <i class="<?= htmlspecialchars($sm['icon']) ?>"></i>
                                                        <?php endif; ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="text-muted small">-</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="index.php?action=personil_edit&id=<?= $row['id']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="index.php?action=personil_delete&id=<?= $row['id']; ?>"
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
                                    <p class="text-muted mt-2">Tidak ada data personil.</p>
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
        // --- 1. ALERT SUKSES ---
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

        // --- 2. ALERT ERROR ---
        <?php if (isset($_SESSION['swal_error'])): ?>
            Swal.fire({
                title: 'Gagal!',
                text: '<?= $_SESSION['swal_error']; ?>',
                icon: 'error'
            });
            <?php unset($_SESSION['swal_error']); ?>
        <?php endif; ?>

        // --- 3. KONFIRMASI HAPUS (Event Delegation) ---
        // Gunakan 'body' agar event tetap jalan walau tabel di-refresh/paging oleh SimpleDatatables
        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');

            Swal.fire({
                title: 'Yakin hapus data ini?',
                text: "Data personil dan data terkait (spesialisasi, sosmed) akan dihapus permanen!",
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