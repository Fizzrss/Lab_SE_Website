<div class="page-heading">
    <h3>Tambah Personil Baru</h3>
</div>

<div class="card">
    <div class="card-body">
        <form action="index.php?action=personil_save" method="POST" enctype="multipart/form-data">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" required placeholder="Contoh: Budi Santoso, S.Kom">
                </div>
                <div class="col-md-6 mb-3">
                    <label>NIP</label>
                    <input type="text" name="nip" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Jabatan</label>
                    <select name="jabatan" class="form-select" required>
                        <option value="">-- Pilih Jabatan --</option>
                        <?php foreach($jabatan_list as $j): ?>
                            <option value="<?= $j['id_jabatan'] ?>"><?= $j['jabatan_dosen'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Link Google Scholar</label>
                    <input type="text" name="gscholar" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Link LinkedIn</label>
                    <input type="text" name="linkedin" class="form-control">
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
                    <input type="file" name="foto" class="form-control" required accept="image/*">
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
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
                title: 'Simpan Data?',
                text: "Pastikan data sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
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