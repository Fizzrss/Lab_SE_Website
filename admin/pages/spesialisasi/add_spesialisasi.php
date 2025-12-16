<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Spesialisasi</h3>
                <p class="text-subtitle text-muted">Input data Spesialisasi baru.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="index.php?action=publikasi_list">Spesialisasi</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Data Spesialisasi</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="POST" action="index.php?action=spesialisasi_add">
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>Nama Spesialisasi</label>
                                    <input type="text" name="nama_spesialisasi" class="form-control" required placeholder="Masukkan Nama Spesialisasi">
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="index.php?action=spesialisasi_list" class="btn btn-secondary">Batal</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


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