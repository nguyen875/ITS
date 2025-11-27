<?php
// // Admin edit user class
// require_once __DIR__ . '/../../utils/security_utils.php';
// require_once __DIR__ . '/../Data Access Object/admin_DAO.php';

class admin_edit {
    private $admin_DAO;

    public function __construct($admin_DAO) {
        $this->admin_DAO = $admin_DAO;
    }

    /**
     * Edit an existing user.
     * Expects $request_data: ['user_id'=>int, 'email'=>string|null, 'password'=>string|null, 'name'=>string|null, 'role'=>string|null]
     * Returns: ['status'=>int, 'body'=>array]
     */
    public function edit($user_id, $email, $password, $name, $role): array {
        // $user_id = isset($request_data['user_id']) ? (int)$request_data['user_id'] : 0;
        // if ($user_id <= 0) {
        //     return ['status' => 400, 'body' => ['message' => 'user_id is required']];
        // }

        // $email = $request_data['email'] ?? null;
        // $password = $request_data['password'] ?? null;
        // $name = $request_data['name'] ?? null;
        // $role = $request_data['role'] ?? null;

        // if ($email !== null && !security_utils::validate_email($email)) {
        //     return ['status' => 400, 'body' => ['message' => 'Invalid email format']];
        // }
        // if ($password !== null && !security_utils::validate_password($password)) {
        //     return ['status' => 400, 'body' => ['message' => 'Invalid password format']];
        // }

        $email = $email !== null ? security_utils::sanitize_input($email) : null;
        $name = $name !== null ? security_utils::sanitize_input($name) : null;
        $hashed = $password !== null ? security_utils::hash_password($password) : null;

        try {
            $updated = $this->admin_DAO->update_user_account($user_id, $email, $hashed, $name, $role);
            return ['success' => $updated, 'body' => ['message' => $updated ? 'User updated successfully' : 'Failed to update user']];
        } catch (Exception $e) {
            error_log('admin_edit edit error: ' . $e->getMessage());
            throw new Exception('Server error while updating user');
        }
    }
}
?>
