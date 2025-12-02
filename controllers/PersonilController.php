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

    // method list_personil untuk landing page
    public function personilListforLanding()
    {
        try {
            // Ambil data dari Model
            $personil_list = $this->model->getAllPersonil();

            // Mapping path foto untuk View Publik
            foreach ($personil_list as &$member) {
                $nama_file = !empty($member['foto']) ? $member['foto'] : 'default-profile.png';
                $member['foto'] = BASE_URL . 'assets/img/personil/' . $nama_file;
            }

            include $this->root . '/pages/personil/index.php';
        } catch (Exception $e) {
            echo "Terjadi masalah saat memuat data personil publik.";
        }
    }

    // method getDetailData (dipanggil oleh admin/public detail)
    public function getDetailData($id)
    {
        if (empty($id)) {
            return ['personnel' => null, 'error' => "ID personil tidak ditemukan."];
        }

        try {
            // Memanggil getPersonilDetail dari Model
            $personnel = $this->model->getPersonilDetail($id);

            if ($personnel) {
                // Mapping Data
                $personnel['nama'] = $personnel['nama_personil'];
                $personnel['google_scholar_url'] = $personnel['link_gscholar'];
                $personnel['linkedin_url'] = $personnel['linkedin'];

                // Logika Gambar
                $foto_db = $personnel['foto_personil'];
                $nama_file = !empty($foto_db) ? $foto_db : 'default-profile.png';
                // Asumsi folder foto personil ada di assets/img/personil
                $personnel['foto'] = BASE_URL . 'assets/img/personil/' . $nama_file;

                $personnel['bio'] = $personnel['bio'] ?? 'Biografi belum tersedia.';

                return ['personnel' => $personnel, 'error' => null];
            }

            return ['personnel' => null, 'error' => "Personil dengan ID {$id} tidak ditemukan."];
        } catch (PDOException $e) {
            return ['personnel' => null, 'error' => "Kesalahan database: " . $e->getMessage()];
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
        include $this->root . '/admin/pages/personil/add_personil.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $foto = $this->uploadFoto($_FILES['foto']);

                // Ambil data spesialisasi (Array ID)
                $spesialisasi_ids = $_POST['spesialisasi'] ?? [];

                $data = [
                    'nama'     => $_POST['nama'],
                    'nip'      => $_POST['nip'],
                    'email'    => $_POST['email'],
                    'jabatan'  => $_POST['jabatan'],
                    'gscholar' => $_POST['gscholar'],
                    'linkedin' => $_POST['linkedin'],
                    'foto'     => $foto
                ];

                // --- PERBAIKAN DI SINI ---
                // Kirim $spesialisasi_ids ke fungsi insert model
                if ($this->model->insert($data, $spesialisasi_ids)) {
                    $_SESSION['swal_success'] = "Data personil berhasil ditambahkan!";
                    header("Location: index.php?action=personil_list");
                    exit;
                }
            } catch (Exception $e) {
                // Gunakan session flashdata juga untuk error biar konsisten (Opsional)
                $_SESSION['swal_error'] = "Gagal: " . $e->getMessage();
                echo "<script>window.history.back();</script>";
            }
        }
    }

    public function edit($id)
    {
        // Ambil data personil
        $personnel = $this->model->getPersonilDetail($id); // Data Detail
        $jabatan_list = $this->model->getAllJabatan();

        // 1. AMBIL MASTER DATA SPESIALISASI (Untuk isi opsi dropdown)
        $spesialisasi_list = $this->model->getAllSpesialisasi();

        // 2. AMBIL ID YANG SUDAH DIMILIKI (Untuk set 'selected' di dropdown)
        // Hasil: [1, 5] misalnya
        $owned_specs = $this->model->getPersonilSpesialisasiIDs($id);

        include $this->root . '/admin/pages/personil/edit_personil.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_FILES['foto']['name'])) {
                // Jika ada upload baru, proses uploadnya
                $foto = $this->uploadFoto($_FILES['foto']);
            } else {
                $foto = $_POST['foto_lama'];
            }

            // AMBIL ARRAY DARI DROPDOWN
            // Isinya sekarang angka ID: [1, 5, 9]
            $spesialisasi_ids = $_POST['spesialisasi'] ?? [];

            $data = [
                'nama' => $_POST['nama'],
                'nip' => $_POST['nip'],
                'email' => $_POST['email'],
                'jabatan' => $_POST['jabatan'],
                'gscholar' => $_POST['gscholar'],
                'linkedin' => $_POST['linkedin'],
                'foto' => $foto
            ];

            if ($this->model->update($id, $data, $spesialisasi_ids)) {
                $_SESSION['swal_success'] = "Data personil berhasil diupdate!";

                header("Location: index.php?action=personil_list");
                exit();
            } else {
                echo "<script>alert('Gagal mengupdate data!'); window.history.back();</script>";
            }
        }
    }

    private function uploadFoto($file)
    {
        $targetDir = $this->root . "/assets/img/personil/";

        // Validasi sederhana
        if ($file['error'] !== 0) throw new Exception("File error / tidak diupload");

        $fileName = time() . "_" . basename($file["name"]);
        if (move_uploaded_file($file["tmp_name"], $targetDir . $fileName)) {
            return $fileName;
        }
        throw new Exception("Gagal memindahkan file upload.");
    }

    public function delete($id)
    {
        if (empty($id)) {
            $_SESSION['swal_error'] = "ID Personil tidak ditemukan!";
            header("Location: index.php?action=personil_list");
            exit;
        }

        if ($this->model->delete($id)) {
            // BERHASIL: Simpan pesan sukses
            $_SESSION['swal_success'] = "Data personil berhasil dihapus!";
        } else {
            // GAGAL: Simpan pesan error
            $_SESSION['swal_error'] = "Gagal menghapus data! Cek relasi data.";
        }

        header("Location: index.php?action=personil_list");
        exit;
    }
}
