<?php

class admin_edit {
    private $admin_DAO;

    public function __construct($admin_DAO) {
        $this->admin_DAO = $admin_DAO;
    }


    public function edit($user_id, $email, $password, $name, $role): array {

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
