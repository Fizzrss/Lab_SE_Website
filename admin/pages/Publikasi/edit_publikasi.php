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
                        <li class="breadcrumb-item"><a href="index.php?controller=publikasi&action=index">Publikasi</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
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
                        <h4 class="card-title">Form Edit Data</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            
                            <form class="form" method="POST" action="">
                                <div class="row">
                                    
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="judul-column" class="form-label">Judul Publikasi <span class="text-danger">*</span></label>
                                            <input type="text" id="judul-column" class="form-control" 
                                                   name="judul" 
                                                   value="<?= htmlspecialchars($data_old['judul']) ?>" 
                                                   required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="jenis-column" class="form-label">Jenis Publikasi <span class="text-danger">*</span></label>
                                            <select class="form-select" id="jenis-column" name="id_jenis" required>
                                                <option value="" disabled>-- Pilih Jenis --</option>
                                                <?php foreach ($jenis_list as $jenis): ?>
                                                    <option value="<?= $jenis['id_jenis'] ?>" 
                                                        <?php 
                                                            // Logika: Jika ID di database sama dengan ID loop, tambahkan 'selected'
                                                            echo ($jenis['id_jenis'] == $data_old['id_jenis']) ? 'selected' : ''; 
                                                        ?>
                                                    >
                                                        <?= htmlspecialchars($jenis['nama_jenis']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="personil-column" class="form-label">Personil / Penulis <span class="text-danger">*</span></label>
                                            <select class="form-select" id="personil-column" name="id_personil" required>
                                                <option value="" disabled>-- Pilih Personil --</option>
                                                <?php foreach ($personil_list as $p): ?>
                                                    <option value="<?= $p['id_personil'] ?>"
                                                        <?php 
                                                            // Logika Selected untuk Personil
                                                            echo ($p['id_personil'] == $data_old['id_personil']) ? 'selected' : ''; 
                                                        ?>
                                                    >
                                                        <?= htmlspecialchars($p['nama_personil']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="tahun-column" class="form-label">Tahun Terbit <span class="text-danger">*</span></label>
                                            <input type="number" id="tahun-column" class="form-control" 
                                                   name="tahun" 
                                                   value="<?= htmlspecialchars($data_old['tahun']) ?>" 
                                                   required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="link-column" class="form-label">Link (URL)</label>
                                            <input type="url" id="link-column" class="form-control" 
                                                   name="link" 
                                                   value="<?= htmlspecialchars($data_old['link']) ?>">
                                            <small class="text-muted">Biarkan kosong jika tidak ada link.</small>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="index.php?action=publikasi_list" class="btn btn-secondary">Batal</a>
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

<script src="/Lab_SE_Website/admin/assets/extensions/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/Lab_SE_Website/admin/vendor/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.remove-row', function() {
            if ($('#container-spesialisasi .input-group').length > 1) {
                $(this).closest('.input-group').remove();
            } else {
                $(this).closest('.input-group').find('select').val('');
                alert("Minimal harus ada satu baris spesialisasi.");
            }
        });

        $('form').on('submit', function(e) {
            e.preventDefault(); // Cegah submit langsung
            var form = this;

            Swal.fire({
                title: 'Simpan Perubahan?',
                text: "Pastikan data sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
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