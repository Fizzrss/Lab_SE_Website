<?php
class KomentarBeritaModel
{
    private $conn;
    private $table_name = "berita_komentar";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getByBeritaId($berita_id, $status = 'approved')
    {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE berita_id = :berita_id AND status = :status 
                  ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':berita_id', $berita_id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  (berita_id, commenter_name, commenter_email, comment_content, status) 
                  VALUES (:berita_id, :commenter_name, :commenter_email, :comment_content, :status)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':berita_id', $data['berita_id'], PDO::PARAM_INT);
        $stmt->bindParam(':commenter_name', $data['commenter_name']);
        $stmt->bindParam(':commenter_email', $data['commenter_email']);
        $stmt->bindParam(':comment_content', $data['comment_content']);
        $stmt->bindParam(':status', $data['status']);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function updateStatus($id, $status)
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET status = :status, updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);
        
        return $stmt->execute();
    }

    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function countByBeritaId($berita_id, $status = 'approved')
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " 
                  WHERE berita_id = :berita_id AND status = :status";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':berita_id', $berita_id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function getAll($limit = 50, $offset = 0, $status = null)
    {
        $query = "SELECT k.*, b.judul as berita_judul 
                  FROM " . $this->table_name . " k
                  LEFT JOIN berita b ON k.berita_id = b.id
                  WHERE 1=1";
        
        if ($status) {
            $query .= " AND k.status = :status";
        }
        
        $query .= " ORDER BY k.created_at DESC LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        
        if ($status) {
            $stmt->bindParam(':status', $status);
        }
        
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll($status = null)
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE 1=1";
        
        if ($status) {
            $query .= " AND status = :status";
        }
        
        $stmt = $this->conn->prepare($query);
        
        if ($status) {
            $stmt->bindParam(':status', $status);
        }
        
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
?>

