<?php
class BeritaController
{
    private $model;
    private $uploadDir = '../assets/img';

    public function __construct($model)
    {
        $this->model = $model;

        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function index()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : null;
        $search = isset($_GET['search']) ? $_GET['search'] : null;

        // Admin can see all status
        $beritaList = $this->model->getAllForAdmin($limit, $offset, $kategori, $search);
        $totalBerita = $this->model->countAllForAdmin($kategori, $search);
        $totalPages = ceil($totalBerita / $limit);
        $categories = $this->model->getCategories();

        include 'pages/berita/list_berita.php';
    }

    public function add()
    {
        include 'pages/berita/add_berita.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=berita_list');
            exit;
        }

        $errors = $this->validateInput($_POST);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: index.php?action=berita_add');
            exit;
        }

        $gambar = '';
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $gambar = $this->handleImageUpload($_FILES['gambar']);
            if (!$gambar) {
                $_SESSION['errors'] = ['gambar' => 'Gagal upload gambar'];
                $_SESSION['old_input'] = $_POST;
                header('Location: index.php?action=berita_add');
                exit;
            }
        }

        $slug = $this->model->generateSlug($_POST['judul']);
        $counter = 1;
        while ($this->model->slugExists($slug)) {
            $slug = $this->model->generateSlug($_POST['judul']) . '-' . $counter;
            $counter++;
        }

        $data = [
            'judul' => trim($_POST['judul']),
            'kategori' => trim($_POST['kategori']),
            'tanggal_publikasi' => $_POST['tanggal_publikasi'],
            'penulis' => trim($_POST['penulis']),
            'gambar' => $gambar,
            'isi_singkat' => trim($_POST['isi_singkat']),
            'isi_lengkap' => $_POST['isi_lengkap'], // Don't trim, HTML content
            'status' => $_POST['status'],
            'slug' => $slug
        ];

        if ($this->model->create($data)) {
            $_SESSION['swal_success'] = 'Berita berhasil ditambahkan!';
            header('Location: index.php?action=berita_list&message=created');
        } else {
            $_SESSION['swal_error'] = 'Gagal menambahkan berita!';
            header('Location: index.php?action=berita_add');
        }
        exit;
    }

    public function edit($id)
    {
        $berita = $this->model->getById($id);

        if (!$berita) {
            setFlashMessage('danger', 'Berita tidak ditemukan!');
            header('Location: index.php?action=berita_list');
            exit;
        }

        include 'pages/berita/edit_berita.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=berita_list');
            exit;
        }

        $berita = $this->model->getById($id);

        if (!$berita) {
            setFlashMessage('danger', 'Berita tidak ditemukan!');
            header('Location: index.php?action=berita_list');
            exit;
        }

        $errors = $this->validateInput($_POST);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: index.php?action=berita_edit&id=' . $id);
            exit;
        }

        $gambar = $berita['gambar'];
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $newGambar = $this->handleImageUpload($_FILES['gambar']);
            if ($newGambar) {
                if ($gambar && file_exists($gambar)) {
                    unlink($gambar);
                }
                $gambar = $newGambar;
            }
        }

        $slug = $berita['slug'];
        if ($_POST['judul'] !== $berita['judul']) {
            $slug = $this->model->generateSlug($_POST['judul']);
            $counter = 1;
            while ($this->model->slugExists($slug, $id)) {
                $slug = $this->model->generateSlug($_POST['judul']) . '-' . $counter;
                $counter++;
            }
        }

        $data = [
            'judul' => trim($_POST['judul']),
            'kategori' => trim($_POST['kategori']),
            'tanggal_publikasi' => $_POST['tanggal_publikasi'],
            'penulis' => trim($_POST['penulis']),
            'gambar' => $gambar,
            'isi_singkat' => trim($_POST['isi_singkat']),
            'isi_lengkap' => $_POST['isi_lengkap'], // Don't trim, HTML content
            'status' => $_POST['status'],
            'slug' => $slug
        ];

        if ($this->model->update($id, $data)) {
            $_SESSION['swal_success'] = 'Berita berhasil diperbarui!';
            header('Location: index.php?action=berita_list&message=updated');
        } else {
            $_SESSION['swal_error'] = 'Gagal mengupdate berita!';
            header('Location: index.php?action=berita_edit&id=' . $id);
        }
        exit;
    }

    public function delete($id)
    {
        if ($this->model->delete($id)) {
            $_SESSION['swal_success'] = 'Berita berhasil dihapus!';
            header('Location: index.php?action=berita_list&message=deleted');
        } else {
            $_SESSION['swal_error'] = 'Gagal menghapus berita!';
            header('Location: index.php?action=berita_list');
        }
        exit;
    }

    private function validateInput($data)
    {
        $errors = [];

        if (empty($data['judul'])) {
            $errors['judul'] = 'Judul harus diisi';
        }

        if (empty($data['kategori'])) {
            $errors['kategori'] = 'Kategori harus diisi';
        }

        if (empty($data['tanggal_publikasi'])) {
            $errors['tanggal_publikasi'] = 'Tanggal publikasi harus diisi';
        }

        if (empty($data['penulis'])) {
            $errors['penulis'] = 'Penulis harus diisi';
        }

        if (empty($data['isi_singkat'])) {
            $errors['isi_singkat'] = 'Isi singkat harus diisi';
        }

        if (empty($data['isi_lengkap'])) {
            $errors['isi_lengkap'] = 'Isi lengkap harus diisi';
        }

        return $errors;
    }

    private function handleImageUpload($file)
    {
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024;

        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        if ($file['size'] > $maxSize) {
            return false;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'berita_' . time() . '_' . uniqid() . '.' . $extension;
        $targetPath = $this->uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $targetPath;
        }

        return false;
    }
}
