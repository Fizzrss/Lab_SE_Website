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
            $_SESSION['swal_icon'] = 'success';
            $_SESSION['swal_title'] = 'Berhasil!';
            $_SESSION['swal_text'] = 'Komentar berhasil disetujui!';
        } else {
            $_SESSION['swal_icon'] = 'error';
            $_SESSION['swal_title'] = 'Gagal!';
            $_SESSION['swal_text'] = 'Gagal menyetujui komentar!';
        }
        
        header('Location: index.php?action=komentar_list');
        exit;
    }

    // --- 2. REJECT DENGAN SWEETALERT ---
    public function reject($id)
    {
        if ($this->model->updateStatus($id, 'rejected')) {
            $_SESSION['swal_icon'] = 'success';
            $_SESSION['swal_title'] = 'Berhasil!';
            $_SESSION['swal_text'] = 'Komentar berhasil ditolak!';
        } else {
            $_SESSION['swal_icon'] = 'error';
            $_SESSION['swal_title'] = 'Gagal!';
            $_SESSION['swal_text'] = 'Gagal menolak komentar!';
        }
        
        header('Location: index.php?action=komentar_list');
        exit;
    }

    // --- 3. DELETE DENGAN SWEETALERT ---
    public function delete($id)
    {
        if ($this->model->delete($id)) {
            $_SESSION['swal_icon'] = 'success';
            $_SESSION['swal_title'] = 'Berhasil!';
            $_SESSION['swal_text'] = 'Komentar berhasil dihapus!';
        } else {
            $_SESSION['swal_icon'] = 'error';
            $_SESSION['swal_title'] = 'Gagal!';
            $_SESSION['swal_text'] = 'Gagal menghapus komentar!';
        }
        
        header('Location: index.php?action=komentar_list');
        exit;
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Invalid request method'];
        }

        $berita_id = isset($_POST['berita_id']) ? (int)$_POST['berita_id'] : 0;
        $commenter_name = isset($_POST['commenter_name']) ? trim($_POST['commenter_name']) : '';
        $commenter_email = isset($_POST['commenter_email']) ? trim($_POST['commenter_email']) : '';
        $comment_content = isset($_POST['comment_content']) ? trim($_POST['comment_content']) : '';

        if ($berita_id <= 0) return ['success' => false, 'message' => 'Berita ID tidak valid'];
        if (empty($commenter_name)) return ['success' => false, 'message' => 'Nama tidak boleh kosong'];
        if (empty($commenter_email) || !filter_var($commenter_email, FILTER_VALIDATE_EMAIL)) return ['success' => false, 'message' => 'Email tidak valid'];
        if (empty($comment_content)) return ['success' => false, 'message' => 'Komentar tidak boleh kosong'];

        $data = [
            'berita_id' => $berita_id,
            'commenter_name' => $commenter_name,
            'commenter_email' => $commenter_email,
            'comment_content' => $comment_content,
            'status' => 'approved' 
        ];

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

    public function detail($id)
    {
        $comment = $this->model->getById($id);
        include 'pages/berita/detail_komentar.php'; 
    }
}
?>