<?php 
require_once __DIR__ . '/../../utils/security_utils.php';

class authentication {
    private $user_DAO;
    private $jwt_service;
    public function __construct($user_DAO, $jwt_service) {
        $this->user_DAO = $user_DAO;
        $this->jwt_service = $jwt_service;
    }

    public function user_login($email, $password) : array {
        try {
            $hashed_password = security_utils::hash_password($password);
            $email = security_utils::sanitize_input($email);
            $user = $this->user_DAO->retrieve_user_account_by_email($email);
            if(!$user || $user['password'] != $hashed_password) {
                $return_message = !$user? "Can not find user! Try again!" : "Incorrect password/email! Try again!";
                return  [
                            "success" => false,
                            "body" => [
                                "message" => $return_message
                            ]
                        ];
            }

            // return jwt token
            $jwt_token = $this->jwt_service->generate_token($user['user_id'], $user['role'], 'its.com', 'its.com');
            return  [
                        "success" => true,
                        "body" => [
                            "message" => 'Login successfully',
                            "jwt_token" => $jwt_token
                        ]
                    ]; 
        }catch(Exception $e) {
            error_log('User login error: ' . $e->getMessage());
            throw new Exception('Can not login!');
        }
    }
}

?>