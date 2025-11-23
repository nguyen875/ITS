<?php
    require_once __DIR__ . '/../Persistence Layer/database_connection.php';
    class user_DAO {
        private $conn;

        public function __construct() {
            $this->conn = database_connection::get_instance()->get_connection();
        }
        public function create_user_account(string $email, string $password, string $role): bool {
            try {
                $this->conn->beginTransaction();

                // Determine activation status
                $is_active = ($role === 'Student');

                // Insert into user table
                $sql = 'INSERT INTO user (email, password, role, is_active) VALUES (?, ?, ?, ?)';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$email, $password, $role, $is_active]);
                $userId = $this->conn->lastInsertId();

                // Handle role-specific inserts
                switch ($role) {
                    case 'Student':
                        $sql = 'INSERT INTO student (user_id, enrollment_year) VALUES (?, ?)';
                        $stmt = $this->conn->prepare($sql);
                        $stmt->execute([$userId, date('Y')]);
                        break;

                    case 'Teacher':
                        $sql = 'INSERT INTO teacher (user_id) VALUES (?)';
                        $stmt = $this->conn->prepare($sql);
                        $stmt->execute([$userId]);
                        break;

                    default:
                        $this->conn->rollBack();
                        throw new InvalidArgumentException("Invalid role: $role");
                }

                $this->conn->commit();
                return true;

            } catch (\Exception $e) {
                $this->conn->rollBack();
                error_log('Create user account error: ' . $e->getMessage());
                throw new Exception("Application error: Failed to create user account");
            }
        }


        public function retrieve_user_account_by_email($email) {
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