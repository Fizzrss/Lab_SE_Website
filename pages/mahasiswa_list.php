<?php
/*
|--------------------------------------------------------------------------
| File: pages/mahasiswa_list.php
|--------------------------------------------------------------------------
| Halaman ini sekarang aman.
| 1. Memanggil 'config.php' (yang sudah tidak ada koneksi database)
| 2. Menyediakan data-nya sendiri (Data Dummy)
*/

// Bagian 1: MEMANGGIL KONFIGURASI (Sekarang sudah "Aman")
require_once '../includes/config.php';

// Bagian 2: Memanggil Cangkang Halaman
include '../includes/navbar.php'; 

// Bagian 3: DATA DUMMY (Inilah "Database Kasaran" kita)
// Kita buat data palsu di sini agar tabelnya terisi.
$dummy_mahasiswa_list = [
    [
        "nama" => "Ahmad Fauzi (Dummy)",
        "program_studi" => "D-IV Sistem Informasi Bisnis",
        "status" => "Aktif"
    ],
    [
        "nama" => "Siti Nurhaliza (Dummy)",
        "program_studi" => "D-IV Sistem Informasi Bisnis",
        "status" => "Aktif"
    ],
    [
        "nama" => "Budi Santoso (Dummy)",
        "program_studi" => "D-IV Teknik Informatika",
        "status" => "Aktif"
    ],
    [
        "nama" => "Dewi Lestari (Dummy)",
        "program_studi" => "D-IV Sistem Informasi Bisnis",
        "status" => "Alumni"
    ]
];
?>

<main>
    <div class="container my-5">

        <div class="row mb-4">
            <div class="col-12">
                <h2 class="display-5">Daftar Mahasiswa Software Engineering Geeks</h2>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Program Studi</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php
                            // Bagian 5: PHP Loop (Aman)
                            // Cek dulu apakah datanya ada
                            if (empty($dummy_mahasiswa_list)) :
                            ?>
                                <tr>
                                    <td colspan="3" class="text-center">
                                        Data mahasiswa belum tersedia saat ini.
                                    </td>
                                </tr>
                            <?php
                            else :
                                // Jika data ada, tampilkan satu per satu
                                foreach ($dummy_mahasiswa_list as $mahasiswa) :
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($mahasiswa['nama']); ?></td>
                                        <td><?php echo htmlspecialchars($mahasiswa['program_studi']); ?></td>
                                        <td><?php echo htmlspecialchars($mahasiswa['status']); ?></td>
                                    </tr>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div> </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card bg-light p-4 shadow-sm border-0">
                    <div class="card-body">
                        <h3 class="card-title">Daftarkan Dirimu!</h3>
                        <p class="card-text">
                            Bagi kamu mahasiswa jurusan Teknologi Informasi yang ingin 
                            bergabung di laboratorium Software Engineering, 
                            Silahkan klik tombol Daftar Sekarang!
                        </p>
                        <a href="<?= BASE_URL ?>pages/recruitment.php" class="btn btn-secondary btn-lg">Daftar Sekarang</a>
                    </div>
                </div>
            </div>
        </div>

    </div> </main>
<?php
// Bagian 6: Memanggil Footer
include '../includes/footer.php'; //
?>