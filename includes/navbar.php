<?php
include('header.php');
// Get current page - handle both direct access and included files
// Priority: REQUEST_URI > SCRIPT_NAME > PHP_SELF
if (!isset($current_page) || empty($current_page)) {
    // Try REQUEST_URI first (most reliable for detecting actual page)
    if (isset($_SERVER['REQUEST_URI'])) {
        $request_uri = $_SERVER['REQUEST_URI'];
        $path = parse_url($request_uri, PHP_URL_PATH);
        if ($path && $path !== '/') {
            $current_page = basename($path);
            // Remove query string if exists
            $current_page = strtok($current_page, '?');
            // If empty or just slash, try SCRIPT_NAME
            if (empty($current_page) || $current_page === '/') {
                if (isset($_SERVER['SCRIPT_NAME']) && !empty($_SERVER['SCRIPT_NAME'])) {
                    $current_page = basename($_SERVER['SCRIPT_NAME']);
                }
            }
        }
    }
    // Fallback to SCRIPT_NAME
    if ((empty($current_page) || $current_page === '/' || $current_page === 'navbar.php' || $current_page === 'header.php') && isset($_SERVER['SCRIPT_NAME'])) {
        $script_path = $_SERVER['SCRIPT_NAME'];
        $current_page = basename($script_path);
    }
    // Last resort: PHP_SELF
    if ((empty($current_page) || $current_page === 'navbar.php' || $current_page === 'header.php') && isset($_SERVER['PHP_SELF'])) {
        $current_page = basename($_SERVER['PHP_SELF']);
    }
    // Final fallback
    if (empty($current_page) || $current_page === 'navbar.php' || $current_page === 'header.php' || $current_page === '/') {
        $current_page = 'index.php';
    }
}
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
                    $profil_pages = ['profil.php', '#tentang', '#visi_misi', '#roadmap', '#focus_scope'];
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

        // Scroll Spy for Navbar Active State (only on index.php/beranda)
        document.addEventListener('DOMContentLoaded', function() {
            // Only run scroll spy if hero section exists (beranda page)
            const heroSection = document.getElementById('hero');
            if (!heroSection) {
                // Not on beranda page, let PHP handle active state
                // Don't interfere with PHP-set active classes
                return;
            }

            const navbar = document.getElementById('navbarNav');
            if (!navbar) return;
            
            const navLinks = navbar.querySelectorAll('.nav-link');
            const profilDropdown = navbar.querySelector('.nav-item.dropdown');
            const profilToggle = profilDropdown ? profilDropdown.querySelector('.dropdown-toggle') : null;
            const profilMenu = profilDropdown ? profilDropdown.querySelector('.dropdown-menu') : null;
            
            // Sections to spy on
            const sections = [
                { id: 'hero', link: 'index.php#hero', type: 'beranda' },
                { id: 'tentang', link: 'index.php#tentang', type: 'profil', submenu: 'tentang' },
                { id: 'visi_misi', link: 'index.php#visi_misi', type: 'profil', submenu: 'visi_misi' },
                { id: 'roadmap', link: 'index.php#roadmap', type: 'profil', submenu: 'roadmap' },
                { id: 'focus_scope', link: 'index.php#focus_scope', type: 'profil', submenu: 'focus_scope' }
            ];

            function updateActiveNav() {
                const scrollPos = window.scrollY + 150; // Offset for navbar height
                let activeSection = null;
                
                // Find which section is currently in view
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

                // Remove all active classes (only for scroll spy sections)
                navLinks.forEach(link => {
                    // Only remove active if it's beranda or profil link
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

                // Add active class based on current section
                if (activeSection) {
                    if (activeSection.type === 'beranda') {
                        // Active beranda
                        const berandaLink = navbar.querySelector('a[href*="#hero"]');
                        if (berandaLink) {
                            berandaLink.classList.add('active');
                        }
                    } else if (activeSection.type === 'profil') {
                        // Active profil dropdown
                        if (profilToggle) {
                            profilToggle.classList.add('active');
                            if (profilDropdown) profilDropdown.classList.add('active');
                        }
                        
                        // Active submenu item
                        if (profilMenu && activeSection.submenu) {
                            const submenuLink = profilMenu.querySelector(`a[href*="#${activeSection.submenu}"]`);
                            if (submenuLink) {
                                submenuLink.classList.add('active');
                            }
                        }
                    }
                } else {
                    // Default: check if we're past hero section
                    if (heroSection && scrollPos > heroSection.offsetTop + heroSection.offsetHeight) {
                        // We're in profil area but no specific section detected
                        if (profilToggle) {
                            profilToggle.classList.add('active');
                            if (profilDropdown) profilDropdown.classList.add('active');
                        }
                    } else {
                        // We're at the top, active beranda
                        const berandaLink = navbar.querySelector('a[href*="#hero"]');
                        if (berandaLink) {
                            berandaLink.classList.add('active');
                        }
                    }
                }
            }

            // Update on scroll
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

            // Update on page load
            updateActiveNav();

            // Update on hash change (when clicking nav links)
            window.addEventListener('hashchange', function() {
                setTimeout(updateActiveNav, 100);
            });
        });
    </script>