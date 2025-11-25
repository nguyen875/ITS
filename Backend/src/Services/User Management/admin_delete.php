<?php
// Admin delete user class
require_once __DIR__ . '/../../utils/security_utils.php';
require_once __DIR__ . '/../Data Access Object/admin_DAO.php';

class admin_delete {
    private $admin_DAO;

    public function __construct() {
        $this->admin_DAO = new admin_DAO();
    }

    /**
     * Delete a user.
     * Expects $request_data: ['user_id'=>int]
     * Returns: ['status'=>int, 'body'=>array]
     */
    public function delete(array $request_data): array {
        $user_id = isset($request_data['user_id']) ? (int)$request_data['user_id'] : 0;
        if ($user_id <= 0) {
            return ['status' => 400, 'body' => ['message' => 'user_id is required']];
        }

        try {
            $deleted = $this->admin_DAO->delete_user_account($user_id);
            return ['status' => $deleted ? 200 : 500, 'body' => ['message' => $deleted ? 'User deleted successfully' : 'Failed to delete user']];
        } catch (Exception $e) {
            error_log('admin_delete delete error: ' . $e->getMessage());
            return ['status' => 500, 'body' => ['error' => 'Server error while deleting user']];
        }
    }
}
?>
