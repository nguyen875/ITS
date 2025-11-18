<?php 
// This act as a main entry point for all component in the service
require_once __DIR__ . '/../../utils/security_utils.php';
require_once __DIR__ . '/../Data Access Object/student_DAO.php';
require_once __DIR__ . '/../Data Access Object/user_DAO.php';
require_once __DIR__ . '/authentication.php';
require_once __DIR__ . '/user_register.php';
require_once __DIR__ . '/jwt_service.php';
require_once __DIR__ . '/../../../Config/jwt_key.php';
class security_service {
    private $student_DAO;
    private $user_DAO;
    private $jwt_service;
    private $authentication;
    private $user_register;
    public function __construct() {
        $this->student_DAO = new student_DAO();
        $this->user_DAO = new user_DAO();
        $this->jwt_service = new jwt_service(jwt_key: JWT_KEY);
        $this->authentication = new authentication($this->user_DAO, $this->jwt_service);
        $this->user_register = new user_register($this->student_DAO, $this->user_DAO);
    }

    public function user_login($email, $password) {
        return $this->authentication->user_login($email, $password);
    }

    public function student_register($email, $password) {
        return $this->user_register->student_register($email, $password);
    }

}
?>