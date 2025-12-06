<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="index.php?action=dashboard">
                        <!-- <a href="index.html"><img
                                    src="/Lab_SE_Website/admin/assets/img/LAB SE_Outline.png"
                                    alt="Logo" srcset=""></a> -->
                        <h4 class="text-primary mb-0"><i class="bi bi-code-square"></i> Lab SE</h4>
                    </a>
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item">
                    <a href="index.php?action=dashboard" class='sidebar-link' data-key="dashboard">
                        <i class="bi bi-house-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-person-circle"></i>
                        <span>Manajemen Profil</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item">
                            <a href="index.php?action=tentang" class="submenu-link" data-key="tentang">Tentang LAB SE</a>
                        </li>
                        <li class="submenu-item">
                            <a href="index.php?action=visi_misi" class="submenu-link" data-key="visi_misi">Visi & Misi</a>
                        </li>
                        <li class="submenu-item">
                            <a href="index.php?action=roadmap" class="submenu-link" data-key="roadmap">Roadmap</a>
                        </li>
                        <li class="submenu-item">
                            <a href="index.php?action=focus_scope" class="submenu-link" data-key="focus_scope">Focus & Scope</a>
                        </li>
                    </ul>
                </li>


                <li class="sidebar-item has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Manajemen Personil</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item">
                            <a href="index.php?action=personil_list" class="submenu-link" data-key="personil_list">Daftar Personil</a>
                        </li>
                        <li class="submenu-item">
                            <a href="index.php?action=publikasi_list" class="submenu-link" data-key="publikasi_list">Daftar Publikasi</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-list-ul"></i>
                        <span>Manajemen Recruitment</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item">
                            <a href="index.php?action=mahasiswa_list" class="submenu-link" data-key="mahasiswa_list">Mahasiswa</a>
                        </li>
                        <li class="submenu-item">
                            <a href="index.php?action=recruitment_list" class="submenu-link" data-key="recruitment_list">Recruitment</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-newspaper"></i>
                        <span>Manajemen Berita</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item">
                            <a href="index.php?action=berita_list" class="submenu-link" data-key="berita_list">Daftar Berita</a>
                        </li>
                        <li class="submenu-item">
                            <a href="index.php?action=komentar_list" class="submenu-link" data-key="komentar_list">Komentar</a>
                        </li>
                        <li class="submenu-item">
                            <a href="index.php?action=social_media_settings" class="submenu-link" data-key="social_media_settings">Media Sosial</a>
                        </li>
                        <li class="submenu-item">
                            <a href="index.php?action=related_posts_settings" class="submenu-link" data-key="related_posts_settings">Related Posts</a>
                        </li>
                    </ul>
                </li>


                <li class="sidebar-title">Pengaturan</li>

                <li class="sidebar-item">
                    <a href="index.php?action=settings" class='sidebar-link' data-key="settings">
                        <i class="bi bi-gear-fill"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="index.php?action=footer_settings" class='sidebar-link' data-key="footer_settings">
                        <i class="bi bi-layout-text-window-reverse"></i>
                        <span>Pengaturan Footer</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="index.php?action=profil_settings" class='sidebar-link' data-key="profil_settings">
                        <i class="bi bi-house-door"></i>
                        <span>Pengaturan Beranda & Profil</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="index.php?action=logout" class='sidebar-link text-danger' onclick="return confirm('Yakin ingin logout?');">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Ambil parameter 'action' dari URL
        const urlParams = new URLSearchParams(window.location.search);
        const currentAction = urlParams.get('action') || 'dashboard'; // Default dashboard

        // 2. Cari link yang punya data-key sama dengan action saat ini
        const activeLink = document.querySelector(`[data-key="${currentAction}"]`);

        if (activeLink) {
            // 3. Tambahkan class active ke parent <li>
            const parentItem = activeLink.closest('.sidebar-item');
            if (parentItem) {
                parentItem.classList.add('active');
            }

            // 4. Jika ini adalah submenu, buka parent-nya juga
            const parentSubmenu = activeLink.closest('.submenu');
            if (parentSubmenu) {
                // Cari parent utamanya (sidebar-item has-sub)
                const mainParent = parentSubmenu.closest('.sidebar-item');
                if (mainParent) {
                    mainParent.classList.add('active');
                    parentSubmenu.style.display = 'block'; // Paksa buka submenu
                }
                // Tandai submenu item juga
                const submenuItem = activeLink.closest('.submenu-item');
                if (submenuItem) submenuItem.classList.add('active');
            }
        }
    });
</script>