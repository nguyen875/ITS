<?php
// Admin create user class
require_once __DIR__ . '/../../utils/security_utils.php';
require_once __DIR__ . '/../Data Access Object/admin_DAO.php';

class admin_create {
    private $admin_DAO;

    public function __construct() {
        $this->admin_DAO = new admin_DAO();
    }

    /**
     * Create a new user.
     * Expects $request_data: ['email'=>string, 'password'=>string, 'name'=>string|null, 'role'=>string]
     * Returns: ['status'=>int, 'body'=>array]
     */
    public function create(array $request_data): array {
        $email = $request_data['email'] ?? '';
        $password = $request_data['password'] ?? '';
        $name = $request_data['name'] ?? null;
        $role = $request_data['role'] ?? '';

        if (!security_utils::validate_email($email) || !security_utils::validate_password($password)) {
            return ['status' => 400, 'body' => ['message' => 'Invalid email or password format']];
        }

        $email = security_utils::sanitize_input($email);
        $name = $name !== null ? security_utils::sanitize_input($name) : null;
        $hashed = security_utils::hash_password($password);

        try {
            $created = $this->admin_DAO->create_user_account($email, $hashed, $name, $role);
            return ['status' => $created ? 200 : 500, 'body' => ['message' => $created ? 'User created successfully' : 'Failed to create user']];
        } catch (Exception $e) {
            error_log('admin_create create error: ' . $e->getMessage());
            return ['status' => 500, 'body' => ['error' => 'Server error while creating user']];
        }
    }
}
?>
