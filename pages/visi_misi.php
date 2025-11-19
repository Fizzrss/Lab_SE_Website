<?php
$page_title = 'Visi & Misi';
$current_page = 'visi_misi';
$meta_description = 'Visi dan Misi Laboratorium Software Engineering';

if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/pbl/');
}
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Visi Misi Content -->
<section class="visi-misi-content py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Visi -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-5">
                        <div class="card-item">

                            <h2 class="mb-4">Visi</h2>
                            <p class="lead text-muted mb-0">
                                Menjadi laboratorium software engineering terdepan yang menghasilkan
                                lulusan berkompeten, inovatif, dan profesional dalam bidang rekayasa
                                perangkat lunak untuk berkontribusi pada kemajuan teknologi informasi
                                di Indonesia.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Misi -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-5">
                        <div class="card-item">
                            <h2 class="mb-4">Misi</h2>
                            <ol class="misi-list lead text-muted ps-3">
                                <li class="mb-0">
                                    <p class="mb-0">
                                        Menyelenggarakan pendidikan dan pelatihan berkualitas dalam
                                        bidang software engineering
                                    </p>
                                </li>
                                <li class="mb-0">
                                    <p class="mb-0">
                                        Mengembangkan penelitian dan inovasi dalam rekayasa perangkat lunak
                                    </p>
                                </li>
                                <li class="mb-0">
                                    <p class="mb-0">
                                        Membangun kolaborasi dengan industri dan institusi lain
                                    </p>
                                </li>
                                <li class="mb-0">
                                    <p class="mb-0">
                                        Menghasilkan produk software yang bermanfaat bagi masyarakat
                                    </p>
                                </li>
                                <li class="mb-0">
                                    <p class="mb-0">
                                        Membentuk komunitas developer yang solid dan profesional
                                    </p>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>