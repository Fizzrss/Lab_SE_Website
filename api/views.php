<?php
header('Content-Type: application/json');

require_once '../config/config.php';
require_once '../models/BeritaViews.php';

// Initialize database
$database = new Database();
$db = $database->getConnection();
$viewsModel = new BeritaViewsModel($db);

// Handle CORS if needed
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Get view count for a berita
        $berita_id = isset($_GET['berita_id']) ? (int)$_GET['berita_id'] : 0;
        
        if ($berita_id > 0) {
            $viewCount = $viewsModel->getTotalViews($berita_id);
            
            echo json_encode([
                'success' => true,
                'view_count' => $viewCount
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Berita ID tidak valid'
            ]);
        }
        break;
        
    case 'POST':
        // Increment view count
        $input = json_decode(file_get_contents('php://input'), true);
        $berita_id = isset($input['berita_id']) ? (int)$input['berita_id'] : 0;
        
        if ($berita_id > 0) {
            // Simple session check to prevent multiple counts from same user
            session_start();
            $sessionKey = 'viewed_berita_' . $berita_id;
            
            if (!isset($_SESSION[$sessionKey])) {
                $viewsModel->incrementView($berita_id);
                $_SESSION[$sessionKey] = true;
            }
            
            $viewCount = $viewsModel->getTotalViews($berita_id);
            
            echo json_encode([
                'success' => true,
                'view_count' => $viewCount
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Berita ID tidak valid'
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

