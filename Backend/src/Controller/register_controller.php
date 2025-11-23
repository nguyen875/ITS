<?php 
class register_controller {
    private $security_service;
    public function __construct($security_service) {
        $this->security_service = $security_service;
    }

    public function student_register($request_data): array {
        $email = $request_data['email'] ?? '';
        $password = $request_data['password'] ?? '';
        $role = 'Student';
        if(!security_utils::validate_email($email) || !security_utils::validate_password($password)) {
            return  [
                        "status" => 400,
                        "body" => [
                            "message" => "Invalid email or password format! Try again!"
                        ]
                    ];
        }
        try {
            $respond = $this->security_service->user_register($email, $password, $role);
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
    }


    public function teacher_register($request_data): array {
        $email = $request_data['email'] ?? '';
        $password = $request_data['password'] ?? '';
        $role = 'Teacher';
        if(!security_utils::validate_email($email) || !security_utils::validate_password($password)) {
            return  [
                        "status" => 400,
                        "body" => [
                            "message" => "Invalid email or password format! Try again!"
                        ]
                    ];
        }
        try {
            $respond = $this->security_service->user_register($email, $password, $role);
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
    }
}
?>