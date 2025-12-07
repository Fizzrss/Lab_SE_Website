<?php
// Pastikan variabel $data tersedia (dikirim dari controller)
if (!isset($data) || empty($data)) {
    echo "<div class='alert alert-danger'>Data pendaftar tidak ditemukan.</div>";
    return;
}

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
                <h3>Detail Pendaftar</h3>
                <p class="text-subtitle text-muted">Informasi lengkap calon anggota.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="index.php?action=pendaftar">Recruitment</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="row">

        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center flex-column">

                        <div class="avatar avatar-2xl mb-3">
                            <?php if (!empty($data['foto'])): ?>
                                <img src="<?= $uploadPath . 'foto/' . $data['foto'] ?>" alt="Foto"
                                    style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 4px solid #f2f7ff;">
                            <?php else: ?>
                                <div class="avatar-content bg-secondary text-white rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 150px; height: 150px; font-size: 3rem;">
                                    <?= strtoupper(substr($data['nama'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <h4 class="mt-3 mb-0 text-center"><?= htmlspecialchars($data['nama']) ?></h4>
                        <p class="text-small text-muted mb-2"><?= htmlspecialchars($data['prodi']) ?></p>

                        <?php
                        $status = strtolower($data['status']);
                        $badgeClass = 'bg-secondary';
                        if ($status == 'pending') $badgeClass = 'bg-warning';
                        elseif ($status == 'proses') $badgeClass = 'bg-info';
                        elseif ($status == 'lulus') $badgeClass = 'bg-success';
                        elseif ($status == 'tidak lulus') $badgeClass = 'bg-danger';
                        ?>
                        <span class="badge <?= $badgeClass ?> mb-4 px-3 py-2"><?= ucfirst($status) ?></span>

                        <div class="d-flex justify-content-between align-items-center w-100 px-3 mb-2">
                            <span class="fw-bold"><i class="bi bi-envelope me-2"></i>Email</span>
                        </div>
                        <p class="text-muted small px-3 w-100 text-break"><?= htmlspecialchars($data['email']) ?></p>

                        <div class="d-flex justify-content-between align-items-center w-100 px-3 mb-2 mt-3">
                            <span class="fw-bold"><i class="bi bi-whatsapp me-2"></i>WhatsApp</span>
                        </div>
                        <p class="text-muted small px-3 w-100">
                            <a href="https://wa.me/62<?= ltrim($data['no_hp'], '0') ?>" target="_blank" class="text-decoration-none">
                                <?= htmlspecialchars($data['no_hp']) ?>
                            </a>
                        </p>

                        <?php if ($status == 'pending' || $status == 'proses'): ?>
                            <div class="d-grid gap-2 w-100 mt-4 px-3">
                                <a href="index.php?action=recruitment_status&status=lulus&id=<?= $data['id'] ?>"
                                    class="btn btn-success btn-konfirmasi" data-type="lulus">
                                    <i class="bi bi-check-circle-fill me-2"></i> Terima Peserta
                                </a>
                                <a href="index.php?action=recruitment_status&status=tidak_lulus&id=<?= $data['id'] ?>"
                                    class="btn btn-outline-danger btn-konfirmasi" data-type="tolak">
                                    <i class="bi bi-x-circle-fill me-2"></i> Tolak Peserta
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="d-grid gap-2 w-100 mt-2 px-3">
                            <a href="index.php?action=recruitment_list" class="btn btn-light-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Kembali
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Data Akademik</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted font-semibold">Nomor Induk Mahasiswa (NIM)</h6>
                            <p class="fs-5 text-dark fw-bold"><?= htmlspecialchars($data['nim']) ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted font-semibold">Angkatan</h6>
                            <p class="fs-5 text-dark fw-bold"><?= htmlspecialchars($data['angkatan']) ?></p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <h6 class="text-muted font-semibold">Program Studi</h6>
                            <p class="fs-5 text-dark fw-bold"><?= htmlspecialchars($data['prodi']) ?></p>
                        </div>
                        <div class="col-md-12">
                            <h6 class="text-muted font-semibold">Tanggal Mendaftar</h6>
                            <p class="fs-6 text-dark"><?= date('d F Y, H:i', strtotime($data['tanggal_daftar'])) ?> WIB</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Minat & Pengalaman</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-primary mb-2"><i class="bi bi-chat-quote-fill me-2"></i>Alasan Bergabung</h6>
                        <div class="p-3 bg-light-primary rounded">
                            <?= nl2br(htmlspecialchars($data['alasan_bergabung'])) ?>
                        </div>
                    </div>

                    <div class="mb-2">
                        <h6 class="text-primary mb-2"><i class="bi bi-briefcase-fill me-2"></i>Pengalaman Organisasi/Kepanitiaan</h6>
                        <div class="p-3 bg-light rounded border">
                            <?php if (!empty($data['riwayat_pengalaman'])): ?>
                                <?= nl2br(htmlspecialchars($data['riwayat_pengalaman'])) ?>
                            <?php else: ?>
                                <span class="text-muted fst-italic">- Tidak ada pengalaman yang dituliskan -</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Lampiran Berkas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 text-center h-100">
                                <div class="mb-3 text-primary">
                                    <i class="bi bi-file-earmark-person-fill" style="font-size: 3rem;"></i>
                                </div>
                                <h6 class="mb-2">CV / Resume</h6>
                                <?php if (!empty($data['cv'])): ?>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCV">
                                        <i class="bi bi-eye me-1"></i> Lihat File
                                    </button>
                                <?php else: ?>
                                    <span class="badge bg-danger">Tidak ada file</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 text-center h-100">
                                <div class="mb-3 text-info">
                                    <i class="bi bi-folder-fill" style="font-size: 3rem;"></i>
                                </div>
                                <h6 class="mb-2">Portofolio</h6>
                                <?php if (!empty($data['portofolio'])): ?>
                                    <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#modalPorto">
                                        <i class="bi bi-eye me-1"></i> Lihat File
                                    </button>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Tidak ada file</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCV" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content" style="height: 90vh;">
                        <div class="modal-header">
                            <h5 class="modal-title">Curriculum Vitae - <?= htmlspecialchars($data['nama']) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <?php if (!empty($data['cv'])): ?>
                                <iframe src="<?= $uploadPath . 'cv/' . $data['cv'] ?>" width="100%" height="100%" style="border:none;"></iframe>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalPorto" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content" style="height: 90vh;">
                        <div class="modal-header">
                            <h5 class="modal-title">Portofolio - <?= htmlspecialchars($data['nama']) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <?php if (!empty($data['portofolio'])): ?>
                                <iframe src="<?= $uploadPath . 'portofolio/' . $data['portofolio'] ?>" width="100%" height="100%" style="border:none;"></iframe>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="/Lab_SE_Website/admin/assets/extensions/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/Lab_SE_Website/admin/vendor/jquery/jquery.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Logic untuk Tombol Konfirmasi (Terima/Tolak)
        const buttons = document.querySelectorAll('.btn-konfirmasi');
        buttons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                let url = this.getAttribute('href');
                let type = this.getAttribute('data-type');

                let titleText = (type === 'lulus') ? 'Terima Peserta?' : 'Tolak Peserta?';
                let bodyText = (type === 'lulus') ? 'Peserta akan dinyatakan LULUS seleksi.' : 'Peserta akan dinyatakan TIDAK LULUS.';
                let btnColor = (type === 'lulus') ? '#198754' : '#dc3545';

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
            });
        });
    });
</script>