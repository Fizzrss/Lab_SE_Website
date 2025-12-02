<div class="page-heading">
    <h3>Edit Data Personil</h3>
</div>

<div class="card">
    <div class="card-body">
        <form action="index.php?action=personil_update&id=<?= $personnel['id_personil'] ?>" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="foto_lama" value="<?= $personnel['foto_personil'] ?>">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($personnel['nama_personil']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>NIP</label>
                    <input type="text" name="nip" class="form-control" value="<?= htmlspecialchars($personnel['nip']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($personnel['email']) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Jabatan</label>
                    <select name="jabatan" class="form-select" required>
                        <option value="">-- Pilih Jabatan --</option>
                        <?php foreach ($jabatan_list as $j): ?>
                            <option value="<?= $j['id_jabatan'] ?>" <?= ($j['id_jabatan'] == $personnel['id_jabatan']) ? 'selected' : '' ?>>
                                <?= $j['jabatan_dosen'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Link Google Scholar</label>
                    <input type="text" name="gscholar" class="form-control" value="<?= htmlspecialchars($personnel['link_gscholar']) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Link LinkedIn</label>
                    <input type="text" name="linkedin" class="form-control" value="<?= htmlspecialchars($personnel['linkedin']) ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Spesialisasi</label>
                    <div id="container-spesialisasi">
                        <?php
                        if (!empty($owned_specs)):
                            foreach ($owned_specs as $current_spec_id):
                        ?>
                                <div class="input-group mb-2">
                                    <select name="spesialisasi[]" class="form-select">
                                        <option value="">-- Pilih Bidang --</option>
                                        <?php foreach ($spesialisasi_list as $master): ?>
                                            <option value="<?= $master['id_spesialisasi'] ?>"
                                                <?= ($master['id_spesialisasi'] == $current_spec_id) ? 'selected' : '' ?>>
                                                <?= $master['nama_spesialisasi'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <button type="button" class="btn btn-danger remove-row">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            <?php
                            endforeach;
                        else:
                            ?>
                            <div class="input-group mb-2">
                                <select name="spesialisasi[]" class="form-select">
                                    <option value="">-- Pilih Bidang --</option>
                                    <?php foreach ($spesialisasi_list as $master): ?>
                                        <option value="<?= $master['id_spesialisasi'] ?>">
                                            <?= $master['nama_spesialisasi'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="btn btn-danger remove-row"><i class="bi bi-trash"></i></button>
                            </div>
                        <?php endif; ?>

                    </div>

                    <button type="button" class="btn btn-success btn-sm mt-1" id="add-row">
                        <i class="bi bi-plus-circle"></i> Tambah Spesialisasi Lain
                    </button>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Foto Profil</label>
                    <div class="mb-2">
                        <img src="../assets/img/personil/<?= $personnel['foto_personil'] ?>" width="100" class="img-thumbnail">
                        <small class="text-muted d-block">Foto saat ini</small>
                    </div>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    <small class="text-danger">*Biarkan kosong jika tidak ingin mengubah foto</small>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-warning">Update Data</button>
                <a href="index.php?action=personil_list" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script src="/Lab_SE_Website/admin/assets/extensions/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/Lab_SE_Website/admin/vendor/jquery/jquery.min.js"></script>  
<script>
    $(document).ready(function() {
        var optionsHtml = '<option value="">-- Pilih Bidang --</option>';
        
        <?php if(!empty($spesialisasi_list)): ?>
            <?php foreach ($spesialisasi_list as $master): ?>
                optionsHtml += '<option value="<?= $master["id_spesialisasi"] ?>"><?= htmlspecialchars($master["nama_spesialisasi"]) ?></option>';
            <?php endforeach; ?>
        <?php endif; ?>

        $('#add-row').click(function(e) {
            e.preventDefault(); 

            var html = `
                <div class="input-group mb-2">
                    <select name="spesialisasi[]" class="form-select">
                        ${optionsHtml} 
                    </select>
                    <button type="button" class="btn btn-danger remove-row">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
            
            $('#container-spesialisasi').append(html);
        });

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
                confirmButtonColor: '#ffc107', // Warna Kuning (Warning)
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

<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
 