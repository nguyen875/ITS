<?php
    require_once __DIR__ . '/../Persistence Layer/database_connection.php';
    class user_DAO {
        private $conn;

        public function __construct() {
            $this->conn = database_connection::get_instance()->get_connection();
        }
        // public function create_student_account($email, $password): bool {
        //     try {
        //         $this->conn->beginTransaction();

        //         $create_user_account_sql = 'INSERT INTO user (email, password, role) VALUES (?, ?, ?)';
        //         $create_user_account_stmt = $this->conn->prepare($create_user_account_sql);
        //         $create_user_account_stmt->execute([$email, $password, 'student']);
        //         $user_ID = $this->conn->lastInsertId();

        //         $create_student_account_sql = 'INSERT INTO student (user_id, enrollment_year) VALUES (?, ?)';
        //         $create_student_account_stmt = $this->conn->prepare($create_student_account_sql);
        //         $create_student_account_stmt->execute([$user_ID, date('Y')]);

        //         $this->conn->commit();
        //         return true;
        //     } catch(\PDOException $e) {
        //         $this->conn->rollBack();
        //         error_log('Create user and student account error: ' . $e->getMessage());
        //         throw new Exception("Application error: Failed to create user and student account");
        //     }

        // }

        public function retrieve_user_account_by_email($email): array {
            try {
                $retrieve_user_account_sql = 'SELECT user_id, email, password, role FROM user WHERE email = ?';
                $retrieve_user_account_stmt = $this->conn->prepare($retrieve_user_account_sql);
                $retrieve_user_account_stmt->execute([$email]);

                $result = $retrieve_user_account_stmt->fetch();
                return $result ?: null;
            } catch(PDOException $e) {
                error_log('Retrieve user account error: ' . $e->getMessage());
                throw new Exception("Can not retrieve user account");
            }
        }

        public function update_student_account(&$attribute_list, &$update_value_list) {

        }
    }
?>