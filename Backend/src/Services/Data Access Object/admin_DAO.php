<?php
require_once __DIR__ . '/../Persistence Layer/database_connection.php';

class admin_DAO {
    private $conn;

    public function __construct() {
        $this->conn = database_connection::get_instance()->get_connection();
    }

    /**
     * Create user account and role-specific record.
     * Returns true on success, throws Exception on failure.
     */
    public function create_user_account(string $email, string $hashed_password, ?string $name, string $role): bool {
        try {
            $this->conn->beginTransaction();

            $is_active = 1;
            $sql = 'INSERT INTO `user` (email, password, name, role, is_active) VALUES (?, ?, ?, ?, ?)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$email, $hashed_password, $name, $role, $is_active]);
            $userId = $this->conn->lastInsertId();

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
                case 'Admin':
                    $sql = 'INSERT INTO admin (user_id) VALUES (?)';
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
            error_log('admin_DAO create_user_account error: ' . $e->getMessage());
            throw new Exception('Failed to create user account');
        }
    }

    /**
     * Update user account. Any null parameter will be left unchanged.
     * If role changes, move role-specific record accordingly.
     * Returns true on success.
     */
    public function update_user_account(int $user_id, ?string $email, ?string $hashed_password, ?string $name, ?string $new_role): bool {
        try {
            $this->conn->beginTransaction();

            // Fetch current user and role
            $selectSql = 'SELECT role FROM `user` WHERE user_id = ?';
            $selectStmt = $this->conn->prepare($selectSql);
            $selectStmt->execute([$user_id]);
            $current = $selectStmt->fetch();
            if (!$current) {
                $this->conn->rollBack();
                throw new Exception('User not found');
            }
            $current_role = $current['role'];

            // Build update dynamically
            $fields = [];
            $values = [];
            if ($email !== null) { $fields[] = 'email = ?'; $values[] = $email; }
            if ($hashed_password !== null) { $fields[] = 'password = ?'; $values[] = $hashed_password; }
            if ($name !== null) { $fields[] = 'name = ?'; $values[] = $name; }
            if ($new_role !== null) { $fields[] = 'role = ?'; $values[] = $new_role; }

            if (!empty($fields)) {
                $values[] = $user_id;
                $sql = 'UPDATE `user` SET ' . implode(', ', $fields) . ' WHERE user_id = ?';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute($values);
            }

            // If role changed, remove old role record and create new one
            if ($new_role !== null && $new_role !== $current_role) {
                // Remove old role-specific row if exists
                switch ($current_role) {
                    case 'Student':
                        $this->conn->prepare('DELETE FROM student WHERE user_id = ?')->execute([$user_id]);
                        break;
                    case 'Teacher':
                        $this->conn->prepare('DELETE FROM teacher WHERE user_id = ?')->execute([$user_id]);
                        break;
                    case 'Admin':
                        $this->conn->prepare('DELETE FROM admin WHERE user_id = ?')->execute([$user_id]);
                        break;
                }

                // Insert new role-specific row
                switch ($new_role) {
                    case 'Student':
                        $this->conn->prepare('INSERT INTO student (user_id, enrollment_year) VALUES (?, ?)')->execute([$user_id, date('Y')]);
                        break;
                    case 'Teacher':
                        $this->conn->prepare('INSERT INTO teacher (user_id) VALUES (?)')->execute([$user_id]);
                        break;
                    case 'Admin':
                        $this->conn->prepare('INSERT INTO admin (user_id) VALUES (?)')->execute([$user_id]);
                        break;
                    default:
                        $this->conn->rollBack();
                        throw new InvalidArgumentException("Invalid new role: $new_role");
                }
            }

            $this->conn->commit();
            return true;
        } catch (\Exception $e) {
            $this->conn->rollBack();
            error_log('admin_DAO update_user_account error: ' . $e->getMessage());
            throw new Exception('Failed to update user account');
        }
    }

    /**
     * Delete user account by id. Cascading FKs will remove role-specific rows.
     * Returns true on success.
     */
    public function delete_user_account(int $user_id): bool {
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE FROM `user` WHERE user_id = ?');
            $stmt->execute([$user_id]);
            $this->conn->commit();
            return true;
        } catch (\Exception $e) {
            $this->conn->rollBack();
            error_log('admin_DAO delete_user_account error: ' . $e->getMessage());
            throw new Exception('Failed to delete user account');
        }
    }

    /**
     * Optional helper: retrieve user by email (returns assoc array or null)
     */
    public function retrieve_user_by_email(string $email) {
        try {
            $stmt = $this->conn->prepare('SELECT user_id, email, name, role, is_active FROM `user` WHERE email = ?');
            $stmt->execute([$email]);
            $result = $stmt->fetch();
            return $result ?: null;
        } catch (\Exception $e) {
            error_log('admin_DAO retrieve_user_by_email error: ' . $e->getMessage());
            throw new Exception('Failed to retrieve user');
        }
    }
}
?>
