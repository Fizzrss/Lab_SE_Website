<?php
class SocialMediaSettingsModel
{
    private $conn;
    private $table_name = "social_media_settings";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table_name . " 
                  ORDER BY display_order ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEnabled()
    {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE enabled = true 
                  ORDER BY display_order ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($platform, $enabled)
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET enabled = :enabled, updated_at = CURRENT_TIMESTAMP
                  WHERE platform = :platform";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':platform', $platform);
        $stmt->bindParam(':enabled', $enabled, PDO::PARAM_BOOL);
        
        return $stmt->execute();
    }

    public function updateOrder($platform, $order)
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET display_order = :order, updated_at = CURRENT_TIMESTAMP
                  WHERE platform = :platform";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':platform', $platform);
        $stmt->bindParam(':order', $order, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
?>

