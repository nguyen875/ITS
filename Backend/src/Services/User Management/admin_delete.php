<?php
// // Admin delete user class
// require_once __DIR__ . '/../../utils/security_utils.php';
// require_once __DIR__ . '/../Data Access Object/admin_DAO.php';

class admin_delete {
    private $admin_DAO;

    public function __construct($admin_DAO) {
        $this->admin_DAO = $admin_DAO;
    }

    /**
     * Delete a user.
     * Expects $request_data: ['user_id'=>int]
     * Returns: ['status'=>int, 'body'=>array]
     */
    public function delete($user_id): array {

        try {
            $deleted = $this->admin_DAO->delete_user_account($user_id);
            return ['success' => $deleted, 'body' => ['message' => $deleted ? 'User deleted successfully' : 'Failed to delete user']];
        } catch (Exception $e) {
            error_log('admin_delete delete error: ' . $e->getMessage());
            throw new Exception('Server error while deleting user');
        }
    }
}
?>
