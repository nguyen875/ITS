<?php
// this class is for utility functions for security services
class security {
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
}

?>