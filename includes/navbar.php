<?php
include('header.php');
$current_page = basename($_SERVER['PHP_SELF']);
?>

<body>
    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg navbar-glass fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>index.php">
                <div class="d-flex align-items-center">
                    <div class="logo-icon"><img src="<?= BASE_URL ?>assets/img/logo_lab.png" alt="Logo LAB SE"></div>
                    <span class="ms-2 fw-bold">Software Engineering</span>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <!-- Beranda -->
                    <li class="nav-item">
                        <a class="nav-link nav-pill <?= ($current_page === 'index.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>index.php#hero">Beranda</a>
                    </li>

                    <!-- Dropdown Profil -->
                    <?php
                    $profil_pages = ['profil.php','#tentang', '#visi_misi', '#roadmap', '#focus_scope'];
                    $is_profil_active = in_array($current_page, $profil_pages);
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-pill dropdown-toggle <?= $is_profil_active ? 'active' : '' ?>" href="#profil">
                            Profil
                        </a>
                        <ul class="dropdown-menu dropdown-glass">
                            
                            <li><a class="dropdown-item <?= ($current_page === 'profil.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>index.php#tentang">Tentang LAB SE</a></li>
                            <li><a class="dropdown-item <?= ($current_page === 'profil.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>index.php#visi_misi">Visi & Misi</a></li>
                            <li><a class="dropdown-item <?= ($current_page === 'profil.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>index.php#roadmap">Roadmap</a></li>
                            <li><a class="dropdown-item <?= ($current_page === 'profil.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>index.php#focus_scope">Focus & Scope</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown Personil -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-pill <?= ($current_page === 'personil.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>pages/personil.php">
                            Personil
                        </a>
                    </li>

                    <!-- Dropdown Requirement -->
                    <?php
                    $req_pages = ['mahasiswa_list.php', 'recruitment_form.php'];
                    $is_req_active = in_array($current_page, $req_pages);
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-pill dropdown-toggle <?= $is_req_active ? 'active' : '' ?>" href="#">
                            Daftar
                        </a>
                        <ul class="dropdown-menu dropdown-glass">
                            <li><a class="dropdown-item <?= ($current_page === 'mahasiswa_list.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>pages/mahasiswa_list.php">Daftar Mahasiswa</a></li>
                            <li><a class="dropdown-item <?= ($current_page === 'recruitment_form.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>pages/recruitment_form.php">Form Pendaftaran</a></li>
                        </ul>
                    </li>

                    <!-- Blog -->
                    <li class="nav-item">
                        <a class="nav-link nav-pill <?= ($current_page === 'blog.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>pages/blog.php">Blog</a>
                    </li>

                    <!-- Contact -->
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-primary-glass bi bi-graph-up" href="<?= BASE_URL ?>pages/statistik.php"> Statistik</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Spacer biar konten tidak ketutup navbar -->
    <div style="height: 80px;"></div>

    <!-- ===== SCRIPTS ===== -->
    <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar-glass');
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });

        // Hover dropdown (auto show)
        document.querySelectorAll('.dropdown').forEach(dropdown => {
            dropdown.addEventListener('mouseenter', function() {
                if (window.innerWidth >= 992) {
                    const menu = this.querySelector('.dropdown-menu');
                    const bsDropdown = bootstrap.Dropdown.getOrCreateInstance(this.querySelector('.dropdown-toggle'));
                    bsDropdown.show();
                }
            });
            dropdown.addEventListener('mouseleave', function() {
                if (window.innerWidth >= 992) {
                    const bsDropdown = bootstrap.Dropdown.getOrCreateInstance(this.querySelector('.dropdown-toggle'));
                    bsDropdown.hide();
                }
            });
        });
    </script>