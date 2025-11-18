<?php 
require_once __DIR__ . '/../../utils/security_utils.php';

class user_register {
    private $student_DAO;
    private $user_DAO;
    public function __construct($student_DAO, $user_DAO) {
        $this->student_DAO = $student_DAO;
        $this->user_DAO = $user_DAO;
    }

    public function student_register($email, $password) : array {
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
            $is_student_created = $this->student_DAO->create_student_account($email, $password);
            $return_message = $is_student_created? "Register successfully!" : "Error in creating an account! Try again later or contact our support team for more details!";
            return  [
                        "success" => $is_student_created, 
                        "body" => [
                            "message" => $return_message
                        ]
                    ];
        }catch(Exception $e) {
            error_log('Student register error: ' . $e->getMessage());
            throw new Exception('Student register error!');
        }
        
    }
}
?>