<?php
class FooterController
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $settings = $this->model->getAllSettings();
        $availablePages = $this->model->getAvailablePages();
        $selectedLinks = $this->model->getFooterLinks();
        $selectedLinkIds = array_column($selectedLinks, 'id');
        
        extract([
            'settings' => $settings,
            'availablePages' => $availablePages,
            'selectedLinkIds' => $selectedLinkIds
        ]);
        
        include 'pages/footer/settings.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=footer_settings');
            exit;
        }

        $settings = [];

        $settings['footer_about_title'] = $_POST['footer_about_title'] ?? '';
        $settings['footer_about_address'] = $_POST['footer_about_address'] ?? '';
        $settings['footer_about_phone'] = $_POST['footer_about_phone'] ?? '';
        $settings['footer_about_email'] = $_POST['footer_about_email'] ?? '';
        $settings['footer_links_title'] = $_POST['footer_links_title'] ?? 'Useful Links';
        $selectedPages = isset($_POST['footer_links']) && is_array($_POST['footer_links']) 
            ? $_POST['footer_links'] 
            : [];
        $settings['footer_links'] = json_encode($selectedPages);
        $settings['footer_social_title'] = $_POST['footer_social_title'] ?? 'Connect With Us';
        $settings['footer_social_description'] = $_POST['footer_social_description'] ?? '';

        $socialMedia = [];
        $platforms = ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'tiktok', 'whatsapp', 'telegram'];
        
        foreach ($platforms as $platform) {
            $enabled = isset($_POST['social_media'][$platform]['enabled']);
            $url = $_POST['social_media'][$platform]['url'] ?? '';
            $order = isset($_POST['social_media'][$platform]['order']) 
                ? (int)$_POST['social_media'][$platform]['order'] 
                : 0;
            
            if ($enabled && !empty($url)) {
                $socialMedia[] = [
                    'platform' => $platform,
                    'url' => $url,
                    'enabled' => true,
                    'order' => $order
                ];
            }
        }
        
        usort($socialMedia, function($a, $b) {
            return $a['order'] - $b['order'];
        });
        
        $settings['footer_social_media'] = json_encode($socialMedia);
        
        $settings['footer_copyright'] = $_POST['footer_copyright'] ?? '';

        if ($this->model->updateSettings($settings)) {
            setFlashMessage('success', 'Pengaturan footer berhasil disimpan!');
        } else {
            setFlashMessage('danger', 'Gagal menyimpan pengaturan footer!');
        }
        
        header('Location: index.php?action=footer_settings');
        exit;
    }

    public function getFooterData()
    {
        return [
            'about' => [
                'title' => $this->model->getSetting('footer_about_title', 'Laboratorium Software Engineering'),
                'address' => $this->model->getSetting('footer_about_address', ''),
                'phone' => $this->model->getSetting('footer_about_phone', ''),
                'email' => $this->model->getSetting('footer_about_email', '')
            ],
            'links' => [
                'title' => $this->model->getSetting('footer_links_title', 'Useful Links'),
                'items' => $this->model->getFooterLinks()
            ],
            'social' => [
                'title' => $this->model->getSetting('footer_social_title', 'Connect With Us'),
                'description' => $this->model->getSetting('footer_social_description', ''),
                'items' => $this->model->getFooterSocialMedia()
            ],
            'copyright' => $this->model->getSetting('footer_copyright', '© Copyright Lab Software Engineering. All Rights Reserved')
        ];
    }
}
?>

