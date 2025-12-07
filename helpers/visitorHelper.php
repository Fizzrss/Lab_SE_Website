<?php
class VisitorHelper {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function recordVisit() {
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $today = date('Y-m-d');

        $checkQuery = "SELECT COUNT(*) FROM visitors WHERE ip_address = :ip AND access_date = :date";
        $stmt = $this->conn->prepare($checkQuery);
        $stmt->execute([':ip' => $ip_address, ':date' => $today]);
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            $insertQuery = "INSERT INTO visitors (ip_address, access_date, user_agent) VALUES (:ip, :date, :agent)";
            $stmtInsert = $this->conn->prepare($insertQuery);
            $stmtInsert->execute([
                ':ip' => $ip_address, 
                ':date' => $today,
                ':agent' => $user_agent
            ]);
        }
    }
}
?>