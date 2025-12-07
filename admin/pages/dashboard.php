<style>
    /* CUSTOM CSS DASHBOARD MODERN */
    .banner-welcome {
        background: linear-gradient(135deg, #435ebe 0%, #25396f 100%);
        border-radius: 20px;
        color: white;
        border: none;
        box-shadow: 0 10px 30px rgba(67, 94, 190, 0.3);
        position: relative;
        overflow: hidden;
    }

    /* Hiasan Lingkaran Background */
    .banner-welcome::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .card-stat {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s;
    }

    .card-stat:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
</style>

<div class="page-content">

    <div class="row mb-4">
        <div class="col-12">
            <div class="card banner-welcome">
                <div class="card-body p-4 p-lg-5 d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="text-white fw-bold">Dashboard Admin</h2>
                        <p class="mb-0 text-white-50 fs-5">
                            Halo <strong><?= $_SESSION['username'] ?? 'Admin' ?></strong>, Selamat Datang
                            di Dashboard Admin Laboratorium Software Engineering.
                            <?php if ($jml_pending > 0): ?>
                        <div class="mt-3">
                            <a href="index.php?action=recruitment_list" class="btn btn-warning text-dark fw-bold rounded-pill px-4">
                                <i class="bi bi-bell-fill me-2"></i> <?= $jml_pending ?> Pendaftar Menunggu
                            </a>
                        </div>
                    <?php endif; ?>
                    </p>
                    </div>
                    <div class="d-none d-md-block">
                        <i class="bi bi-bar-chart-line text-white opacity-25" style="font-size: 5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5 g-4 mb-4">

        <div class="col">
            <div class="card card-stat">
                <div class="card-body px-3 py-4 d-flex align-items-center">
                    <div class="stat-icon bg-light-warning text-warning me-3">
                        <i class="bi bi-eye-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small fw-bold text-uppercase">Visitor today</h6>
                        <h4 class="mb-0"><?= $jml_visitor ?? 0 ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card card-stat">
                <div class="card-body px-3 py-4 d-flex align-items-center">
                    <div class="stat-icon bg-light-danger text-danger me-3">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small fw-bold text-uppercase">Pending</h6>
                        <h4 class="mb-0"><?= $jml_pending ?? 0 ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card card-stat">
                <div class="card-body px-3 py-4 d-flex align-items-center">
                    <div class="stat-icon bg-light-success text-success me-3">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small fw-bold text-uppercase">Mahasiswa</h6>
                        <h4 class="mb-0"><?= $jml_mahasiswa ?? 0 ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card card-stat">
                <div class="card-body px-3 py-4 d-flex align-items-center">
                    <div class="stat-icon bg-light-primary text-primary me-3">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small fw-bold text-uppercase">Personil</h6>
                        <h4 class="mb-0"><?= $jml_personil ?? 0 ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card card-stat">
                <div class="card-body px-3 py-4 d-flex align-items-center">
                    <div class="stat-icon bg-light-info text-info me-3">
                        <i class="bi bi-journal-bookmark-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small fw-bold text-uppercase">Publikasi</h6>
                        <h4 class="mb-0"><?= $jml_publikasi ?? 0 ?></h4>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-3">
        <div class="col-12 col-lg-8">
            <div class="card card-stat mb-4">
                <div class="card-header bg-transparent border-0">
                    <h5 class="card-title">Tren Produktivitas Publikasi</h5>
                </div>
                <div class="card-body">
                    <div id="chart-publikasi"></div>
                </div>
            </div>

            <div class="card card-stat">
                <div class="card-header bg-transparent border-0">
                    <h5 class="card-title">Mahasiswa per Angkatan</h5>
                </div>
                <div class="card-body">
                    <div id="chart-angkatan"></div>
                </div>
            </div>

                <div class="card card-stat">
                    <div class="card-header bg-transparent border-0 pt-4 pb-0">
                        <h5 class="card-title mb-0">Top Keahlian Personil</h5>
                    </div>
                    <div class="card-body">
                        <div id="chart-spesialisasi"></div>
                    </div>
                </div>
        </div>

        <div class="col-12 col-lg-4">

            <div class="card card-stat mb-4">
                <div class="card-body text-center py-5">
                    <div class="avatar avatar-xl mb-3">
                        <img src="assets/compiled/jpg/1.jpg" alt="Admin" class="rounded-circle shadow-sm">
                    </div>
                    <h5 class="mb-0"><?= $_SESSION['username'] ?></h5>
                    <p class="text-muted small">Administrator Lab SE</p>
                    <a href="index.php?action=logout" class="btn btn-sm btn-outline-danger mt-2 rounded-pill px-4">Logout</a>
                </div>
            </div>
            <div class="card card-stat">
                <div class="card-header bg-transparent border-0 pt-4 pb-0">
                    <h5 class="card-title mb-0">Mahasiswa per Prodi</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div id="chart-donut-prodi" style="width: 100%; min-height: 250px;"></div>
                </div>
            </div>

            <div class="card card-stat">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Pendaftar Baru</h5>
                    <a href="index.php?action=recruitment_list" class="small text-decoration-none">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                <?php if (!empty($recent_applicants)): ?>
                                    <?php foreach ($recent_applicants as $row): ?>
                                        <tr>
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm bg-light-primary text-primary me-3">
                                                        <?= strtoupper(substr($row['nama'], 0, 1)) ?>
                                                    </div>
                                                    <div>
                                                        <h6 class="text-dark mb-0 text-sm"><?= htmlspecialchars($row['nama']) ?></h6>
                                                        <small class="text-muted" style="font-size: 11px;"><?= htmlspecialchars($row['prodi']) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-end">
                                                <a href="index.php?action=recruitment_detail&id=<?= $row['id'] ?>" class="btn btn-sm btn-light text-secondary">
                                                    <i class="bi bi-chevron-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td class="text-center py-4 text-muted small">Tidak ada pendaftar baru.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="/Lab_SE_Website/admin/assets/extensions/apexcharts/apexcharts.min.js"></script>

<script>
    // --- Data dari PHP ke JS ---
    <?php
    // Prepare Data Publikasi
    $pub_tahun = [];
    $pub_total = [];
    foreach ($chart_publikasi as $p) {
        $pub_tahun[] = $p['tahun'];
        $pub_total[] = $p['total'];
    }

    // Prepare Data Mahasiswa
    $mhs_angkatan = [];
    $mhs_total = [];
    foreach ($chart_mahasiswa as $m) {
        $mhs_angkatan[] = "Angkatan " . $m['angkatan'];
        $mhs_total[] = $m['total'];
    }

    $prodi_labels = [];
    $prodi_total = [];
    if (isset($chart_prodi)) {
        foreach ($chart_prodi as $p) {
            // Singkat nama prodi
            $label = $p['prodi'];
            if (strpos($p['prodi'], 'Informatika') !== false) $label = 'TI';
            elseif (strpos($p['prodi'], 'Bisnis') !== false) $label = 'SIB';

            $prodi_labels[] = $label;
            $prodi_total[] = $p['total'];
        }
    }

    $spec_labels = []; 
        $spec_total = [];
        if(isset($chart_spesialisasi)) {
            foreach($chart_spesialisasi as $s) {
                $spec_labels[] = $s['nama_spesialisasi'];
                $spec_total[] = $s['total'];
            }
        }
    ?>

    // --- CHART 1: PUBLIKASI (Area) ---
    var optionsPub = {
        series: [{
            name: 'Jumlah Publikasi',
            data: <?= json_encode($pub_total) ?>
        }],
        chart: {
            type: 'area',
            height: 250,
            toolbar: {
                show: false
            }
        },
        colors: ['#435ebe'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            categories: <?= json_encode($pub_tahun) ?>
        },
    };
    var chartPub = new ApexCharts(document.querySelector("#chart-publikasi"), optionsPub);
    chartPub.render();

    // --- CHART 2: MAHASISWA (Bar) ---
    var optionsMhs = {
        series: [{
            name: 'Mahasiswa',
            data: <?= json_encode($mhs_total) ?>
        }],
        chart: {
            type: 'bar',
            height: 250,
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: true
            }
        },
        colors: ['#57caeb'],
        dataLabels: {
            enabled: true
        },
        xaxis: {
            categories: <?= json_encode($mhs_angkatan) ?>
        },
    };
    var chartMhs = new ApexCharts(document.querySelector("#chart-angkatan"), optionsMhs);
    chartMhs.render();

    var optionsSpec = {
        series: [{
            name: 'Jumlah Personil',
            data: <?= json_encode($spec_total) ?>
        }],
        chart: {
            type: 'bar', // Tipe Bar
            height: 250,
            toolbar: { show: false },
            fontFamily: 'Nunito'
        },
        plotOptions: {
            bar: {
                horizontal: false, // Tegak Lurus (Vertical)
                columnWidth: '50%', // Lebar batang sedang
                borderRadius: 4
            }
        },
        colors: ['#435ebe'], // Warna Biru Mazer (Sama seperti gambar referensi)
        dataLabels: {
            enabled: false // Angka disembunyikan agar bersih
        },
        xaxis: {
            categories: <?= json_encode($spec_labels) ?>,
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            show: true,
            tickAmount: 5 // Agar angka sumbu Y tidak terlalu rapat
        },
        grid: { 
            borderColor: '#f1f1f1',
            xaxis: { lines: { show: false } } // Hilangkan garis vertikal grid
        },
        tooltip: {
            y: { formatter: function (val) { return val + " orang" } }
        }
    };
    new ApexCharts(document.querySelector("#chart-spesialisasi"), optionsSpec).render();

    var optionsDonut = {
        series: <?= json_encode($prodi_total) ?>,
        chart: {
            type: 'donut',
            height: 300,
            fontFamily: 'Nunito'
        },
        labels: <?= json_encode($prodi_labels) ?>,
        colors: ['#435ebe', '#57caeb', '#ff7976', '#9694ff'],
        plotOptions: {
            pie: {
                donut: {
                    size: '65%'
                }
            }
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center'
        }
    };
    new ApexCharts(document.querySelector("#chart-donut-prodi"), optionsDonut).render();
</script>