<?php
class RelatedPostsSettingsModel
{
    private $conn;
    private $table_name = "related_posts_settings";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getSettings()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return [
                'enabled' => true,
                'max_posts' => 3,
                'show_same_category' => true
            ];
        }
        
        return $result;
    }

    public function update($data)
    {
        $existing = $this->getSettings();
        
        if (isset($existing['id'])) {
            $query = "UPDATE " . $this->table_name . " 
                      SET enabled = :enabled, 
                          max_posts = :max_posts, 
                          show_same_category = :show_same_category,
                          updated_at = CURRENT_TIMESTAMP
                      WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $existing['id'], PDO::PARAM_INT);
            $stmt->bindParam(':enabled', $data['enabled'], PDO::PARAM_BOOL);
            $stmt->bindParam(':max_posts', $data['max_posts'], PDO::PARAM_INT);
            $stmt->bindParam(':show_same_category', $data['show_same_category'], PDO::PARAM_BOOL);
            
            return $stmt->execute();
        } else {
            $query = "INSERT INTO " . $this->table_name . " 
                      (enabled, max_posts, show_same_category) 
                      VALUES (:enabled, :max_posts, :show_same_category)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':enabled', $data['enabled'], PDO::PARAM_BOOL);
            $stmt->bindParam(':max_posts', $data['max_posts'], PDO::PARAM_INT);
            $stmt->bindParam(':show_same_category', $data['show_same_category'], PDO::PARAM_BOOL);
            
            return $stmt->execute();
        }
    }
}
?>

