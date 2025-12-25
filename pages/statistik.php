<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';

require_once $root . '/controllers/StatistikController.php';

$statsController = new StatistikController();

$dataStats = $statsController->getStats();

extract($dataStats);

$page_title = "Statistik - Lab SE";
require_once $root . '/includes/header.php';
?>

<main>
    <section id="stats" class="stats section light-background">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">

                <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                    <i class="bi bi-people-fill"></i>
                    <div class="stats-item">
                        <p>Pendaftar</p>
                        <span data-purecounter-start="0" data-purecounter-end="<?= $jml_pendaftar ?>" data-purecounter-duration="1" class="purecounter"></span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                    <i class="bi bi-journal-richtext"></i>
                    <div class="stats-item">
                        <p>Personil</p>
                        <span data-purecounter-start="0" data-purecounter-end="<?= $jml_personil ?>" data-purecounter-duration="1" class="purecounter"></span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                    <i class="bi bi-people"></i>
                    <div class="stats-item">
                        <p>Mahasiswa Aktif</p>
                        <span data-purecounter-start="0" data-purecounter-end="<?= $jml_mahasiswa ?>" data-purecounter-duration="1" class="purecounter"></span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                    <i class="bi bi-file-earmark-post"></i>
                    <div class="stats-item">
                        <p>Publikasi</p>
                        <span data-purecounter-start="0" data-purecounter-end="<?= $jml_publikasi ?>" data-purecounter-duration="1" class="purecounter"></span>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
