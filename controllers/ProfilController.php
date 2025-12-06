<?php
class ProfilController
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Display profil sections management page
     */
    public function index()
    {
        $sections = $this->model->getAll(false);
        $heroSettings = $this->model->getHeroSettings();
        
        extract([
            'sections' => $sections,
            'heroSettings' => $heroSettings
        ]);
        
        include 'pages/profil/settings.php';
    }

    /**
     * Update section
     */
    public function updateSection()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=profil_settings');
            exit;
        }

        $sectionKey = $_POST['section_key'] ?? '';
        $title = $_POST['section_title'] ?? '';
        $contentJson = $_POST['section_content'] ?? '{}';
        
        // Validate JSON
        $contentData = json_decode($contentJson, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            setFlashMessage('danger', 'Format data tidak valid!');
            header('Location: index.php?action=profil_settings');
            exit;
        }
        
        $isActive = true; // Default active, can be changed via AJAX later
        $displayOrder = 0; // Can be changed later if needed

        if ($this->model->update($sectionKey, $title, $contentJson, $isActive, $displayOrder)) {
            setFlashMessage('success', 'Section berhasil diperbarui!');
        } else {
            setFlashMessage('danger', 'Gagal memperbarui section!');
        }

        header('Location: index.php?action=profil_settings');
        exit;
    }

    /**
     * Update hero settings
     */
    public function updateHero()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=profil_settings');
            exit;
        }

        $settings = [
            'hero_title' => $_POST['hero_title'] ?? '',
            'hero_subtitle' => $_POST['hero_subtitle'] ?? '',
            'hero_description' => $_POST['hero_description'] ?? '',
            'hero_background_image' => $_POST['hero_background_image'] ?? '',
            'hero_button_text' => $_POST['hero_button_text'] ?? 'Get Started',
            'hero_button_link' => $_POST['hero_button_link'] ?? '#profil'
        ];

        $success = true;
        foreach ($settings as $key => $value) {
            if (!$this->model->updateHeroSetting($key, $value)) {
                $success = false;
            }
        }

        if ($success) {
            setFlashMessage('success', 'Pengaturan Hero berhasil diperbarui!');
        } else {
            setFlashMessage('danger', 'Gagal memperbarui pengaturan Hero!');
        }

        header('Location: index.php?action=profil_settings');
        exit;
    }
}
?>

