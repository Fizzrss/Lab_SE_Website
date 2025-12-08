<?php
class BeritaSettingsModel
{
    private $conn;
    private $table_name = "berita_settings";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getSetting($key, $default = null)
    {
        $query = "SELECT setting_value FROM " . $this->table_name . " 
                  WHERE setting_key = :key LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':key', $key);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['setting_value'] : $default;
    }

    public function getAllSettings()
    {
        $query = "SELECT setting_key, setting_value FROM " . $this->table_name;
        
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
        $query = "INSERT INTO " . $this->table_name . " (setting_key, setting_value, updated_at)
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
        $success = true;
        foreach ($settings as $key => $value) {
            if (!$this->updateSetting($key, $value)) {
                $success = false;
            }
        }
        return $success;
    }
}

