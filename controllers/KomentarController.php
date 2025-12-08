<?php
class KomentarController
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
    
        $comments = $this->model->getAll($limit, $offset, 'approved');
        $totalComments = $this->model->countAll('approved');
        $totalPages = ceil($totalComments / $limit);
        
        extract([
            'comments' => $comments,
            'totalComments' => $totalComments,
            'totalPages' => $totalPages,
            'page' => $page,
            'offset' => $offset
        ]);
        
        include 'pages/berita/list_komentar.php';
    }

    public function approve($id)
    {
        if ($this->model->updateStatus($id, 'approved')) {
            setFlashMessage('success', 'Komentar berhasil disetujui!');
        } else {
            setFlashMessage('danger', 'Gagal menyetujui komentar!');
        }
        
        header('Location: index.php?action=komentar_list');
        exit;
    }

    public function reject($id)
    {
        if ($this->model->updateStatus($id, 'rejected')) {
            setFlashMessage('success', 'Komentar berhasil ditolak!');
        } else {
            setFlashMessage('danger', 'Gagal menolak komentar!');
        }
        
        header('Location: index.php?action=komentar_list');
        exit;
    }

    public function delete($id)
    {
        if ($this->model->delete($id)) {
            setFlashMessage('success', 'Komentar berhasil dihapus!');
        } else {
            setFlashMessage('danger', 'Gagal menghapus komentar!');
        }
        
        header('Location: index.php?action=komentar_list');
        exit;
    }
}
?>

