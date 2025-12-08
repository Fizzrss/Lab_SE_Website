<?php
if (!defined('BASE_URL')) {
  define('BASE_URL', 'http://localhost/Lab_SE_Website/');
}
$current_page = basename($_SERVER['PHP_SELF']);

// Load profil sections from database
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/ProfilSections.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    $profilModel = new ProfilSectionsModel($db);
    
    // Get all active sections
    $sections = $profilModel->getAll(true);
    
    // Organize sections by key
    $sectionsByKey = [];
    foreach ($sections as $section) {
        $sectionsByKey[$section['section_key']] = $section;
    }
    
    // Prepare data for each section
    $tentangData = $sectionsByKey['tentang'] ?? null;
    $visiMisiData = $sectionsByKey['visi_misi'] ?? null;
    $roadmapData = $sectionsByKey['roadmap'] ?? null;
    $focusScopeData = $sectionsByKey['focus_scope'] ?? null;
} catch (Exception $e) {
    // Fallback - use empty data
    $tentangData = null;
    $visiMisiData = null;
    $roadmapData = null;
    $focusScopeData = null;
}
?>
<section>
    <div id="profil">
        <div id="statistik">
            <?php require_once __DIR__ . '/statistik.php'; ?>
        </div>
        
        <?php if ($tentangData && $tentangData['is_active']): ?>
        <div id="tentang">
            <?php require_once __DIR__ . '/tentang.php'; ?>
        </div>
        <?php endif; ?>

        <?php if ($visiMisiData && $visiMisiData['is_active']): ?>
        <div id="visi_misi">
            <?php require_once __DIR__ . '/visi_misi.php'; ?>
        </div>
        <?php endif; ?>
        
        <?php if ($roadmapData && $roadmapData['is_active']): ?>
        <div id="roadmap">
            <?php require_once __DIR__ . '/roadmap.php'; ?>
        </div>
        <?php endif; ?>
        
        <?php if ($focusScopeData && $focusScopeData['is_active']): ?>
        <div id="focus_scope">
            <?php require_once __DIR__ . '/focus_scope.php'; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
