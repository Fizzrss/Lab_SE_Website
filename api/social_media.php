<?php
header('Content-Type: application/json');

require_once '../config/config.php';
require_once '../models/SocialMediaSettings.php';

// Initialize database
$database = new Database();
$db = $database->getConnection();
$socialModel = new SocialMediaSettingsModel($db);

// Handle CORS if needed
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

// Get enabled social media platforms
$platforms = $socialModel->getEnabled();

$result = [];
foreach ($platforms as $platform) {
    $result[] = [
        'platform' => $platform['platform'],
        'enabled' => $platform['enabled'],
        'order' => $platform['display_order']
    ];
}

echo json_encode([
    'success' => true,
    'platforms' => $result
]);
?>

