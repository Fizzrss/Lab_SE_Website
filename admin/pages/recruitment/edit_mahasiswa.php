<?php
// Validasi data
if (!isset($data) || empty($data)) {
    echo "<div class='alert alert-danger'>Data tidak ditemukan.</div>";
    return;
}
$uploadPath = '/Lab_SE_Website/upload/';
?>

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
                    <h3>Edit Data Pendaftar</h3>
                    <p class="text-subtitle text-muted">Perbarui data calon anggota.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="index.php?action=pendaftar">Recruitment</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Edit</h4>
            </div>
            <div class="card-body">
                <form action="index.php?action=mahasiswa_edit&id=<?= $data['id'] ?>"
                    method="POST" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama"
                                    value="<?= htmlspecialchars($data['nama']) ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">NIM</label>
                                <input type="text" class="form-control" name="nim"
                                    value="<?= htmlspecialchars($data['nim']) ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email"
                                    value="<?= htmlspecialchars($data['email']) ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">No. WhatsApp</label>
                                <input type="text" class="form-control" name="no_hp"
                                    value="<?= htmlspecialchars($data['no_hp']) ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="form-group mb-3">
                                <label class="form-label">Angkatan</label>
                                <input type="text" class="form-control" name="angkatan"
                                    value="<?= htmlspecialchars($data['angkatan']) ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Posisi</label>
                                <select class="form-select" name="posisi">
                                    <?php
                                    $posisi = ['asisten', 'anggota', 'staff'];
                                    foreach ($posisi as $p) {
                                        $sel = ($data['posisi'] == $p) ? 'selected' : '';
                                        echo "<option value='$p' $sel>" . ucfirst($p) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <?php
                                    $status = ['aktif', 'non-aktif', 'alumni'];
                                    foreach ($status as $s) {
                                        $sel = ($data['status'] == $s) ? 'selected' : '';
                                        echo "<option value='$s' $sel>" . ucfirst($s) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Program Studi</label>
                                <select class="form-select" name="prodi" required>
                                    <?php
                                    $listProdi = [
                                        "D4 - Teknik Informatika",
                                        "D4 - Sistem Informasi Bisnis"
                                    ];

                                    foreach ($listProdi as $p) {
                                        $selected = ($data['prodi'] == $p) ? 'selected' : '';
                                        echo "<option value='$p' $selected>$p</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="index.php?action=mahasiswa_list" class="btn btn-light-secondary me-2">Batal</a>
                        </div>
                    </div>

                </form>

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