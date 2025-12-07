<?php
class PublikasiController
{
    private $model;
    private $root;

    public function __construct(PublikasiModel $model)
    {
        $this->model = $model;
        $this->root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website'; 
    }

    public function index()
    {
        try {
            $publikasi_list = $this->model->getAllPublikasi();
            include $this->root . '/admin/pages/publikasi/list_publikasi.php';
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Kesalahan: " . $e->getMessage() . "</div>";
        }
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $personil_ids = isset($_POST['id_personil']) ? $_POST['id_personil'] : [];
                
                if (empty($personil_ids) || !is_array($personil_ids)) {
                    throw new Exception("Wajib memilih minimal satu personil/penulis.");
                }

                $data = [
                    'id_jenis' => $_POST['id_jenis'],
                    'judul'    => htmlspecialchars($_POST['judul']),
                    'tahun'    => $_POST['tahun'],
                    'link'     => $_POST['link'] ?? ''
                ];

                if ($this->model->create($data, $personil_ids)) {
                    if (session_status() === PHP_SESSION_NONE) session_start();
                    $_SESSION['swal_success'] = "Publikasi berhasil ditambahkan.";
                    
                    header("Location: index.php?action=publikasi_list");
                    exit();
                }

            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        $personil_list = $this->model->getListPersonil();
        $jenis_list = $this->model->getListJenisPublikasi();

        include $this->root . '/admin/pages/publikasi/add_publikasi.php';
    }

    public function edit($id)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $data_old = $this->model->getPublikasiById($id);
        if (!$data_old) {
            $_SESSION['swal_error'] = "Data tidak ditemukan!";
            header("Location: index.php?action=publikasi_list");
            exit();
        }

        $selected_authors = $this->model->getSelectedAuthors($id); 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $personil_ids = isset($_POST['id_personil']) ? $_POST['id_personil'] : [];
                
                if (empty($personil_ids) || !is_array($personil_ids)) {
                    throw new Exception("Wajib memilih minimal satu personil/penulis.");
                }

                $data = [
                    'id_jenis' => $_POST['id_jenis'],
                    'judul'    => htmlspecialchars(trim($_POST['judul'])),
                    'tahun'    => trim($_POST['tahun']),
                    'link'     => trim($_POST['link']),
                ];

                if (empty($data['judul'])) throw new Exception("Judul tidak boleh kosong.");

                if ($this->model->update($id, $data, $personil_ids)) {
                    $_SESSION['swal_success'] = "Data publikasi berhasil diperbarui.";
                    header("Location: index.php?action=publikasi_list");
                    exit();
                } else {
                    throw new Exception("Gagal mengupdate database.");
                }

            } catch (Exception $e) {
                $_SESSION['swal_error'] = "Gagal: " . $e->getMessage();
                header("Location: index.php?action=publikasi_edit&id=" . $id);
                exit();
            }
        }

        $personil_list = $this->model->getListPersonil();
        $jenis_list = $this->model->getListJenisPublikasi();

        include $this->root . '/admin/pages/publikasi/edit_publikasi.php';
    }

    public function delete($id)
    {
        if ($this->model->delete($id)) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            $_SESSION['swal_success'] = "Data publikasi berhasil dihapus.";
        } else {
            $_SESSION['swal_error'] = "Gagal menghapus data.";
        }
        header("Location: index.php?action=publikasi_list");
        exit();
    }
}
?>