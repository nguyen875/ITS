<?php
// // Admin create user class
// require_once __DIR__ . '/../../utils/security_utils.php';
// require_once __DIR__ . '/../Data Access Object/admin_DAO.php';

class admin_controller {

    private $security_service;
    public function __construct($security_service) {
        $this->security_service = $security_service;
    }


    // private $admin_DAO;
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

        try {
            $respond = $this->security_service->admin_create($email, $password, $name, $role);
            return  [
                        "status" => 200,
                        "body" => $respond['body']
                    ];
        } catch(Exception $e) {
            return  [
                        "status" => 500,
                        "body" => [
                            "error" => $e->getMessage()
                        ]
                    ];
        }
        // $email = security_utils::sanitize_input($email);
        // $name = $name !== null ? security_utils::sanitize_input($name) : null;
        // $hashed = security_utils::hash_password($password);

        // try {
        //     $created = $this->admin_DAO->create_user_account($email, $hashed, $name, $role);
        //     return ['status' => $created ? 200 : 500, 'body' => ['message' => $created ? 'User created successfully' : 'Failed to create user']];
        // } catch (Exception $e) {
        //     error_log('admin_create create error: ' . $e->getMessage());
        //     return ['status' => 500, 'body' => ['error' => 'Server error while creating user']];
        // }
    }

    public function delete(array $request_data): array {
        $user_id = isset($request_data['user_id']) ? (int)$request_data['user_id'] : 0;
        if ($user_id <= 0) {
            return ['status' => 400, 'body' => ['message' => 'user_id is required']];
        }

        try {
            $respond = $this->security_service->admin_delete($user_id);
            return  [
                        "status" => 200,
                        "body" => $respond['body']
                    ];
        } catch(Exception $e) {
            return  [
                        "status" => 500,
                        "body" => [
                            "error" => $e->getMessage()
                        ]
                    ];
        }

        // try {
        //     $deleted = $this->admin_DAO->delete_user_account($user_id);
        //     return ['status' => $deleted ? 200 : 500, 'body' => ['message' => $deleted ? 'User deleted successfully' : 'Failed to delete user']];
        // } catch (Exception $e) {
        //     error_log('admin_delete delete error: ' . $e->getMessage());
        //     return ['status' => 500, 'body' => ['error' => 'Server error while deleting user']];
        // }
    }
    
    public function edit(array $request_data): array {
        $user_id = isset($request_data['user_id']) ? (int)$request_data['user_id'] : 0;
        if ($user_id <= 0) {
            return ['status' => 400, 'body' => ['message' => 'user_id is required']];
        }

        $email = $request_data['email'] ?? null;
        $password = $request_data['password'] ?? null;
        $name = $request_data['name'] ?? null;
        $role = $request_data['role'] ?? null;

        if ($email !== null && !security_utils::validate_email($email)) {
            return ['status' => 400, 'body' => ['message' => 'Invalid email format']];
        }
        if ($password !== null && !security_utils::validate_password($password)) {
            return ['status' => 400, 'body' => ['message' => 'Invalid password format']];
        }

        try {
            $respond = $this->security_service->admin_edit($user_id, $email, $password, $name, $role);
            return  [
                        "status" => 200,
                        "body" => $respond['body']
                    ];
        } catch(Exception $e) {
            return  [
                        "status" => 500,
                        "body" => [
                            "error" => $e->getMessage()
                        ]
                    ];
        }

        // $email = $email !== null ? security_utils::sanitize_input($email) : null;
        // $name = $name !== null ? security_utils::sanitize_input($name) : null;
        // $hashed = $password !== null ? security_utils::hash_password($password) : null;

        // try {
        //     $updated = $this->admin_DAO->update_user_account($user_id, $email, $hashed, $name, $role);
        //     return ['status' => $updated ? 200 : 500, 'body' => ['message' => $updated ? 'User updated successfully' : 'Failed to update user']];
        // } catch (Exception $e) {
        //     error_log('admin_edit edit error: ' . $e->getMessage());
        //     return ['status' => 500, 'body' => ['error' => 'Server error while updating user']];
        // }
    }

}
?>
