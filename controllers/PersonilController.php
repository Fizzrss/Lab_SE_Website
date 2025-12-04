<?php

class PersonilController
{
    private $model;
    private $root;

    /**
     * Constructor: Menerima PersonilModel yang sudah terinisialisasi
     */
    public function __construct(PersonilModel $model)
    {
        $this->model = $model;
        // Inisialisasi path root untuk include view
        $this->root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';
    }

    // method list_personil untuk admin
    public function personilListforAdmin()
    {
        try {
            // Ambil data dari Model
            $all_personnel = $this->model->getAllPersonil();

            // Mapping path foto untuk View Admin
            foreach ($all_personnel as &$member) {
                // Kolom 'foto' sudah dipetakan ke 'foto_file' di Model
                $nama_file = !empty($member['foto']) ? $member['foto'] : 'default-profile.png';
                $member['foto'] = BASE_URL . 'assets/img/personil/' . $nama_file;
            }

            // Muat View Admin List
            // View list_personil.php harus menggunakan variabel $all_personnel
            include $this->root . '/admin/pages/personil/list_personil.php';
        } catch (Exception $e) {
            // Tampilkan error jika gagal
            echo "<div class='alert alert-danger'>Kesalahan saat memuat data: " . $e->getMessage() . "</div>";
        }
    }

    // method getDetailData (dipanggil oleh admin/public detail)
    public function getDetailData($id)
    {
        if (empty($id)) {
            return ['personnel' => null, 'error' => "ID personil tidak ditemukan."];
        }

        try {
            // 1. Panggil Model
            // (Hasilnya sudah lengkap: data diri, spesialisasi, publikasi, DAN SOSMED)
            $personnel = $this->model->getPersonilDetail($id);

            if ($personnel) {
                // 2. Mapping Data Dasar
                $personnel['nama'] = $personnel['nama_personil'];
            
                // 3. Logika Path Gambar
                $foto_db = $personnel['foto_personil'];
                $nama_file = !empty($foto_db) ? $foto_db : 'default-profile.png';
                
                // Pastikan BASE_URL sudah didefinisikan di config
                $personnel['foto'] = BASE_URL . 'assets/img/personil/' . $nama_file;

                // 4. Fallback Bio (Opsional)
                $personnel['bio'] = $personnel['bio'] ?? 'Biografi belum tersedia.';

                return ['personnel' => $personnel, 'error' => null];
            }

            return ['personnel' => null, 'error' => "Personil dengan ID {$id} tidak ditemukan."];
            
        } catch (Exception $e) {
            return ['personnel' => null, 'error' => "Kesalahan sistem: " . $e->getMessage()];
        }
    }

    // method detail personil untuk admin
    public function personilDetailforAdmin($id)
    {
        // Ambil data dari core method
        $data = $this->getDetailData($id);

        $personnel = $data['personnel'];
        $error_message = $data['error']; // Variabel yang akan digunakan di view

        // Muat View Detail Admin
        include $this->root . '/admin/pages/personil/detail_personil.php';
    }

    // method detail personil untuk landing page
    public function personilDetailforLanding($id)
    {
        // Ambil data dari core method
        $data = $this->getDetailData($id);

        $personnel = $data['personnel'];
        $error_message = $data['error']; // Variabel yang akan digunakan di view

        // Muat View Detail Publik
        // Asumsi lokasi: /pages/personil_detail.php
        include $this->root . '/pages/personil_detail.php';
    }

    public function searchPersonil()
    {

        if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $all_personnel = $this->model->searchPersonil($keyword);
        } else {
            $all_personnel = $this->model->getAllPersonil();
        }

