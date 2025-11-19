<?php
if (!defined('BASE_URL')) {
  define('BASE_URL', 'http://localhost/pbl/');
}
$current_page = basename($_SERVER['PHP_SELF']);
?>
<section>
    <div id="profil"> <div id="tentang">
            <?php require_once __DIR__ . '/tentang.php'; ?>
        </div>
        <div id="visi_misi">
            <?php require_once __DIR__ . '/visi_misi.php'; ?>
        </div>
        <div id="roadmap">
            <?php require_once __DIR__ . '/roadmap.php'; ?>
        </div>
         <div id="focus_scope">
            <?php require_once __DIR__ . '/focus_scope.php'; ?>
        </div>
    </div>
</section>
