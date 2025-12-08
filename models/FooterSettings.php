<?php
class FooterSettingsModel
{
    private $conn;
    private $settings_table = "footer_settings";
    private $pages_table = "footer_available_pages";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getSetting($key, $default = null)
    {
        $query = "SELECT setting_value FROM " . $this->settings_table . " 
                  WHERE setting_key = :key LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':key', $key);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['setting_value'] : $default;
    }

    public function getAllSettings()
    {
        $query = "SELECT setting_key, setting_value FROM " . $this->settings_table;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $settings = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        
        return $settings;
    }

    public function updateSetting($key, $value)
    {
        $query = "INSERT INTO " . $this->settings_table . " (setting_key, setting_value, updated_at)
                  VALUES (:key, :value, CURRENT_TIMESTAMP)
                  ON CONFLICT (setting_key) 
                  DO UPDATE SET setting_value = :value, updated_at = CURRENT_TIMESTAMP";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':key', $key);
        $stmt->bindParam(':value', $value);
        
        return $stmt->execute();
    }

    public function updateSettings($settings)
    {
        $this->conn->beginTransaction();
        
        try {
            foreach ($settings as $key => $value) {
                $this->updateSetting($key, $value);
            }
            
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function getAvailablePages()
    {
        $query = "SELECT * FROM " . $this->pages_table . " 
                  WHERE is_active = true 
                  ORDER BY display_order ASC, page_title ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPageById($id)
    {
        $query = "SELECT * FROM " . $this->pages_table . " WHERE id = :id LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addPage($page_file, $page_title, $page_url, $display_order = 0)
    {
        $query = "INSERT INTO " . $this->pages_table . " 
                  (page_file, page_title, page_url, display_order) 
                  VALUES (:page_file, :page_title, :page_url, :display_order)
                  RETURNING id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':page_file', $page_file);
        $stmt->bindParam(':page_title', $page_title);
        $stmt->bindParam(':page_url', $page_url);
        $stmt->bindParam(':display_order', $display_order, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC)['id'];
        }
        
        return false;
    }

    public function updatePage($id, $page_file, $page_title, $page_url, $display_order)
    {
        $query = "UPDATE " . $this->pages_table . " 
                  SET page_file = :page_file, 
                      page_title = :page_title, 
                      page_url = :page_url, 
                      display_order = :display_order,
                      updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':page_file', $page_file);
        $stmt->bindParam(':page_title', $page_title);
        $stmt->bindParam(':page_url', $page_url);
        $stmt->bindParam(':display_order', $display_order, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function deletePage($id)
    {
        $query = "DELETE FROM " . $this->pages_table . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function getFooterLinks()
    {
        $linksJson = $this->getSetting('footer_links', '[]');
        $linkIds = json_decode($linksJson, true);
        
        if (empty($linkIds) || !is_array($linkIds)) {
            return [];
        }
        
        $placeholders = implode(',', array_fill(0, count($linkIds), '?'));
        $query = "SELECT * FROM " . $this->pages_table . " 
                  WHERE id IN ($placeholders) 
                  ORDER BY display_order ASC, page_title ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute($linkIds);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFooterSocialMedia()
    {
        $socialJson = $this->getSetting('footer_social_media', '[]');
        $socialMedia = json_decode($socialJson, true);
        
        if (empty($socialMedia) || !is_array($socialMedia)) {
            return [];
        }
        
        return array_filter($socialMedia, function($item) {
            return isset($item['enabled']) && $item['enabled'] === true;
        });
    }
}
?>

