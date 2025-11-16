<?php
    require_once __DIR__ . '/../Persistence Layer/database_connection.php';
    class student_DAO {
        private $conn;

        public function __construct() {
            $this->conn = database_connection::get_instance()->get_connection();
        }
        public function create_student_account($email, $password): bool { // true: success create account, false: fail to create
            try {
                $this->conn->beginTransaction();

                $create_user_account_sql = 'INSERT INTO user (email, password, role) VALUES (?, ?, ?)';
                $create_user_account_stmt = $this->conn->prepare($create_user_account_sql);
                $create_user_account_stmt->execute([$email, $password, 'student']);
                $user_ID = $this->conn->lastInsertId();

                $create_student_account_sql = 'INSERT INTO student (user_id, enrollment_year) VALUES (?, ?)';
                $create_student_account_stmt = $this->conn->prepare($create_student_account_sql);
                $create_student_account_stmt->execute([$user_ID, date('Y')]);

                $this->conn->commit();
                return true;
            } catch(\PDOException $e) {
                $this->conn->rollBack();
                error_log('Create user and student account error: ' . $e->getMessage());
                return false;
            }

        }

        public function retrieve_student_account_by_email($email) {
            $retrieve_student_account_sql = 'SELECT email, password FROM user WHERE email = ? AND role = ' . 'student';
            $retrieve_student_account_stmt = $this->conn->prepare($retrieve_student_account_sql);
            $retrieve_student_account_stmt->execute([$email]);

            $result = $retrieve_student_account_stmt->fetch();
            return $result ?: null;
        }

        public function update_student_account(&$attribute_list, &$update_value_list) {

        }
    }
?>