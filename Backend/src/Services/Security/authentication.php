<?php 
require_once __DIR__ . '/../Data Access Object/user_DAO.php';
require_once __DIR__ . '/../../utils/security.php';

class authentication {
    private $user_DAO;
    function __construct() {
        $this->student_DAO = new user_DAO();
    }

    public function user_login($email, $password) {
        $hashed_password = security::hash_password($password);

    }
}

?>