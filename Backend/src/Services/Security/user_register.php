<?php 
require_once __DIR__ . '/../Data Access Object/user_DAO.php';
require_once __DIR__ . '/../Data Access Object/student_DAO.php';
require_once __DIR__ . '/../../utils/security.php';

class user_register {
    private $student_DAO;
    private $user_DAO;
    public function __construct() {
        $this->student_DAO = new student_DAO();
        $this->user_DAO = new user_DAO();
    }

    public function student_register($email, $password) {
        // 1: Sanitize input and hash password
        $email = security::sanitize_input($email);
        $password = security::hash_password($password);

        // 2: Check duplicate account  
        $duplicate_account = $this->user_DAO->retrieve_user_account_by_email($email);
        if($duplicate_account) {
            return false;
        }
        // 3: Create new account and save
        $is_student_created = $this->student_DAO->create_student_account($email, $password);
        return $is_student_created;
    }
}
?>