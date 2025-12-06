<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tambah Publikasi</h3>
                    <p class="text-subtitle text-muted">Input data publikasi atau penelitian baru.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="index.php?action=publikasi_list">Publikasi</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible show fade">
            <?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Data Publikasi</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" action="index.php?action=publikasi_add">
                                <div class="row">
                                    
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="judul-column" class="form-label">Judul Publikasi <span class="text-danger">*</span></label>
                                            <textarea id="judul-column" class="form-control" 
                                                   placeholder="Masukkan judul lengkap publikasi/jurnal" name="judul" rows="2" required></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="jenis-column" class="form-label">Jenis Publikasi <span class="text-danger">*</span></label>
                                            <select class="form-select" id="jenis-column" name="id_jenis" required>
                                                <option value="" selected disabled>-- Pilih Jenis --</option>
                                                <?php foreach ($jenis_list as $jenis): ?>
                                                    <option value="<?= $jenis['id_jenis'] ?>">
                                                        <?= htmlspecialchars($jenis['nama_jenis']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="tahun-column" class="form-label">Tahun Terbit <span class="text-danger">*</span></label>
                                            <input type="number" id="tahun-column" class="form-control" 
                                                   placeholder="Contoh: 2024" name="tahun" min="1900" max="2099" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="personil-column" class="form-label">Personil / Penulis (Bisa Pilih > 1) <span class="text-danger">*</span></label>
                                            
                                            <select class="choices form-select" id="personil-column" name="id_personil[]" multiple required>
                                                <?php foreach ($personil_list as $p): ?>
                                                    <option value="<?= $p['id_personil'] ?>">
                                                        <?= htmlspecialchars($p['nama_personil']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="link-column" class="form-label">Link (URL)</label>
                                            <input type="url" id="link-column" class="form-control" 
                                                   placeholder="https://jurnal.com/..." name="link">
                                            <small class="text-muted">Biarkan kosong jika tidak ada link.</small>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4 d-flex justify-content-end">
                                        <a href="index.php?action=publikasi_list" class="btn btn-light-secondary me-2">Batal</a>
                                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<link rel="stylesheet" href="/Lab_SE_Website/admin/assets/extensions/choices.js/public/assets/styles/choices.css">
<script src="/Lab_SE_Website/admin/assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
<script src="/Lab_SE_Website/admin/assets/static/js/pages/form-element-select.js"></script>

<script src="/Lab_SE_Website/admin/assets/extensions/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/Lab_SE_Website/admin/vendor/jquery/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // Konfirmasi Simpan dengan SweetAlert
        $('form').on('submit', function(e) {
            e.preventDefault(); // Cegah submit langsung
            var form = this;

            Swal.fire({
                title: 'Simpan Data?',
                text: "Pastikan data sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#435ebe', // Warna Biru Mazer
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Lanjutkan submit manual
                }
            });
        });
    });
</script>