<?php
class SocialMediaController
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Display social media settings
     */
    public function index()
    {
        $platforms = $this->model->getAll();
        extract(['platforms' => $platforms]);
        include 'pages/berita/social_media_settings.php';
    }

    /**
     * Update social media settings
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=social_media_settings');
            exit;
        }
        
        // Update each platform
        if (isset($_POST['platforms'])) {
            foreach ($_POST['platforms'] as $platform => $settings) {
                $enabled = isset($settings['enabled']) ? true : false;
                $order = isset($settings['order']) ? (int)$settings['order'] : 0;
                
                $this->model->updateStatus($platform, $enabled);
                $this->model->updateOrder($platform, $order);
            }
            
            setFlashMessage('success', 'Pengaturan media sosial berhasil diupdate!');
        }
        
        header('Location: index.php?action=social_media_settings');
        exit;
    }
}
?>

