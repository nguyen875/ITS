<?php 
require_once __DIR__ . '/../../utils/security_utils.php';

class user_register {
    private $user_DAO;
    public function __construct($user_DAO) {
        $this->user_DAO = $user_DAO;
    }

    public function user_register($email, $password, $role) : array {
        try {
            // 1: Sanitize input and hash password
            $email = security_utils::sanitize_input($email);
            $password = security_utils::hash_password($password);

            // 2: Check duplicate account  
            $duplicate_account = $this->user_DAO->retrieve_user_account_by_email($email);
            if($duplicate_account) {
                return  [
                            "success" => false, 
                            "body" => [
                                "message" => "This email has been registered!"
                            ]
                        ];
            }
            // 3: Create new account and save
            $is_account_created = $this->user_DAO->create_user_account($email, $password, $role);
            $return_message = $is_account_created? "Register successfully!" : "Error in creating an account! Try again later or contact our support team for more details!";
            return  [
                        "success" => $is_account_created, 
                        "body" => [
                            "message" => $return_message
                        ]
                    ];
        }catch(Exception $e) {
            error_log('User register error: ' . $e->getMessage());
            throw new Exception('User register error!');
        }
        
    }
}
?>