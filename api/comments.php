<?php
header('Content-Type: application/json');

require_once '../config/config.php';
require_once '../models/KomentarBerita.php';

// Initialize database
$database = new Database();
$db = $database->getConnection();
$komentarModel = new KomentarBeritaModel($db);

// Handle CORS if needed
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Get comments for a berita
        $berita_id = isset($_GET['berita_id']) ? (int)$_GET['berita_id'] : 0;
        
        if ($berita_id > 0) {
            $comments = $komentarModel->getByBeritaId($berita_id, 'approved');
            
            // Format comments for display
            $formattedComments = array_map(function($comment) {
                return [
                    'id' => $comment['id'],
                    'commenter_name' => htmlspecialchars($comment['commenter_name']),
                    'comment_content' => htmlspecialchars($comment['comment_content']),
                    'created_at' => date('d F Y, H:i', strtotime($comment['created_at']))
                ];
            }, $comments);
            
            echo json_encode([
                'success' => true,
                'comments' => $formattedComments,
                'count' => count($formattedComments)
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Berita ID tidak valid'
            ]);
        }
        break;
        
    case 'POST':
        // Create new comment
        $data = [
            'berita_id' => isset($_POST['berita_id']) ? (int)$_POST['berita_id'] : 0,
            'commenter_name' => isset($_POST['commenter_name']) ? trim($_POST['commenter_name']) : '',
            'commenter_email' => isset($_POST['commenter_email']) ? trim($_POST['commenter_email']) : '',
            'comment_content' => isset($_POST['comment_content']) ? trim($_POST['comment_content']) : '',
            'status' => 'approved' // Auto-approve, langsung tampil
        ];
        
        // Validation
        if (empty($data['berita_id']) || empty($data['commenter_name']) || 
            empty($data['commenter_email']) || empty($data['comment_content'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Semua field harus diisi'
            ]);
            exit;
        }
        
        // Email validation
        if (!filter_var($data['commenter_email'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                'success' => false,
                'message' => 'Format email tidak valid'
            ]);
            exit;
        }
        
        // Save comment
        $commentId = $komentarModel->create($data);
        
        if ($commentId) {
            // Get the newly created comment to return
            $newComment = $komentarModel->getById($commentId);
            
            echo json_encode([
                'success' => true,
                'message' => 'Komentar berhasil dikirim',
                'comment_id' => $commentId,
                'comment' => [
                    'id' => $newComment['id'],
                    'commenter_name' => htmlspecialchars($newComment['commenter_name']),
                    'comment_content' => htmlspecialchars($newComment['comment_content']),
                    'created_at' => date('d F Y, H:i', strtotime($newComment['created_at']))
                ]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Gagal menyimpan komentar'
            ]);
        }
        break;
        
    default:
        echo json_encode([
            'success' => false,
            'message' => 'Method tidak didukung'
        ]);
        break;
}
?>

