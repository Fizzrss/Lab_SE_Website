<?php
class DashboardModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function refreshStats() {
        try {
            $query = "REFRESH MATERIALIZED VIEW mv_dashboard_stats";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        } catch (Exception $e) {
            error_log("Error refreshView: " . $e->getMessage());
            return false;
        }
    }

    public function getMainStats() {
        try {
            $query = "SELECT * FROM mv_dashboard_stats LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [
                'total_pending' => 0, 'total_mahasiswa' => 0, 
                'total_personil' => 0, 'total_publikasi' => 0
            ];
        }
    }

    public function getChartPublikasi() {
        $query = "SELECT tahun, COUNT(*) as total 
                  FROM publikasi 
                  GROUP BY tahun 
                  ORDER BY tahun ASC 
                  LIMIT 7"; // Ambil 7 tahun terakhir
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getChartMahasiswa() {
        $query = "SELECT angkatan, COUNT(*) as total 
                  FROM mahasiswa_aktif 
                  WHERE status = 'aktif'
                  GROUP BY angkatan 
                  ORDER BY angkatan DESC 
                  LIMIT 5";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getVisitorToday() {
        try {
            $query = "SELECT COUNT(*) FROM visitors";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (Exception $e) { return 0; }
    }

    public function getChartProdi() {
        $query = "SELECT prodi, COUNT(*) as total 
                  FROM mahasiswa_aktif 
                  WHERE status = 'aktif'
                  GROUP BY prodi";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getChartSpesialisasi() {
        $query = "SELECT s.nama_spesialisasi, COUNT(ps.id_personil) as total
                  FROM personil_spesialisasi ps
                  JOIN spesialisasi s ON ps.id_spesialisasi = s.id_spesialisasi
                  GROUP BY s.nama_spesialisasi
                  ORDER BY total DESC
                  LIMIT 10";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>