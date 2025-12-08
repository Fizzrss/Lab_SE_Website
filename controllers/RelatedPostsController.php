<?php
class RelatedPostsController
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $settings = $this->model->getSettings();
        extract(['settings' => $settings]);
        include 'pages/berita/related_posts_settings.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=related_posts_settings');
            exit;
        }
        
        $data = [
            'enabled' => isset($_POST['enabled']) ? true : false,
            'max_posts' => isset($_POST['max_posts']) ? (int)$_POST['max_posts'] : 3,
            'show_same_category' => isset($_POST['show_same_category']) ? true : false
        ];
        
        if ($this->model->update($data)) {
            setFlashMessage('success', 'Pengaturan related posts berhasil diupdate!');
        } else {
            setFlashMessage('danger', 'Gagal mengupdate pengaturan related posts!');
        }
        
        header('Location: index.php?action=related_posts_settings');
        exit;
    }
}
?>

