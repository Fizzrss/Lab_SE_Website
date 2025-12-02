<?php
$page_title = "Data Mahasiswa Aktif";
$root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';

require_once $root . '/config/config.php';
require_once $root . '/config/function.php';

require_once $root . '/controllers/MahasiswaController.php'; 

$database = new Database();
$db = $database->getConnection();

$controller = new MahasiswaController($db);
$result = $controller->index(); 
$total_aktif = $result->rowCount();


include $root . '/includes/admin_header.php';
include $root . '/includes/admin_slidebar.php';
?>

<div id="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="table_aktif">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Prodi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while($row = $result->fetch(PDO::FETCH_ASSOC)): 
                                $fotoPath = '/Lab_SE_Website/uploads/' . $row['foto'];
                                if(empty($row['foto'])) {
                                    $fotoPath = 'https://via.placeholder.com/150?text=No+Img';
                                }
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <button onclick="hapus(<?= $row['id'] ?>)" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include $root . '/includes/admin_footer.php'; ?>