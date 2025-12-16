<?php
include('header.php');
if (!isset($current_page) || empty($current_page)) {
    if (isset($_SERVER['REQUEST_URI'])) {
        $request_uri = $_SERVER['REQUEST_URI'];
        $path = parse_url($request_uri, PHP_URL_PATH);
        if ($path && $path !== '/') {
            $current_page = basename($path);
            $current_page = strtok($current_page, '?');
            if (empty($current_page) || $current_page === '/') {
                if (isset($_SERVER['SCRIPT_NAME']) && !empty($_SERVER['SCRIPT_NAME'])) {
                    $current_page = basename($_SERVER['SCRIPT_NAME']);
                }
            }
        }
    }

    if ((empty($current_page) || $current_page === '/' || $current_page === 'navbar.php' || $current_page === 'header.php') && isset($_SERVER['SCRIPT_NAME'])) {
        $script_path = $_SERVER['SCRIPT_NAME'];
        $current_page = basename($script_path);
    }

    if ((empty($current_page) || $current_page === 'navbar.php' || $current_page === 'header.php') && isset($_SERVER['PHP_SELF'])) {
        $current_page = basename($_SERVER['PHP_SELF']);
    }

    if (empty($current_page) || $current_page === 'navbar.php' || $current_page === 'header.php' || $current_page === '/') {
        $current_page = 'index.php';
    }
}
?>

