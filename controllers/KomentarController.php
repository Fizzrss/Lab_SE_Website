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

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return [
                'success' => false,
                'message' => 'Invalid request method'
            ];
        }

        // Validasi input
        $berita_id = isset($_POST['berita_id']) ? (int)$_POST['berita_id'] : 0;
        $commenter_name = isset($_POST['commenter_name']) ? trim($_POST['commenter_name']) : '';
        $commenter_email = isset($_POST['commenter_email']) ? trim($_POST['commenter_email']) : '';
        $comment_content = isset($_POST['comment_content']) ? trim($_POST['comment_content']) : '';

        // Validasi
        if ($berita_id <= 0) {
            return [
                'success' => false,
                'message' => 'Berita ID tidak valid'
            ];
        }

        if (empty($commenter_name)) {
            return [
                'success' => false,
                'message' => 'Nama tidak boleh kosong'
            ];
        }

        if (empty($commenter_email) || !filter_var($commenter_email, FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'message' => 'Email tidak valid'
            ];
        }

        if (empty($comment_content)) {
            return [
                'success' => false,
                'message' => 'Komentar tidak boleh kosong'
            ];
        }

        // Prepare data
        $data = [
            'berita_id' => $berita_id,
            'commenter_name' => $commenter_name,
            'commenter_email' => $commenter_email,
            'comment_content' => $comment_content,
            'status' => 'approved' // Auto-approve, bisa diubah ke 'pending' untuk moderation
        ];

        // Create comment
        $comment_id = $this->model->create($data);

        if ($comment_id) {
            return [
                'success' => true,
                'message' => 'Komentar berhasil dikirim!',
                'comment_id' => $comment_id
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Gagal menyimpan komentar. Silakan coba lagi.'
            ];
        }
    }
}
?>

