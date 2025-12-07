<?php
class DashboardController {
    private $dashboardModel;
    private $recruitmentModel;
    private $root;

    public function __construct($dashboardModel, $recruitmentModel) {
        $this->dashboardModel = $dashboardModel;
        $this->recruitmentModel = $recruitmentModel;
        $this->root = $_SERVER['DOCUMENT_ROOT'] . '/Lab_SE_Website';
    }

    public function index() {
        $this->dashboardModel->refreshStats();

        $stats = $this->dashboardModel->getMainStats();
        
        $jml_pending   = $stats['total_pending'] ?? 0;
        $jml_mahasiswa = $stats['total_mahasiswa'] ?? 0;
        $jml_personil  = $stats['total_personil'] ?? 0;
        $jml_publikasi = $stats['total_publikasi'] ?? 0;
        $jml_visitor   = $this->dashboardModel->getVisitorToday();

        $chart_publikasi = $this->dashboardModel->getChartPublikasi();
        $chart_mahasiswa = $this->dashboardModel->getChartMahasiswa();
        $chart_prodi = $this->dashboardModel->getChartProdi();
        $chart_spesialisasi = $this->dashboardModel->getChartSpesialisasi();

        $all_recruitment = $this->recruitmentModel->getAll(); 
        $recent_applicants = array_slice($all_recruitment, 0, 5); 

        include $this->root . '/admin/pages/dashboard.php';
    }
}
?>