        foreach ($all_personnel as &$member) {
            $nama_file = !empty($member['foto']) ? $member['foto'] : 'default-profile.png';
            $member['foto'] = BASE_URL . 'assets/img/personil/' . $nama_file;
        }
        include $this->root . '/admin/pages/personil/list_personil.php';
    }

    public function add()
    {
        $personnel = null;
        $jabatan_list = $this->model->getAllJabatan();
        
        $spesialisasi_list = $this->model->getAllSpesialisasi();
        $owned_specs = [];

        $master_sosmed = $this->model->getAllMasterSosmed();
        $owned_sosmed = [];

        include $this->root . '/admin/pages/personil/add_personil.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $foto = $this->uploadFoto($_FILES['foto']);

                $spesialisasi_ids = $_POST['spesialisasi'] ?? [];

                $sosmed_data = [];
                if (isset($_POST['sosmed_id']) && isset($_POST['sosmed_link'])) {
                    foreach ($_POST['sosmed_id'] as $index => $id_sosmed) {
                        $link = $_POST['sosmed_link'][$index];
                        
                        if (!empty($id_sosmed) && !empty($link)) {
                            $sosmed_data[] = [
                                'id_sosmed' => $id_sosmed,
                                'link' => $link
                            ];
                        }
                    }
                }

                $data = [
                    'nama'     => $_POST['nama'],
                    'nip'      => $_POST['nip'],
                    'email'    => $_POST['email'],
                    'jabatan'  => $_POST['jabatan'],
                    'foto'     => $foto
                ];

                if ($this->model->insert($data, $spesialisasi_ids, $sosmed_data)) {
                    $_SESSION['swal_success'] = "Data personil berhasil ditambahkan!";
                    header("Location: index.php?action=personil_list");
                    exit;
                }
            } catch (Exception $e) {
                $_SESSION['swal_error'] = "Gagal: " . $e->getMessage();
                echo "<script>window.history.back();</script>";
            }
        }
    }
    public function edit($id)
    {
        $personnel = $this->model->getPersonilDetail($id);
        $jabatan_list = $this->model->getAllJabatan();

        $spesialisasi_list = $this->model->getAllSpesialisasi();
        $owned_specs = $this->model->getPersonilSpesialisasiIDs($id);

        $master_sosmed = $this->model->getAllMasterSosmed();
        $owned_sosmed = $this->model->getPersonilSosmed($id); // Ambil sosmed yang dimiliki

        include $this->root . '/admin/pages/personil/edit_personil.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                if (!empty($_FILES['foto']['name'])) {
                    $foto = $this->uploadFoto($_FILES['foto']);
                } else {
                    $foto = $_POST['foto_lama'];
                }

                $spesialisasi_ids = $_POST['spesialisasi'] ?? [];

                $sosmed_data = [];
                if (isset($_POST['sosmed_id']) && isset($_POST['sosmed_link'])) {
                    foreach ($_POST['sosmed_id'] as $index => $id_sosmed) {
                        $link = $_POST['sosmed_link'][$index];
                        if (!empty($id_sosmed) && !empty($link)) {
                            $sosmed_data[] = [
                                'id_sosmed' => $id_sosmed,
                                'link' => $link
                            ];
                        }
                    }
                }

                $data = [
                    'nama' => $_POST['nama'],
                    'nip' => $_POST['nip'],
                    'email' => $_POST['email'],
                    'jabatan' => $_POST['jabatan'],
                    'foto' => $foto
                ];

                if ($this->model->update($id, $data, $spesialisasi_ids, $sosmed_data)) {
                    $_SESSION['swal_success'] = "Data personil berhasil diupdate!";
                    header("Location: index.php?action=personil_list");
                    exit();
                } else {
                    echo "<script>alert('Gagal mengupdate data!'); window.history.back();</script>";
                }
            } catch (Exception $e) {
                $_SESSION['swal_error'] = "Error: " . $e->getMessage();
                echo "<script>window.history.back();</script>";
            }
        }
    }

    public function delete($id)
    {
        if (empty($id)) {
            $_SESSION['swal_error'] = "ID Personil tidak ditemukan!";
            header("Location: index.php?action=personil_list");
            exit;
        }

        if ($this->model->delete($id)) {
            $_SESSION['swal_success'] = "Data personil berhasil dihapus!";
        } else {
            $_SESSION['swal_error'] = "Gagal menghapus data! Cek relasi data.";
        }

        header("Location: index.php?action=personil_list");
        exit;
    }

    private function uploadFoto($file)
    {
        $targetDir = $this->root . "/assets/img/personil/";

        if ($file['error'] !== 0) throw new Exception("File error / tidak diupload");

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) throw new Exception("Format file tidak didukung.");

        $fileName = time() . "_" . basename($file["name"]);
        if (move_uploaded_file($file["tmp_name"], $targetDir . $fileName)) {
            return $fileName;
        }
        throw new Exception("Gagal memindahkan file upload.");
    }
}
