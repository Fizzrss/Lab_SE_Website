<?php
class KomentarController
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Display list of comments for admin
     */
    public function index()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        // Show all approved comments (komentar langsung tampil)
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

    /**
     * Approve comment
     */
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

    /**
     * Reject comment
     */
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

    /**
     * Delete comment
     */
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

