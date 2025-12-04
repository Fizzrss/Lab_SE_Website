<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Pendaftar Recruitment</h3>
                <p class="text-subtitle text-muted">Kelola data calon anggota baru Lab SE.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Recruitment</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="row">
    <div class="col-12 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-icon purple">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold">Total Pendaftar</h6>
                        <h6 class="font-extrabold mb-0">
                            <?php
                            // Hitung manual array jika tidak ada method count
                            echo isset($data) ? count($data) : 0;
                            ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Daftar Peserta</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>

                            <th>NIM</th>
                            <th>Nama & Email</th>

                            <th>Prodi</th>
                            <th>Angkatan</th>

                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $uploadPath = '/Lab_SE_Website/upload/';

                        if (isset($data) && is_array($data) && count($data) > 0):
                            foreach ($data as $row):
                        ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['nim']) ?></td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="font-bold"><?= htmlspecialchars($row['nama']) ?></span>
                                            <small class="text-muted"><?= htmlspecialchars($row['email']) ?></small>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($row['prodi']) ?></td>
                                    <td><?= htmlspecialchars($row['angkatan']) ?></td>
                                    <td>
                                        <?php
                                        $status = strtolower($row['status']);
                                        $badgeClass = 'bg-secondary';
                                        if ($status == 'pending') $badgeClass = 'bg-warning';
                                        elseif ($status == 'proses') $badgeClass = 'bg-info';
                                        elseif ($status == 'lulus') $badgeClass = 'bg-success';
                                        elseif ($status == 'tidak lulus') $badgeClass = 'bg-danger';
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                                    </td>
                                    <td><?= htmlspecialchars($row['tanggal_daftar']) ?></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="index.php?action=recruitment_detail&id=<?= $row['id'] ?>" class="btn btn-sm btn-secondary" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="index.php?action=recruitment_delete&id=<?= $row['id'] ?>" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">Belum ada data pendaftar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


<script src="/Lab_SE_Website/admin/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>

<script src="/Lab_SE_Website/admin/assets/extensions/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/Lab_SE_Website/admin/vendor/jquery/jquery.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // 1. Setup Datatable
        let tableElement = document.querySelector('#table1');
        if (tableElement) {
            new simpleDatatables.DataTable(tableElement, {
                searchable: true,
                fixedHeight: false,
                perPage: 10,

                // KONFIGURASI SORTING
                columns: [
                    // Hanya mematikan sorting untuk kolom index 7 (Aksi)
                    {
                        select: 7,
                        sortable: false
                    }
                ],

                labels: {
                    placeholder: "Cari peserta...",
                    perPage: "entri per halaman",
                    noRows: "Tidak ada data",
                    info: "Menampilkan {start} - {end} dari {rows} data",
                }
            });
        }

        // 2. Logic SweetAlert untuk Lulus/Tolak

        document.body.addEventListener('click', function(e) {
            let target = e.target.closest('.btn-konfirmasi');

            if (target) {
                e.preventDefault();
                let url = target.getAttribute('href');
                let type = target.getAttribute('data-type');

                let titleText = (type === 'lulus') ? 'Terima Peserta?' : 'Tolak Peserta?';
                let bodyText = (type === 'lulus') ? 'Peserta akan dinyatakan LULUS seleksi.' : 'Peserta akan dinyatakan TIDAK LULUS.';
                let btnColor = (type === 'lulus') ? '#198754' : '#dc3545'; // Hijau / Merah

                Swal.fire({
                    title: titleText,
                    text: bodyText,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: btnColor,
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Lanjutkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            }
        });

        // 3. Logic SweetAlert Hapus
        document.body.addEventListener('click', function(e) {
            let target = e.target.closest('.btn-delete');
            if (target) {
                e.preventDefault();
                let url = target.getAttribute('href');

                Swal.fire({
                    title: 'Yakin hapus data?',
                    text: "Data dan file pendaftar akan dihapus permanen.",
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
            }
        });

    });
</script>