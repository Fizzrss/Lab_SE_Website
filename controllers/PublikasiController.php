<?php
class PublikasiController
{
    private $model;
    private $root;

    public function __construct(PublikasiModel $model)
    {
        $this->model = $model;
        // Pastikan path ini sesuai struktur foldermu
        $this->root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website'; 
    }

    public function index()
    {
        try {
            $publikasi_list = $this->model->getAllPublikasi();
            // Jangan throw exception jika kosong, biarkan view menangani tabel kosong
            include $this->root . '/admin/pages/publikasi/list_publikasi.php';
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Kesalahan: " . $e->getMessage() . "</div>";
        }
    }

    public function add()
    {
        $error = null;
        
        // --- PROSES MENYIMPAN DATA (POST) ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Input Sanitization (Trim whitespace)
                $data = [
                    'id_personil' => $_POST['id_personil'] ?? null,
                    'id_jenis'    => $_POST['id_jenis'] ?? null,
                    'judul'       => trim($_POST['judul'] ?? ''),
                    'tahun'       => trim($_POST['tahun'] ?? ''),
                    'link'        => trim($_POST['link'] ?? ''),
                ];

                // Input Validation
                if (empty($data['id_personil'])) throw new Exception("Personil wajib dipilih.");
                if (empty($data['id_jenis'])) throw new Exception("Jenis publikasi wajib dipilih.");
                if (empty($data['judul'])) throw new Exception("Judul tidak boleh kosong.");
                if (empty($data['tahun']) || !is_numeric($data['tahun'])) throw new Exception("Tahun harus berupa angka.");
                
                // Simpan ke database
                if ($this->model->create($data)) {
                    $_SESSION['swal_success'] = "Data publikasi berhasil ditambahkan!";
                    header("Location: index.php?action=publikasi_list");
                    exit();
                } else {
                    throw new Exception("Gagal menyimpan data ke database.");
                }

            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        // --- PROSES MENAMPILKAN FORM (GET) ---
        try {
            // Kita butuh list personil dan jenis untuk Dropdown <select>
            $personil_list = $this->model->getListPersonil(); 
            $jenis_list = $this->model->getListJenisPublikasi();
            
            // Sertakan view form tambah
            include $this->root . '/admin/pages/publikasi/add_publikasi.php';
        } catch (Exception $e) {
            echo "Error loading form: " . $e->getMessage();
        }
    }

    public function edit($id)
    {
        $error = null;
        
        // Ambil data lama berdasarkan ID
        $data_old = $this->model->getPublikasiById($id);
        if (!$data_old) {
            echo "Data tidak ditemukan!";
            return;
        }

        // --- PROSES UPDATE DATA (POST) ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = [
                    'id_personil' => $_POST['id_personil'],
                    'id_jenis'    => $_POST['id_jenis'],
                    'judul'       => trim($_POST['judul']),
                    'tahun'       => trim($_POST['tahun']),
                    'link'        => trim($_POST['link']),
                ];

                // Validasi sederhana
                if (empty($data['judul'])) throw new Exception("Judul tidak boleh kosong.");

                if ($this->model->update($id, $data)) {
                    header("Location: index.php?controller=publikasi&action=index&message=updated");
                    exit();
                } else {
                    throw new Exception("Gagal mengupdate data.");
                }
            } catch (Exception $e) {
                $_SESSION['swal_error'] = "Gagal: " . $e->getMessage();
                echo "<script>window.history.back();</script>";
            }
        }

        // --- PROSES MENAMPILKAN FORM EDIT (GET) ---
        // Kita juga butuh dropdown list di form edit
        $personil_list = $this->model->getListPersonil();
        $jenis_list = $this->model->getListJenisPublikasi();

        include $this->root . '/admin/pages/publikasi/edit_publikasi.php';
    }

    public function delete($id)
    {
        if (empty($id)) {
            $_SESSION['swal_error'] = "ID Personil tidak ditemukan!";
            header("Location: index.php?action=publikasi_list");
            exit;
        }

        if ($this->model->delete($id)) {
            $_SESSION['swal_success'] = "Data publikasi berhasil dihapus!";
        } else {
            $_SESSION['swal_error'] = "Gagal menghapus data! Cek relasi data.";
        }
        header("Location: index.php?action=publikasi_list");
        exit();
    }
}
?>