<?php
class BeritaModel
{
    private $conn;
    private $table_name = "berita";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll($limit = 10, $offset = 0, $kategori = null, $search = null, $status = 'published')
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE 1=1";
    
        if ($status) {
            $query .= " AND status = :status";
        }
        
        if ($kategori) {
            $query .= " AND kategori = :kategori";
        }
        
        if ($search) {
            $query .= " AND (judul ILIKE :search OR isi_singkat ILIKE :search OR isi_lengkap ILIKE :search)";
        }
        
        $query .= " ORDER BY tanggal_publikasi DESC, created_at DESC LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        
        if ($status) {
            $stmt->bindParam(':status', $status);
        }
        
        if ($kategori) {
            $stmt->bindParam(':kategori', $kategori);
        }
        
        if ($search) {
            $searchTerm = "%$search%";
            $stmt->bindParam(':search', $searchTerm);
        }
        
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllForAdmin($limit = 10, $offset = 0, $kategori = null, $search = null)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE 1=1";
        
        if ($kategori) {
            $query .= " AND kategori = :kategori";
        }
        
        if ($search) {
            $query .= " AND (judul ILIKE :search OR isi_singkat ILIKE :search OR isi_lengkap ILIKE :search)";
        }
        
        $query .= " ORDER BY tanggal_publikasi DESC, created_at DESC LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        
        if ($kategori) {
            $stmt->bindParam(':kategori', $kategori);
        }
        
        if ($search) {
            $searchTerm = "%$search%";
            $stmt->bindParam(':search', $searchTerm);
        }
        
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll($kategori = null, $search = null, $status = 'published')
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE 1=1";
        
        if ($status) {
            $query .= " AND status = :status";
        }
        
        if ($kategori) {
            $query .= " AND kategori = :kategori";
        }
        
        if ($search) {
            $query .= " AND (judul ILIKE :search OR isi_singkat ILIKE :search OR isi_lengkap ILIKE :search)";
        }
        
        $stmt = $this->conn->prepare($query);
        
        if ($status) {
            $stmt->bindParam(':status', $status);
        }
        
        if ($kategori) {
            $stmt->bindParam(':kategori', $kategori);
        }
        
        if ($search) {
            $searchTerm = "%$search%";
            $stmt->bindParam(':search', $searchTerm);
        }
        
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function countAllForAdmin($kategori = null, $search = null)
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE 1=1";
        
        if ($kategori) {
            $query .= " AND kategori = :kategori";
        }
        
        if ($search) {
            $query .= " AND (judul ILIKE :search OR isi_singkat ILIKE :search OR isi_lengkap ILIKE :search)";
        }
        
        $stmt = $this->conn->prepare($query);
        
        if ($kategori) {
            $stmt->bindParam(':kategori', $kategori);
        }
        
        if ($search) {
            $searchTerm = "%$search%";
            $stmt->bindParam(':search', $searchTerm);
        }
        
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
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
                  (judul, kategori, tanggal_publikasi, penulis, gambar, isi_singkat, isi_lengkap, status, slug) 
                  VALUES (:judul, :kategori, :tanggal_publikasi, :penulis, :gambar, :isi_singkat, :isi_lengkap, :status, :slug)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':judul', $data['judul']);
        $stmt->bindParam(':kategori', $data['kategori']);
        $stmt->bindParam(':tanggal_publikasi', $data['tanggal_publikasi']);
        $stmt->bindParam(':penulis', $data['penulis']);
        $stmt->bindParam(':gambar', $data['gambar']);
        $stmt->bindParam(':isi_singkat', $data['isi_singkat']);
        $stmt->bindParam(':isi_lengkap', $data['isi_lengkap']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':slug', $data['slug']);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    /**
     * Update berita
     */
    public function update($id, $data)
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET judul = :judul, 
                      kategori = :kategori, 
                      tanggal_publikasi = :tanggal_publikasi, 
                      penulis = :penulis, 
                      gambar = :gambar, 
                      isi_singkat = :isi_singkat, 
                      isi_lengkap = :isi_lengkap, 
                      status = :status,
                      slug = :slug,
                      updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':judul', $data['judul']);
        $stmt->bindParam(':kategori', $data['kategori']);
        $stmt->bindParam(':tanggal_publikasi', $data['tanggal_publikasi']);
        $stmt->bindParam(':penulis', $data['penulis']);
        $stmt->bindParam(':gambar', $data['gambar']);
        $stmt->bindParam(':isi_singkat', $data['isi_singkat']);
        $stmt->bindParam(':isi_lengkap', $data['isi_lengkap']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':slug', $data['slug']);
        
        return $stmt->execute();
    }

    /**
     * Delete berita
     */
    public function delete($id)
    {
        // Get gambar path first to delete file
        $berita = $this->getById($id);
        
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            // Delete image file if exists
            if ($berita && $berita['gambar'] && file_exists($berita['gambar'])) {
                unlink($berita['gambar']);
            }
            return true;
        }
        return false;
    }

    /**
     * Get all categories
     */
    public function getCategories()
    {
        $query = "SELECT DISTINCT kategori FROM " . $this->table_name . " ORDER BY kategori ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Generate slug from title
     */
    public function generateSlug($title)
    {
        // Convert to lowercase
        $slug = strtolower($title);
        
        // Replace spaces with hyphens
        $slug = str_replace(' ', '-', $slug);
        
        // Remove special characters
        $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);
        
        // Remove multiple hyphens
        $slug = preg_replace('/-+/', '-', $slug);
        
        // Trim hyphens from ends
        $slug = trim($slug, '-');
        
        return $slug;
    }

    /**
     * Check if slug exists
     */
    public function slugExists($slug, $excludeId = null)
    {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE slug = :slug";
        
        if ($excludeId) {
            $query .= " AND id != :id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':slug', $slug);
        
        if ($excludeId) {
            $stmt->bindParam(':id', $excludeId, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }

    /**
     * Get berita by slug
     */
    public function getBySlug($slug)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE slug = :slug LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get latest berita
     */
    public function getLatest($limit = 5)
    {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE status = 'published' 
                  ORDER BY tanggal_publikasi DESC, created_at DESC 
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
