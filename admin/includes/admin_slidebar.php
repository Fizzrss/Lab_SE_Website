<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header text-center">
            <div class="d-flex flex-column align-items-center">
                <div class="logo">
                    <a href="index.php?action=dashboard">
                        <img src="/Lab_SE_Website/admin/assets/img/LAB SE_Outline.png" alt="Lab SE Logo">
                        <h6 class="text-primary text-center">Software Engineering</h6>
                    </a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <!-- DASHBOARD -->
                <li class="sidebar-item" data-key="dashboard">
                    <a href="index.php?action=dashboard" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <hr>
                <!-- MANAJEMEN DATA -->
                <li class="sidebar-title">Manajemen Data</li>

                <li class="sidebar-item has-sub" data-key="personil">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Personil</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item" data-key="personil_list">
                            <a href="index.php?action=personil_list" class="submenu-link">Daftar Personil</a>
                        </li>
                        <li class="submenu-item" data-key="publikasi_list">
                            <a href="index.php?action=publikasi_list" class="submenu-link">Publikasi</a>
                        </li>
                        <li class="submenu-item" data-key="spesialisasi_list">
                            <a href="index.php?action=spesialisasi_list" class="submenu-link">Spesialisasi</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub" data-key="mahasiswa">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-mortarboard-fill"></i>
                        <span>Mahasiswa</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item" data-key="mahasiswa_list">
                            <a href="index.php?action=mahasiswa_list" class="submenu-link">Data Mahasiswa</a>
                        </li>
                        <li class="submenu-item" data-key="recruitment_list">
                            <a href="index.php?action=recruitment_list" class="submenu-link">Recruitment</a>
                        </li>
                    </ul>
                </li>

                <hr>
                <!-- KONTEN & PUBLIKASI -->
                <li class="sidebar-title">Konten & Publikasi</li>

                <li class="sidebar-item has-sub" data-key="berita">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-newspaper"></i>
                        <span>Berita</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item" data-key="berita_list">
                            <a href="index.php?action=berita_list" class="submenu-link">Daftar Berita</a>
                        </li>
                        <li class="submenu-item" data-key="komentar_list">
                            <a href="index.php?action=komentar_list" class="submenu-link">Komentar</a>
                        </li>
                        <li class="submenu-item" data-key="berita_hero_settings">
                            <a href="index.php?action=berita_hero_settings" class="submenu-link">Hero Banner</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub" data-key="content">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-file-earmark-text-fill"></i>
                        <span>Konten Lainnya</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item" data-key="related_posts_settings">
                            <a href="index.php?action=related_posts_settings" class="submenu-link">Related Posts</a>
                        </li>
                        <li class="submenu-item" data-key="social_media_settings">
                            <a href="index.php?action=social_media_settings" class="submenu-link">Media Sosial</a>
                        </li>
                    </ul>
                </li>

                <hr>
                <!-- PENGATURAN WEBSITE -->
                <li class="sidebar-title">Pengaturan</li>

                <li class="sidebar-item has-sub" data-key="settings">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-gear-fill"></i>
                        <span>Website</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item" data-key="profil_settings">
                            <a href="index.php?action=profil_settings" class="submenu-link">Beranda & Profil</a>
                        </li>
                        <li class="submenu-item" data-key="footer_settings">
                            <a href="index.php?action=footer_settings" class="submenu-link">Footer</a>
                        </li>
                    </ul>
                </li>

                <!-- LOGOUT -->
                <!-- <li class="sidebar-title">Akun</li>
                
                <li class="sidebar-item">
                    <a href="index.php?action=logout" class='sidebar-link' onclick="return confirm('Apakah Anda yakin ingin keluar?');">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li> -->

            </ul>
        </div>
        <div class="sidebar-footer">
            <a href="#" id="btnLogout" class="sidebar-link text-danger">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
</div>

<script src="/Lab_SE_Website/admin/vendor/jquery/jquery.min.js"></script>
<script src="/Lab_SE_Website/admin/assets/extensions/sweetalert2/sweetalert2.all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const currentAction = urlParams.get('action') || 'dashboard';

        document.querySelectorAll('.sidebar-item').forEach(item => {
            item.classList.remove('active');
        });
        document.querySelectorAll('.submenu-item').forEach(item => {
            item.classList.remove('active');
        });

        const activeItem = document.querySelector(`[data-key="${currentAction}"]`);

        if (activeItem) {
            activeItem.classList.add('active');

            if (activeItem.classList.contains('submenu-item')) {
                const parentItem = activeItem.closest('.sidebar-item.has-sub');
                if (parentItem) {
                    parentItem.classList.add('active');
                }
            }
        }

        const menuItems = document.querySelectorAll('.sidebar-item.has-sub > a');
        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                this.parentElement.classList.toggle('active');
            });
        });
    });

    document.getElementById('btnLogout').addEventListener('click', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Logout?',
        text: 'Anda yakin ingin keluar dari sistem?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'index.php?action=logout';
        }
    });
});
</script>