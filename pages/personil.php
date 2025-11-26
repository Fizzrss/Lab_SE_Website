<?php
// 1. SETUP PATH ABSOLUT (Agar file config pasti ketemu)
$root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';

// 2. PANGGIL CONFIG & DATABASE
require_once $root . '/config/config.php';

// Inisialisasi Koneksi Database (PENTING: Ini yang kurang di kodemu sebelumnya)
$database = new Database();
$db = $database->getConnection();

// Judul Halaman
$page_title = "Daftar Personil - Lab SE";

// 3. PANGGIL HEADER & NAVBAR
require_once $root . '/includes/header.php';
require_once $root . '/includes/navbar.php';

// 4. LOGIKA PENGAMBILAN DATA
// =======================================================
$all_personnel = [];

if ($db) { // Cek apakah koneksi $db berhasil
    try {
        // QUERY: Gabungkan tabel personil dengan jabatan
        // Catatan: Saya sesuaikan nama tabel jabatan jadi 'jabatan' (sesuai standar umum)
        // Jika tabelmu namanya 'personil_jabatan', silakan ubah query di bawah.
        $sql_personnel = "
            SELECT 
                p.id_personil, 
                p.nama_personil, 
                p.foto_personil,
                j.nama_jabatan AS peran
            FROM personil p
            LEFT JOIN jabatan j ON p.id_jabatan = j.id_jabatan
            ORDER BY p.id_jabatan ASC, p.nama_personil ASC
        ";

        $stmt = $db->query($sql_personnel);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            
            // --- Query Spesialisasi (Ambil 1 saja buat preview) ---
            $sql_spec = "
                SELECT s.nama_spesialisasi 
                FROM personil_spesialisasi ps
                JOIN spesialisasi s ON ps.id_spesialisasi = s.id_spesialisasi
                WHERE ps.id_personil = :id
                LIMIT 1
            ";
            $stmt_spec = $db->prepare($sql_spec);
            $stmt_spec->execute([':id' => $row['id_personil']]);
            $spesialisasi = $stmt_spec->fetchColumn(); 

            // Cek Foto (Jika kosong, pakai default)
            $foto_path = !empty($row['foto_personil']) ? $row['foto_personil'] : 'default_avatar.png';

            // Masukkan ke array data
            $all_personnel[] = [
                'id' => $row['id_personil'],
                'nama' => $row['nama_personil'],
                'peran' => $row['peran'] ?? 'Anggota', // Default jika jabatan null
                'foto' => BASE_URL . 'assets/img/personil/' . $foto_path, // Pastikan folder personil ada
                'spesialisasi' => $spesialisasi ?: 'Software Engineering' // Default jika kosong
            ];
        }

    } catch (PDOException $e) {
        echo "<div class='container mt-5'><div class='alert alert-danger'>Error Query: " . $e->getMessage() . "</div></div>";
    }
} else {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Gagal terhubung ke Database!</div></div>";
}
?>

<header class="header text-center py-5 text-white" style="background-color: #6096B4;">
    <div class="container">
        <h1><b>Dosen dan Staf Lab SE</b></h1>
        <p class="lead">Tim pengajar dan peneliti yang membimbing kegiatan laboratorium.</p>
    </div>
</header>

<main class="container py-5">
    
    <?php if(empty($all_personnel)): ?>
        <div class="text-center text-muted">
            <p>Belum ada data personil yang tersedia.</p>
        </div>
    <?php else: ?>

    <section class="team-grid">
        <?php foreach ($all_personnel as $member): ?>
        <div class="profile-card">
            <div class="img-wrapper">
                <img src="<?= $member['foto'] ?>" alt="<?= $member['nama'] ?>" onerror="this.src='<?= BASE_URL ?>assets/img/default.png'">
            </div>
            
            <h5 class="fw-bold mt-3"><?= $member['nama'] ?></h5>
            <p class="text-primary fw-semibold mb-1"><?= $member['peran'] ?></p>
            <p class="small text-muted mb-3"><i class="bi bi-code-slash"></i> <?= $member['spesialisasi'] ?></p>
            
            <a href="<?= BASE_URL ?>pages/personil_detail.php?id=<?= $member['id'] ?>" class="btn btn-sm btn-outline-info rounded-pill px-4">
                Lihat Profil
            </a>
        </div>
        <?php endforeach; ?>
    </section>

    <?php endif; ?>

</main>

<style>
/* CSS Grid Responsif */
.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    padding: 20px 0;
}

.profile-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    padding: 30px 20px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #f0f0f0;
}

.profile-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.img-wrapper img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #e3f2fd;
    margin-bottom: 10px;
}
</style>

<?php
// 5. PANGGIL FOOTER
require_once $root . '/includes/footer.php';
?>