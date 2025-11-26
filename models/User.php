<?php
class User {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getUserByUsername($username) {
        // Sesuaikan nama tabel "user" dan kolom sesuai gambar
        $sql = "SELECT id, username, password, level FROM \"user\" WHERE username = :username LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fungsi update password (jika nanti bikin fitur ganti password)
    public function updatePassword($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        $sql = "UPDATE \"user\" SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':password' => $hashedPassword,
            ':id' => $id
        ]);
    }
}
?>