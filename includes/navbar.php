<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($meta_description ?? '') ?>">
    <meta name="keywords" content="<?= htmlspecialchars($meta_keywords ?? '') ?>">
    <meta name="author" content="LAB Software Engineering">
    
    <title><?= htmlspecialchars($page_title ?? '') ?> - <?= htmlspecialchars($site_title ?? '') ?></title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>assets/img/favicon.ico" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/bootstrap/css/bootstrap.min.css ?>">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>

<body>
    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg navbar-glass fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>index.php">
                <div class="d-flex align-items-center">
                    <div class="brand-icon">LAB</div>
                    <span class="ms-2 fw-bold">Software Engineering</span>
                </div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link nav-pill active" href="<?= BASE_URL ?>index.php">Beranda</a>
                    </li>

                    <!-- Dropdown Profil -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-pill dropdown-toggle" href="#" data-bs-toggle="dropdown">Profil</a>
                        <ul class="dropdown-menu dropdown-glass">
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>pages/profil.php">Tentang LAB SE</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>pages/visi_misi.php">Visi & Misi</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>pages/roadmap.php">Roadmap</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>pages/focus_scope.php">Focus & Scope</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown Personil -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-pill dropdown-toggle" href="#" data-bs-toggle="dropdown">Personil</a>
                        <ul class="dropdown-menu dropdown-glass">
                            <li><a class="dropdown-item" href="#">Dosen 1</a></li>
                            <li><a class="dropdown-item" href="#">Dosen 2</a></li>
                            <li><a class="dropdown-item" href="#">Dosen 3</a></li>
                            <li><a class="dropdown-item" href="#">Dosen 4</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown Requirement -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-pill dropdown-toggle" href="#" data-bs-toggle="dropdown">Requirement</a>
                        <ul class="dropdown-menu dropdown-glass">
                            <li><a class="dropdown-item" href="#">Daftar Mahasiswa</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>pages/recruitment_form.php">Form Pendaftaran</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-pill" href="<?= BASE_URL ?>pages/blog.php">Blog</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-primary-glass" href="<?= BASE_URL ?>includes/footer.php">
                            <i class="bi bi-person-plus me-1"></i> Contact
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Spacer biar konten tidak ketutup navbar -->
    <div style="height: 80px;"></div>

    <!-- ===== SCRIPTS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
