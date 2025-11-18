<?php 
    require_once __DIR__ . '/../../../Config/dbConnect.php';
    class database_connection {
        private static ?database_connection $db_instance = null;
        private ?PDO $conn = null;
        private function __construct() {
            $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->conn = new PDO($dsn, DB_USER, DB_PASS, $options);
            try {

            } catch(\PDOException $e) {
                error_log("Database connection error: " . $e->getMessage());
                throw new Exception("Application Error: Database connection failed.");
            }
        }

        public static function get_instance() : database_connection {
            if (self::$db_instance == null) {
                self::$db_instance = new self();
            }
            return self::$db_instance;
        }
        public function get_connection() : PDO {
            return $this->conn;
        }
    }
?>