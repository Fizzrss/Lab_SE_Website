<?php
// admin/pages/recruitment/pendaftar.php
$page_title = "Data Pendaftar Recruitment";

// Pastikan variabel $result dan $recruitment sudah disediakan 
// oleh admin/index.php atau RecruitmentController

if (!isset($result) || !isset($recruitment)) {
    die("Error: Variabel \$result atau \$recruitment belum diinisialisasi.");
}
?>

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="row">
            <div class="col-12">
                <?= get_flashdata('success'); ?>
                <?= get_flashdata('danger'); ?>
                <?= get_flashdata('warning'); ?>
            </div>
        </div>
        
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Pendaftar Recruitment</h3>
                    <p class="text-subtitle text-muted">List semua pendaftar SE Geeks</p>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-muted font-semibold">Total Pendaftar</h6>
                                    <h4 class="font-extrabold mb-0"><?= $recruitment->countByStatus('pending') + $recruitment->countByStatus('proses') + $recruitment->countByStatus('lulus') + $recruitment->countByStatus('tidak lulus') ?></h4>
                                </div>
                                <div class="stats-icon purple">
                                    <i class="iconly-boldProfile"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Semua Pendaftar</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Prodi</th>
                                    <th>Angkatan</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                // Loop melalui hasil query database
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)):
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($row['nama']) ?></td>
                                        <td><?= htmlspecialchars($row['nim']) ?></td>
                                        <td><?= htmlspecialchars($row['prodi']) ?></td>
                                        <td><?= htmlspecialchars($row['angkatan']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($row['tanggal_daftar'])) ?></td>
                                        <td>
                                            <?php
                                            // Logic Badge Sesuai Status
                                            $status = strtolower($row['status']); 
                                            $badgeClass = 'bg-secondary';
                                            if ($status == 'pending') { $badgeClass = 'bg-warning'; } 
                                            elseif ($status == 'proses') { $badgeClass = 'bg-info'; } 
                                            elseif ($status == 'lulus') { $badgeClass = 'bg-success'; } 
                                            elseif ($status == 'tidak lulus') { $badgeClass = 'bg-danger'; }
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                                        </td>
                                        <td>
                                            <a href="detail_pendaftar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <?php if ($status == 'pending' || $status == 'proses'): ?>
                                                <a href="pages/recruitment/proses_seleksi.php?action=lulus&id=<?= $row['id'] ?>"
                                                    class="btn btn-sm btn-success"
                                                    onclick="konfirmasiLulus(event, this)"> <i class="bi bi-check-lg"></i> Lulus
                                                </a>

                                                <a href="pages/recruitment/proses_seleksi.php?action=tidak_lulus&id=<?= $row['id'] ?>"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Nyatakan TIDAK LULUS?')"
                                                    title="Tolak">
                                                    <i class="bi bi-x-lg"></i> Tidak Lulus
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php 
    // Asumsi $root sudah didefinisikan di file utama (index.php)
    require_once $root . '/admin/includes/admin_footer.php'; 
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/Lab_SE_Website/admin/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>

<script>
    // --- Bagian 1: Inisialisasi Tabel (Tetap Sama) ---
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);

    // --- Bagian 2: Fungsi Konfirmasi Hapus (Di-upgrade ke SweetAlert) ---
    function hapus(id) {
        Swal.fire({
            title: 'Yakin hapus data ini?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',     // Merah
            cancelButtonColor: '#6c757d',   // Abu-abu
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Arahkan ke proses hapus
                window.location.href = 'pages/recruitment/proses_seleksi.php?action=hapus&id=' + id; 
            }
        });
    }

    // --- Bagian 3: Fungsi Konfirmasi Lulus (Tetap Sama) ---
    function konfirmasiLulus(event, element) {
        event.preventDefault(); // Mencegah link langsung pindah
        const url = element.getAttribute('href'); // Ambil link dari tombol

        Swal.fire({
            title: 'Nyatakan Lulus?',
            text: "Data akan dipindah ke tabel Mahasiswa Aktif.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754', // Hijau
            cancelButtonColor: '#d33', // Merah
            confirmButtonText: 'Ya, Luluskan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url; // Lanjut ke link proses
            }
        });
    }
</script>