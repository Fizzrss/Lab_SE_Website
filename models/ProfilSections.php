<?php
class ProfilSectionsModel
{
    private $conn;
    private $sections_table = "profil_sections";
    private $hero_table = "hero_settings";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll($onlyActive = true)
    {
        $query = "SELECT * FROM " . $this->sections_table;
        
        if ($onlyActive) {
            $query .= " WHERE is_active = true";
        }
        
        $query .= " ORDER BY display_order ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Decode JSON content
        foreach ($sections as &$section) {
            $section['content_data'] = json_decode($section['section_content'], true);
        }
        
        return $sections;
    }


    public function getByKey($key)
    {
        $query = "SELECT * FROM " . $this->sections_table . " 
                  WHERE section_key = :key LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':key', $key);
        $stmt->execute();
        
        $section = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($section) {
            $section['content_data'] = json_decode($section['section_content'], true);
        }
        
        return $section;
    }


    public function update($key, $title, $content, $isActive = true, $displayOrder = 0)
    {
        $query = "UPDATE " . $this->sections_table . " 
                  SET section_title = :title, 
                      section_content = :content,
                      is_active = :is_active,
                      display_order = :display_order,
                      updated_at = CURRENT_TIMESTAMP
                  WHERE section_key = :key";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':key', $key);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':is_active', $isActive, PDO::PARAM_BOOL);
        $stmt->bindParam(':display_order', $displayOrder, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function getHeroSettings()
    {
        $query = "SELECT setting_key, setting_value FROM " . $this->hero_table;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $settings = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        
        return $settings;
    }

    public function updateHeroSetting($key, $value)
    {
        $query = "INSERT INTO " . $this->hero_table . " (setting_key, setting_value, updated_at)
                  VALUES (:key, :value, CURRENT_TIMESTAMP)
                  ON CONFLICT (setting_key) 
                  DO UPDATE SET setting_value = :value, updated_at = CURRENT_TIMESTAMP";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':key', $key);
        $stmt->bindParam(':value', $value);
        
        return $stmt->execute();
    }
}
?>

