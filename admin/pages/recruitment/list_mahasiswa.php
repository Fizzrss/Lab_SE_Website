<?php
$uploadPath = '/Lab_SE_Website/upload/';
?>
<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Mahasiswa</h3>
                <p class="text-subtitle text-muted">Kelola data anggota dan pengurus laboratorium.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Mahasiswa</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0">Daftar Mahasiswa Aktif</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="table1">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="8%">Foto</th>
                            <th style="min-width: 120px;">NIM</th>
                            <th style="min-width: 250px;">Nama & Email</th>
                            <th style="min-width: 140px;">No. HP</th>
                            <th style="min-width: 200px;">Prodi</th>
                            <th style="min-width: 100px;">Angkatan</th>
                            <th style="min-width: 120px;">Posisi</th>
                            <th style="min-width: 100px;">Status</th>
                            <th style="min-width: 120px;">Tgl Daftar</th>

                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($mahasiswa_list) && is_array($mahasiswa_list) && count($mahasiswa_list) > 0):
                            $no = 1;
                            foreach ($mahasiswa_list as $row):
                        ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <div class="avatar avatar-lg">
                                        <?php if (!empty($row['foto'])): ?>
                                                <img src="<?= $uploadPath . 'foto/'. $row['foto'] ?>" alt="Foto" style="object-fit: cover;">
                                        <?php else: ?>
                                                <span class="avatar-content bg-secondary text-white"><i class="bi bi-person"></i></span>
                                        <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($row['nim']); ?></td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="font-bold"><?= htmlspecialchars($row['nama']); ?></span>
                                            <small class="text-muted"><?= htmlspecialchars($row['email'] ?? '-'); ?></small>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($row['no_hp'] ?? '-'); ?></td>
                                    <td><?= htmlspecialchars($row['prodi']); ?></td>
                                    <td><?= htmlspecialchars($row['angkatan']); ?></td>
                                    <td><?= htmlspecialchars($row['posisi'] ?? '-'); ?></td>
                                    <td>
                                        <?php
                                        $status = strtolower($row['status'] ?? 'aktif');
                                        $badgeClass = 'bg-secondary';
                                        if ($status == 'aktif') $badgeClass = 'bg-success';
                                        elseif ($status == 'cuti') $badgeClass = 'bg-warning';
                                        elseif ($status == 'lulus' || $status == 'alumni') $badgeClass = 'bg-info';
                                        elseif ($status == 'keluar') $badgeClass = 'bg-danger';
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= ucfirst($status); ?></span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($row['tanggal_bergabung'] ?? 'now')); ?></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="index.php?action=mahasiswa_edit&id=<?= $row['id']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="index.php?action=mahasiswa_delete&id=<?= $row['id']; ?>"
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
                                <td colspan="11" class="text-center py-4">Data mahasiswa belum tersedia.</td>
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
        // Cek session sukses
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

        // Cek session error
        <?php if (isset($_SESSION['swal_error'])): ?>
            Swal.fire({
                title: 'Gagal!',
                text: '<?= $_SESSION['swal_error']; ?>',
                icon: 'error'
            });
            <?php unset($_SESSION['swal_error']); ?>
        <?php endif; ?>

        // Logic Tombol Delete dengan SweetAlert
        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');

            Swal.fire({
                title: 'Yakin hapus data ini?',
                text: "Data personil yang dihapus tidak bisa dikembalikan!",
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