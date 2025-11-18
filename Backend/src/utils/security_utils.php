<?php
// this class is for utility functions for security services
class security_utils {
    public static function sanitize_input($data) {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function hash_password($raw_password) {
        $salt1 = "%$32*^";
        $salt2 = "fwfb)gh#$(";
        $hash_password = hash('sha512', "$salt1$raw_password$salt2");
        return $hash_password;
    }

    public static function validate_email($email) : bool {
        $email_regex = "/^[-!#$%&'*+\/0-9=?A-Z^_a-z{|}~](\.?[-!#$%&'*+\/0-9=?A-Z^_a-z`{|}~])*@[a-zA-Z0-9](-*\.?[a-zA-Z0-9])*\.[a-zA-Z](-?[a-zA-Z0-9])+$/";
        return preg_match($email_regex, $email);
    }

    public static function validate_password($raw_password) : bool {
        $password_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,100}$/";
        return preg_match($password_regex, $raw_password);
    }
}

?>