<body>
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
                    $profil_pages = ['profil.php', '#tentang', '#visi_misi', '#roadmap', '#focus_scope'];
                    $is_profil_active = in_array($current_page, $profil_pages);
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-pill dropdown-toggle <?= $is_profil_active ? 'active' : '' ?>"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Profil
                        </a>
                        <ul class="dropdown-menu dropdown-glass" aria-labelledby="dropdownProfil">
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php#tentang">Tentang LAB SE</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php#visi_misi">Visi & Misi</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php#roadmap">Roadmap</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php#focus_scope">Focus & Scope</a></li>
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
                        <a class="nav-link nav-pill dropdown-toggle <?= $is_req_active ? 'active' : '' ?>"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Daftar
                        </a>
                        <ul class="dropdown-menu dropdown-glass" aria-labelledby="dropdownDaftar">
                            <li><a class="dropdown-item <?= ($current_page === 'mahasiswa_list.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>pages/mahasiswa_list.php">Daftar Mahasiswa</a></li>
                            <li><a class="dropdown-item <?= ($current_page === 'recruitment_form.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>pages/recruitment_form.php">Form Pendaftaran</a></li>
                        </ul>
                    </li>

                    <!-- Berita -->
                    <?php
                    $berita_pages = ['berita.php', 'berita_detail.php'];
                    $is_berita_active = in_array($current_page, $berita_pages);
                    ?>
                    <li class="nav-item">
                        <a class="nav-link nav-pill <?= $is_berita_active ? 'active' : '' ?>" href="<?= BASE_URL ?>pages/berita.php">Berita</a>
                    </li>

                    <!-- Statistik -->
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-primary-glass nav-link nav-pill <?= ($current_page === 'profil.php') ? 'active' : '' ?>" href="<?= BASE_URL ?>index.php#statistik"> Statistik</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="height: 80px;"></div>

    <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar-glass');
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });

        // Hover dropdown (auto show) - Desktop only
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

            // Mobile: Handle click on dropdown toggle
            const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
            if (dropdownToggle) {
                dropdownToggle.addEventListener('click', function(e) {
                    if (window.innerWidth < 992) {
                        e.preventDefault();
                        e.stopPropagation();
                        const bsDropdown = bootstrap.Dropdown.getOrCreateInstance(this);
                        bsDropdown.toggle();
                    }
                });
            }
        });

        // Mobile: Close dropdown when clicking menu item
        document.querySelectorAll('.dropdown-menu .dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    // Close the dropdown
                    const dropdown = this.closest('.dropdown');
                    if (dropdown) {
                        const bsDropdown = bootstrap.Dropdown.getInstance(dropdown.querySelector('.dropdown-toggle'));
                        if (bsDropdown) {
                            bsDropdown.hide();
                        }
                    }
                    // Close navbar collapse
                    const navbarCollapse = document.getElementById('navbarNav');
                    if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                        const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                        if (bsCollapse) {
                            bsCollapse.hide();
                        }
                    }
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const heroSection = document.getElementById('hero');
            if (!heroSection) {
                return;
            }

            const navbar = document.getElementById('navbarNav');
            if (!navbar) return;

            const navLinks = navbar.querySelectorAll('.nav-link');
            const profilDropdown = navbar.querySelector('.nav-item.dropdown');
            const profilToggle = profilDropdown ? profilDropdown.querySelector('.dropdown-toggle') : null;
            const profilMenu = profilDropdown ? profilDropdown.querySelector('.dropdown-menu') : null;

            // Sections to spy on
            const sections = [{
                    id: 'hero',
                    link: 'index.php#hero',
                    type: 'beranda'
                },
                {
                    id: 'tentang',
                    link: 'index.php#tentang',
                    type: 'profil',
                    submenu: 'tentang'
                },
                {
                    id: 'visi_misi',
                    link: 'index.php#visi_misi',
                    type: 'profil',
                    submenu: 'visi_misi'
                },
                {
                    id: 'roadmap',
                    link: 'index.php#roadmap',
                    type: 'profil',
                    submenu: 'roadmap'
                },
                {
                    id: 'focus_scope',
                    link: 'index.php#focus_scope',
                    type: 'profil',
                    submenu: 'focus_scope'
                }
            ];

            function updateActiveNav() {
                const scrollPos = window.scrollY + 150;
                let activeSection = null;

                sections.forEach(section => {
                    const element = document.getElementById(section.id);
                    if (element) {
                        const offsetTop = element.offsetTop;
                        const offsetHeight = element.offsetHeight;

                        if (scrollPos >= offsetTop && scrollPos < offsetTop + offsetHeight) {
                            activeSection = section;
                        }
                    }
                });

                navLinks.forEach(link => {
                    const href = link.getAttribute('href') || '';
                    if (href.includes('#hero') || href.includes('#profil') || href.includes('#tentang') ||
                        href.includes('#visi_misi') || href.includes('#roadmap') || href.includes('#focus_scope')) {
                        link.classList.remove('active');
                        const parent = link.closest('.nav-item');
                        if (parent) parent.classList.remove('active');
                    }
                });

                if (profilMenu) {
                    profilMenu.querySelectorAll('.dropdown-item').forEach(item => {
                        item.classList.remove('active');
                    });
                }

                if (activeSection) {
                    if (activeSection.type === 'beranda') {
                        const berandaLink = navbar.querySelector('a[href*="#hero"]');
                        if (berandaLink) {
                            berandaLink.classList.add('active');
                        }
                    } else if (activeSection.type === 'profil') {
                        if (profilToggle) {
                            profilToggle.classList.add('active');
                            if (profilDropdown) profilDropdown.classList.add('active');
                        }
                        if (profilMenu && activeSection.submenu) {
                            const submenuLink = profilMenu.querySelector(`a[href*="#${activeSection.submenu}"]`);
                            if (submenuLink) {
                                submenuLink.classList.add('active');
                            }
                        }
                    }
                } else {
                    if (heroSection && scrollPos > heroSection.offsetTop + heroSection.offsetHeight) {
                        if (profilToggle) {
                            profilToggle.classList.add('active');
                            if (profilDropdown) profilDropdown.classList.add('active');
                        }
                    } else {
                        const berandaLink = navbar.querySelector('a[href*="#hero"]');
                        if (berandaLink) {
                            berandaLink.classList.add('active');
                        }
                    }
                }
            }

            let ticking = false;
            window.addEventListener('scroll', function() {
                if (!ticking) {
                    window.requestAnimationFrame(function() {
                        updateActiveNav();
                        ticking = false;
                    });
                    ticking = true;
                }
            });

            updateActiveNav();

            window.addEventListener('hashchange', function() {
                setTimeout(updateActiveNav, 100);
            });
        });
    </script>