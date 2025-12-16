<?php
class ProfilController
{
    private $model;
    private $uploadDir = '../assets/uploads/'; 

    public function __construct($model)
    {
        $this->model = $model;
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function index()
    {
        $sections = $this->model->getAll(false);
        $heroSettings = $this->model->getHeroSettings();
        
        extract(['sections' => $sections, 'heroSettings' => $heroSettings]);
        include 'pages/profil/settings.php';
    }

    public function updateSection()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=profil_settings');
            exit;
        }

        $sectionKey = $_POST['section_key'] ?? '';
        $title = $_POST['section_title'] ?? '';
        $contentJson = $_POST['section_content'] ?? '{}';
        $contentData = json_decode($contentJson, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            // SWAL ERROR
            $_SESSION['swal_icon'] = 'error';
            $_SESSION['swal_title'] = 'Gagal!';
            $_SESSION['swal_text'] = 'Format data JSON tidak valid.';
            
            header('Location: index.php?action=profil_settings');
            exit;
        }

        // --- Logika Multiple Upload (Tentang) ---
        if ($sectionKey === 'tentang') {
            if (isset($_FILES['tentang_images_new']) && !empty($_FILES['tentang_images_new']['name'][0])) {
                $files = $_FILES['tentang_images_new'];
                $count = count($files['name']);
                if (!isset($contentData['images']) || !is_array($contentData['images'])) $contentData['images'] = [];

                for ($i = 0; $i < $count; $i++) {
                    if ($files['error'][$i] === 0) {
                        $fileArray = [
                            'name' => $files['name'][$i], 'type' => $files['type'][$i],
                            'tmp_name' => $files['tmp_name'][$i], 'error' => $files['error'][$i],
                            'size' => $files['size'][$i]
                        ];
                        $uploadedPath = $this->handleUpload($fileArray, 'carousel');
                        if ($uploadedPath) $contentData['images'][] = $uploadedPath;
                    }
                }
            }
        }
        $finalContentJson = json_encode($contentData);

        if ($this->model->update($sectionKey, $title, $finalContentJson, true, 0)) {
            // SWAL SUKSES
            $_SESSION['swal_icon'] = 'success';
            $_SESSION['swal_title'] = 'Berhasil!';
            $_SESSION['swal_text'] = 'Section ' . htmlspecialchars($title) . ' berhasil diperbarui.';
        } else {
            // SWAL ERROR
            $_SESSION['swal_icon'] = 'error';
            $_SESSION['swal_title'] = 'Gagal!';
            $_SESSION['swal_text'] = 'Terjadi kesalahan saat menyimpan data ke database.';
        }

        header('Location: index.php?action=profil_settings');
        exit;
    }

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); 
            exit;
        }

        $sectionKey = $_POST['section_key'] ?? '';
        $isActive = $_POST['is_active'] ?? 0;

        if (empty($sectionKey)) {
            http_response_code(400); 
            echo "Error: Section key tidak ditemukan.";
            exit;
        }

        if ($this->model->updateSectionStatus($sectionKey, $isActive)) {
            echo "Success"; 
        } else {
            http_response_code(500); 
            echo "Error: Gagal update database.";
        }
        
        exit; 
    }

    public function updateHero()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=profil_settings');
            exit;
        }

        $bgImage = $_POST['old_hero_background_image'] ?? '';

        if (isset($_FILES['hero_background_image']) && $_FILES['hero_background_image']['error'] === 0) {
            $uploadedPath = $this->handleUpload($_FILES['hero_background_image'], 'hero');
            if ($uploadedPath) {
                $bgImage = $uploadedPath;
            } else {
                // SWAL WARNING (Jika upload gagal tapi form lain jalan)
                $_SESSION['swal_warning'] = 'Gambar gagal diupload, menggunakan gambar lama.';
            }
        }

        $settings = [
            'hero_title' => $_POST['hero_title'] ?? '',
            'hero_subtitle' => $_POST['hero_subtitle'] ?? '',
            'hero_description' => $_POST['hero_description'] ?? '',
            'hero_background_image' => $bgImage,
            'hero_button_text' => $_POST['hero_button_text'] ?? 'Get Started',
            'hero_button_link' => $_POST['hero_button_link'] ?? '#profil'
        ];

        $success = true;
        foreach ($settings as $key => $value) {
            if (!$this->model->updateHeroSetting($key, $value)) $success = false;
        }

        if ($success) {
            // SWAL SUKSES
            $_SESSION['swal_icon'] = 'success';
            $_SESSION['swal_title'] = 'Berhasil!';
            $_SESSION['swal_text'] = 'Pengaturan Hero Section berhasil diperbarui!';
        } else {
            // SWAL ERROR
            $_SESSION['swal_icon'] = 'error';
            $_SESSION['swal_title'] = 'Gagal!';
            $_SESSION['swal_text'] = 'Gagal memperbarui pengaturan Hero.';
        }

        header('Location: index.php?action=profil_settings');
        exit;
    }

    private function handleUpload($file, $subfolder = '')
    {
        // ... (Fungsi handleUpload sama persis dengan sebelumnya) ...
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; 
        if (!in_array($file['type'], $allowedTypes)) return false;
        if ($file['size'] > $maxSize) return false;
        $targetDir = $this->uploadDir . ($subfolder ? $subfolder . '/' : '');
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $targetFile = $targetDir . $filename;
        if (move_uploaded_file($file['tmp_name'], $targetFile)) return str_replace('../', '', $targetFile);
        return false;
    }
}
?>