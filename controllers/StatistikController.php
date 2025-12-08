    <?php
    class StatistikController {
        private $db;
        private $personilModel;
        private $publikasiModel;
        private $mahasiswaAktifModel;

        public function __construct() {
            $root = dirname(__DIR__); 
            
            require_once $root . '/config/config.php';
            require_once $root . '/models/Personil.php';
            require_once $root . '/models/PublikasiModel.php';
            require_once $root . '/models/MahasiswaAktifModel.php';

            $database = new Database();
            $this->db = $database->getConnection();

            $this->personilModel = new PersonilModel($this->db);
            $this->publikasiModel = new PublikasiModel($this->db);
            $this->mahasiswaAktifModel = new MahasiswaAktifModel($this->db);
        }

        public function getStats() {
            $jml_personil  = $this->personilModel->countAll() ?? 0;
            $jml_publikasi = $this->publikasiModel->countAll() ?? 0;
            $jml_mahasiswa = $this->mahasiswaAktifModel->countAktif();

            $jml_visitor = 0;
            try {
                $sqlVis = "SELECT COUNT(*) FROM recruitment";
                $stmtVis = $this->db->query($sqlVis);
                $jml_visitor = $stmtVis->fetchColumn();
            } catch (Exception $e) { $jml_visitor = 0; }

            return [
                'jml_visitor'   => $jml_visitor,
                'jml_personil'  => $jml_personil,
                'jml_mahasiswa' => $jml_mahasiswa,
                'jml_publikasi' => $jml_publikasi
            ];
        }
    }
    ?>