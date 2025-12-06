<?php
session_start();
ob_start();
$timeout_duration = 1800;

if (isset($_SESSION['last_activity'])) {
    $duration = time() - $_SESSION['last_activity'];

    if ($duration > $timeout_duration) {
        session_unset();
        session_destroy();
        header("Location: login.php?pesan=timeout");
        exit;
    }
}

$_SESSION['last_activity'] = time();

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', __DIR__);
}

if (!isset($_SESSION['user_id']) && (!isset($_GET['action']) || $_GET['action'] !== 'login_process')) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Load Config & Models
$root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';

require_once $root . '/config/config.php';
require_once $root . '/helpers/flash_message.php';

// Load Semua Model & Controller
require_once $root . '/models/MahasiswaAktifModel.php';
require_once $root . '/controllers/MahasiswaController.php';
require_once $root . '/models/Personil.php';
require_once $root . '/controllers/PersonilController.php';
require_once $root . '/models/RecruitmentModel.php';
require_once $root . '/controllers/RecruitmentController.php';
require_once $root . '/models/PublikasiModel.php';
require_once $root . '/controllers/PublikasiController.php';
require_once $root . '/models/Berita.php';
require_once $root . '/controllers/BeritaController.php';
require_once $root . '/models/KomentarBerita.php';
require_once $root . '/controllers/KomentarController.php';
require_once $root . '/models/SocialMediaSettings.php';
require_once $root . '/controllers/SocialMediaController.php';
require_once $root . '/models/RelatedPostsSettings.php';
require_once $root . '/controllers/RelatedPostsController.php';
require_once $root . '/models/FooterSettings.php';
require_once $root . '/controllers/FooterController.php';
require_once $root . '/models/ProfilSections.php';
require_once $root . '/controllers/ProfilController.php';
require_once $root . '/models/BeritaSettings.php';
require_once $root . '/controllers/BeritaSettingsController.php';

// Inisialisasi Database
$database = new Database();
$db = $database->getConnection();

// Inisialisasi Controller
$mahasiswaModel = new MahasiswaAktifModel($db);
$controller     = new MahasiswaController($mahasiswaModel);

$personilModel = new PersonilModel($db);
$personilController = new PersonilController($personilModel);

$recruitmentModel = new RecruitmentModel($db);
$recruitmentController = new RecruitmentController($recruitmentModel);

$publikasiModel = new PublikasiModel($db);
$publikasiController = new PublikasiController($publikasiModel);

$beritaModel = new BeritaModel($db);
$beritaController = new BeritaController($beritaModel);

$komentarModel = new KomentarBeritaModel($db);
$komentarController = new KomentarController($komentarModel);

$socialMediaModel = new SocialMediaSettingsModel($db);
$socialMediaController = new SocialMediaController($socialMediaModel);

$relatedPostsModel = new RelatedPostsSettingsModel($db);
$relatedPostsController = new RelatedPostsController($relatedPostsModel);

$footerModel = new FooterSettingsModel($db);
$footerController = new FooterController($footerModel);

$profilModel = new ProfilSectionsModel($db);
$profilController = new ProfilController($profilModel);

$beritaSettingsModel = new BeritaSettingsModel($db);
$beritaSettingsController = new BeritaSettingsController($beritaSettingsModel);

// Ambil Action
$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';


require_once $root . '/admin/includes/admin_header.php';
require_once $root . '/admin/includes/admin_slidebar.php';
?>

<div id="main">

    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <?php
    switch ($action) {
        case 'dashboard':
            // if (method_exists($controller, 'getDashboardStats')) {
            //     $stats = $controller->getDashboardStats();
            // }
            include 'pages/dashboard.php';
            break;

        // --- Mahasiswa Routes ---
        case 'mahasiswa_list':
            $controller->index();
            break;
        case 'mahasiswa_delete':
            $controller->delete($_GET['id']);
            break;

        case 'recruitment_list':
            $recruitmentController->adminIndex();
            break;
        case 'recruitment_detail':
            $recruitmentController->detail($_GET['id']);
            break;
        case 'recruitment_status':
            $id = $_GET['id'];
            $status = $_GET['status']; 
            $recruitmentController->processStatus($id, $status);
            break;
        case 'recruitment_delete':
            $recruitmentController->delete($_GET['id']);
            break;

        // --- Personil Routes ---
        case 'personil_list':
            $personilController->personilListforAdmin();
            break;
        case 'personil_search':
            $personilController->searchPersonil($_GET['keyword']);
            break;
        case 'personil_add':
            $personilController->add();
            break;
        case 'personil_save':
            $personilController->save();
            break;
        case 'personil_edit':
            $personilController->edit($_GET['id']);
            break;
        case 'personil_update':
            $personilController->update($_GET['id']);
            break;
        case 'personil_delete':
            $personilController->delete($_GET['id']);
            break;


        // --- Publikasi Routes ---
        case 'publikasi_list':
            $publikasiController->index();
            break;
        case 'publikasi_add':
            $publikasiController->add();
            break;
        case 'publikasi_edit':
            $publikasiController->edit($_GET['id']);
            break;
        case 'publikasi_delete':
            $publikasiController->delete($_GET['id']);
            break;

        // --- Berita Routes ---
        case 'berita_list':
            $beritaController->index();
            break;
        case 'berita_add':
            $beritaController->add();
            break;
        case 'berita_save':
            $beritaController->save();
            break;
        case 'berita_edit':
            $beritaController->edit($_GET['id']);
            break;
        case 'berita_update':
            $beritaController->update($_GET['id']);
            break;
        case 'berita_delete':
            $beritaController->delete($_GET['id']);
            break;
        case 'berita_hero_settings':
            $beritaSettingsController->index();
            break;
        case 'berita_hero_update':
            $beritaSettingsController->update();
            break;

        // --- Komentar Routes ---
        case 'komentar_list':
            $komentarController->index();
            break;
        case 'komentar_delete':
            $komentarController->delete($_GET['id']);
            break;

        // --- Social Media Settings Routes ---
        case 'social_media_settings':
            $socialMediaController->index();
            break;
        case 'social_media_update':
            $socialMediaController->update();
            break;

        // --- Related Posts Settings Routes ---
        case 'related_posts_settings':
            $relatedPostsController->index();
            break;
        case 'related_posts_update':
            $relatedPostsController->update();
            break;

        // --- Footer Settings Routes ---
        case 'footer_settings':
            $footerController->index();
            break;
        case 'footer_update':
            $footerController->update();
            break;

        // --- Profil Settings Routes ---
        case 'profil_settings':
            $profilController->index();
            break;
        case 'profil_section_update':
            $profilController->updateSection();
            break;
        case 'profil_hero_update':
            $profilController->updateHero();
            break;

        default:
            include 'pages/dashboard.php';
            break;
    }
    ?>

    <?php include 'includes/admin_footer.php'; ?>
</div>

<?php
ob_end_flush();
?>