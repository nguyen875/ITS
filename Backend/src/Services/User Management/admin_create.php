<?php
class admin_create {
    private $admin_DAO;

    public function __construct($admin_DAO) {
        $this->admin_DAO = $admin_DAO;
    }

  
    public function create($email, $password, $name, $role): array {
       
        $email = security_utils::sanitize_input($email);
        $name = $name !== null ? security_utils::sanitize_input($name) : null;
        $hashed = security_utils::hash_password($password);

        $duplicate_account = $this->admin_DAO->retrieve_user_account_by_email($email);
        if($duplicate_account) {
            return  [
                        "success" => false, 
                        "body" => [
                            "message" => "This email has been registered!"
                        ]
                    ];
        }

        try {
            $created = $this->admin_DAO->create_user_account($email, $hashed, $name, $role);
            return ['success' => $created, 'body' => ['message' => $created ? 'User created successfully' : 'Failed to create user']];
        } catch (Exception $e) {
            error_log('admin_create create error: ' . $e->getMessage());
            throw new Exception ('Server error while creating user');
        }
    }
}
?>
