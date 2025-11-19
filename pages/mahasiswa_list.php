<?php
/*
|--------------------------------------------------------------------------
| File: pages/mahasiswa_list.php (Header "Nama" rata kiri)
|--------------------------------------------------------------------------
| 1. Header <th> "Nama" dikembalikan ke rata kiri.
| 2. Header "Program Studi" & "Status" tetap di tengah.
| 3. Tombol CTA dan Hero Banner tetap.
*/

// Bagian 1: Konfigurasi (Wajib paling atas)
require_once '../includes/config.php';

// Bagian 2: SET JUDUL HALAMAN
$page_title = "Daftar Mahasiswa"; 

// Bagian 3: Cangkang Atas
include '../includes/header.php'; 
include '../includes/navbar.php'; 

// Bagian 4: DATA DUMMY
$dummy_mahasiswa_list = [
    [ "nama" => "Ahmad Fauzi (Dummy)", "program_studi" => "D-IV SIB", "status" => "Aktif" ],
    [ "nama" => "Siti Nurhaliza (Dummy)", "program_studi" => "D-IV SIB", "status" => "Aktif" ],
    [ "nama" => "Budi Santoso (Dummy)", "program_studi" => "D-IV TI", "status" => "Aktif" ],
    [ "nama" => "Dewi Lestari (Dummy)", "program_studi" => "D-IV SIB", "status" => "Alumni" ]
];
?>

<style>
    /* 1. CSS Hero Banner */
    .page-hero-banner {
        background-color: var(--accent-color, #6096B4); 
        color: var(--contrast-color, #ffffff);
        padding: 3rem 1.5rem;
        text-align: center;
    }
    .page-hero-banner h1 {
        font-family: var(--heading-font);
        color: var(--contrast-color, #ffffff);
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    .page-hero-banner p {
        color: var(--contrast-color, #ffffff);
        opacity: 0.9;
        font-size: 1.1rem;
        margin-bottom: 0;
    }

    /* 2. CSS Penengah Isi Tabel */
    td.cell-center {
        text-align: center;
    }

    /* 3. CSS HEADER TABEL */
    .thead-custom-accent {
        background-color: var(--accent-color);
        color: var(--contrast-color);
    }

    /* 4. CSS TOMBOL CTA */
    .btn-custom-accent {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        color: var(--contrast-color);
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.5rem;
        transition: all 0.3s ease-in-out; 
        text-decoration: none;
    }

    /* 5. CSS HOVER TOMBOL CTA */
    .btn-custom-accent:hover {
        background-color: color-mix(in srgb, var(--accent-color), black 10%); 
        border-color: color-mix(in srgb, var(--accent-color), black 10%);
        color: var(--contrast-color);
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
</style>


<section class="page-hero-banner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Daftar Mahasiswa Lab SE</h1>
                <p>Mahasiswa aktif yang tergabung dalam Laboratorium Software Engineering.</p>
            </div>
        </div>
    </div>
</section>

<main>
    <div class="container my-5">

        <div class="row mb-5">
            <div class="col-12">
                <div class="card card-floating">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            
                            <thead class="thead-custom-accent">
                                <tr>
                                    <th scope="col" style="padding: 1.2rem;">Nama</th>
                                    
                                    <th scope="col" class="text-center" style="padding: 1.2rem;">Program Studi</th>
                                    <th scope="col" class="text-center" style="padding: 1.2rem;">Status</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php
                                if (empty($dummy_mahasiswa_list)) :
                                ?>
                                    <tr>
                                        <td colspan="3" class="text-center p-3">
                                            Data mahasiswa belum tersedia saat ini.
                                        </td>
                                    </tr>
                                <?php
                                else :
                                    foreach ($dummy_mahasiswa_list as $mahasiswa) :
                                    ?>
                                        <tr style="vertical-align: middle;">
                                            <td style="padding: 1.2rem;"><?php echo htmlspecialchars($mahasiswa['nama']); ?></td>
                                            
                                            <td class="cell-center" style="padding: 1.2rem;"><?php echo htmlspecialchars($mahasiswa['program_studi']); ?></td>
                                            <td class="cell-center" style="padding: 1.2rem;"><?php echo htmlspecialchars($mahasiswa['status']); ?></td>
                                        </tr>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div> </div> </div> </div> <div class="row">
            <div class="col-12">
                <div class="card card-floating bg-light p-4">
                    <div class="card-body">
                        <h3 class="card-title" style="font-family: var(--heading-font);">Daftarkan Dirimu!</h3>
                        <p class="card-text">
                            Bagi kamu mahasiswa jurusan Teknologi Informasi yang ingin 
                            bergabung di laboratorium Software Engineering, 
                            Silahkan klik tombol Daftar Sekarang!
                        </p>
                        <a href="<?= BASE_URL ?>pages/recruitment_form.php" class="btn btn-lg mt-2 btn-custom-accent">
                           Daftar Sekarang
                        </a>
                    </div>
                </div>
            </div> </div> </div> </main>
<?php
// Bagian 8: Memanggil Footer
include '../includes/footer.php';
?>