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

        case 'pendaftar_list':
            $recruitmentController->adminIndex();
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