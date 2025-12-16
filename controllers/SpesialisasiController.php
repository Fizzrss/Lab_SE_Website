<?php
class SpesialisasiController
{
    private $model;
    private $root;

    public function __construct(SpesialisasiModel $model)
    {
        $this->model = $model;
        $this->root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';
    }

    public function index()
    {
        try {
            $spesialisasi = $this->model->getAll();
            include $this->root . '/admin/pages/spesialisasi/list_spesialisasi.php';
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Kesalahan: " . $e->getMessage() . "</div>";
        }
    }

    public function add()
    {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $nama_spesialisasi = trim($_POST['nama_spesialisasi'] ?? '');

                if (empty($nama_spesialisasi)) {
                    throw new Exception("Spesialisasi tidak boleh kosong.");
                }

                if ($this->model->create($nama_spesialisasi)) {
                    $_SESSION['swal_success'] = "Data spesialisasi berhasil ditambahkan!";
                    header("Location: index.php?action=spesialisasi_list");
                    exit();
                } else {
                    throw new Exception("Gagal menyimpan data ke database.");
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        include $this->root . '/admin/pages/spesialisasi/add_spesialisasi.php';
    }

    public function edit($id)
    {
        $error = null;
        $spesialisasi = $this->model->getById($id);

        if (!$spesialisasi) {
            header("Location: index.php?action=spesialisasi_list");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $input_nama = trim($_POST['nama_spesialisasi'] ?? '');

                if (empty($input_nama)) {
                    throw new Exception("Spesialisasi tidak boleh kosong.");
                }

                $data = [
                    'nama_spesialisasi' => $input_nama
                ];

                if ($this->model->update($id, $data)) {
                    $_SESSION['swal_success'] = "Data spesialisasi berhasil diperbarui!";
                    header("Location: index.php?action=spesialisasi_list"); // Pastikan redirect ke list yang benar
                    exit();
                } else {
                    throw new Exception("Gagal mengupdate data.");
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        include $this->root . '/admin/pages/spesialisasi/edit_spesialisasi.php';
    }

    public function delete($id)
    {
        if ($this->model->delete($id)) {
            $_SESSION['swal_success'] = "Data spesialisasi berhasil dihapus!";
        } else {
            $_SESSION['swal_error'] = "Gagal menghapus data! Cek relasi data.";
        }
        header("Location: index.php?action=spesialisasi_list");;
        exit();
    }
}
