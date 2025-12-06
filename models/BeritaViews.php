<?php
class BeritaViewsModel
{
    private $conn;
    private $table_name = "berita_views";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Increment view count for a berita
     */
    public function incrementView($berita_id)
    {
        $today = date('Y-m-d');
        
        // Try to update existing record
        $query = "UPDATE " . $this->table_name . " 
                  SET view_count = view_count + 1
                  WHERE berita_id = :berita_id AND view_date = :view_date";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':berita_id', $berita_id, PDO::PARAM_INT);
        $stmt->bindParam(':view_date', $today);
        
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return true;
        }
        
        // If no record exists, insert new one
        $query = "INSERT INTO " . $this->table_name . " 
                  (berita_id, view_date, view_count) 
                  VALUES (:berita_id, :view_date, 1)
                  ON CONFLICT (berita_id, view_date) DO UPDATE 
                  SET view_count = " . $this->table_name . ".view_count + 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':berita_id', $berita_id, PDO::PARAM_INT);
        $stmt->bindParam(':view_date', $today);
        
        return $stmt->execute();
    }

    /**
     * Get total view count for a berita
     */
    public function getTotalViews($berita_id)
    {
        $query = "SELECT SUM(view_count) as total FROM " . $this->table_name . " 
                  WHERE berita_id = :berita_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':berita_id', $berita_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ? (int)$row['total'] : 0;
    }

    /**
     * Get views by date range (for statistics)
     */
    public function getViewsByDateRange($berita_id, $start_date, $end_date)
    {
        $query = "SELECT view_date, view_count FROM " . $this->table_name . " 
                  WHERE berita_id = :berita_id 
                  AND view_date BETWEEN :start_date AND :end_date
                  ORDER BY view_date ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':berita_id', $berita_id, PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

