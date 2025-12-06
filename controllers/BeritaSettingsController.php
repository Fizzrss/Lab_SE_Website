<?php
require_once __DIR__ . '/../models/BeritaSettings.php';

class BeritaSettingsController
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Display settings page
     */
    public function index()
    {
        $settings = $this->model->getAllSettings();
        
        $heroBadge = $settings['hero_badge'] ?? 'News & Updates';
        $heroTitle = $settings['hero_title'] ?? 'Berita & Artikel Terkini';
        $heroDescription = $settings['hero_description'] ?? 'Berita terbaru, artikel teknis, dan wawasan seputar teknologi dari Laboratorium Software Engineering.';
        $heroBackgroundImage = $settings['hero_background_image'] ?? '../assets/img/lab1.jpg';
        
        include __DIR__ . '/../admin/pages/berita/hero_settings.php';
    }

    /**
     * Update settings
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=berita_hero_settings');
            exit;
        }

        $heroBadge = $_POST['hero_badge'] ?? '';
        $heroTitle = $_POST['hero_title'] ?? '';
        $heroDescription = $_POST['hero_description'] ?? '';
        $heroBackgroundImage = $_POST['hero_background_image'] ?? '';

        // Handle image upload
        if (isset($_FILES['hero_background_image_file']) && $_FILES['hero_background_image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../assets/uploads/berita/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileExtension = pathinfo($_FILES['hero_background_image_file']['name'], PATHINFO_EXTENSION);
            $fileName = 'hero_banner_' . time() . '.' . $fileExtension;
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['hero_background_image_file']['tmp_name'], $targetPath)) {
                $heroBackgroundImage = 'assets/uploads/berita/' . $fileName;
            }
        }

        $settings = [
            'hero_badge' => $heroBadge,
            'hero_title' => $heroTitle,
            'hero_description' => $heroDescription,
            'hero_background_image' => $heroBackgroundImage
        ];

        if ($this->model->updateSettings($settings)) {
            setFlashMessage('success', 'Pengaturan hero banner berita berhasil diperbarui!');
        } else {
            setFlashMessage('error', 'Gagal memperbarui pengaturan hero banner berita.');
        }

        header('Location: index.php?action=berita_hero_settings');
        exit;
    }
}

