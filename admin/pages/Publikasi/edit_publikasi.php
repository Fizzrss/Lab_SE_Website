<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Publikasi</h3>
                <p class="text-subtitle text-muted">Perbarui informasi publikasi atau penelitian.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="index.php?action=publikasi_list">Publikasi</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['swal_error'])): ?>
    <div class="alert alert-danger alert-dismissible show fade">
        <?= $_SESSION['swal_error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['swal_error']); ?>
<?php endif; ?>

<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Edit Data</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">

                        <form class="form" method="POST" action="index.php?action=publikasi_edit&id=<?= $data_old['id_publikasi'] ?>">
                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="judul-column" class="form-label">Judul Publikasi <span class="text-danger">*</span></label>
                                        <textarea id="judul-column" class="form-control" name="judul" rows="2" required><?= htmlspecialchars($data_old['judul']) ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="jenis-column" class="form-label">Jenis Publikasi <span class="text-danger">*</span></label>
                                        <select class="form-select" id="jenis-column" name="id_jenis" required>
                                            <option value="" disabled>-- Pilih Jenis --</option>
                                            <?php foreach ($jenis_list as $jenis): ?>
                                                <option value="<?= $jenis['id_jenis'] ?>"
                                                    <?= ($jenis['id_jenis'] == $data_old['id_jenis']) ? 'selected' : ''; ?>>
                                                    <?= htmlspecialchars($jenis['nama_jenis']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tahun-column" class="form-label">Tahun Terbit <span class="text-danger">*</span></label>
                                        <input type="number" id="tahun-column" class="form-control"
                                            name="tahun" value="<?= htmlspecialchars($data_old['tahun']) ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="personil-column" class="form-label">Personil / Penulis (Bisa Pilih > 1) <span class="text-danger">*</span></label>

                                        <select class="choices form-select" id="personil-column" name="id_personil[]" multiple required>
                                            <?php foreach ($personil_list as $p): ?>
                                                <option value="<?= $p['id_personil'] ?>"
                                                    <?php
                                                    // Cek apakah ID ini ada di daftar penulis yang sudah tersimpan?
                                                    if (in_array($p['id_personil'], $selected_authors)) {
                                                        echo 'selected';
                                                    }
                                                    ?>>
                                                    <?= htmlspecialchars($p['nama_personil']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="link-column" class="form-label">Link (URL)</label>
                                        <input type="url" id="link-column" class="form-control"
                                            name="link" value="<?= htmlspecialchars($data_old['link']) ?>">
                                        <small class="text-muted">Biarkan kosong jika tidak ada link.</small>
                                    </div>
                                </div>

                                <div class="col-12 mt-3 d-flex justify-content-end">
                                    <a href="index.php?action=publikasi_list" class="btn btn-light-secondary me-2">Batal</a>
                                    <button type="submit" class="btn btn-warning">Update Perubahan</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="/Lab_SE_Website/admin/assets/extensions/choices.js/public/assets/styles/choices.css">
<script src="/Lab_SE_Website/admin/assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
<script src="/Lab_SE_Website/admin/assets/static/js/pages/form-element-select.js"></script>

<script src="/Lab_SE_Website/admin/assets/extensions/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/Lab_SE_Website/admin/vendor/jquery/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('form').on('submit', function(e) {
            e.preventDefault(); // Cegah submit langsung
            var form = this;

            Swal.fire({
                title: 'Simpan Perubahan?',
                text: "Pastikan data penulis dan informasi lainnya sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107', // Warna Kuning Warning
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Update!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Lanjutkan submit manual
                }
            });
        });
    });
</script>