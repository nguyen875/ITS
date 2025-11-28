<?php
// Backend/src/Services/Course Management/course_builder.php

// require_once __DIR__ . '/../Data Access Object/course_DAO.php';
// require_once __DIR__ . '/../../utils/security_utils.php';

class enrollment {
    private $enrollment_DAO;

    public function __construct($enrollment_DAO) {
        $this->enrollment_DAO = $enrollment_DAO;
    }

  
    public function enroll($student_id, $course_id, $password): array {
        $course = $this->enrollment_DAO->retrieve_course_by_courseid($course_id);
        $stored_password = $course['password'] ?? null;
        $password= security_utils::hash_password($password);
        if($password !== $stored_password){

            return  [
                            "success" => false, 
                            "body" => [
                                "message" => "Wrong password!"

                            ]
                        ];
        }

        try {
            $enroll = $this->enrollment_DAO->enroll($student_id, $course_id);
            return ['success' => $enroll, 'body' => ['message' => $enroll ? 'enrolled successfully' : 'Failed to enroll']];
        } catch (Exception $e) {
            error_log('enrollment enroll error: ' . $e->getMessage());
            throw new Exception('Server error while enroll');
        }
    }

    public function get_enrolled_courses($student_id): array {

        try {
            $courses = $this->enrollment_DAO->get_courses_by_student_id($student_id);
            return ['success' => true, 'body' => ['message' => $courses ]];
        } catch (Exception $e) {
            error_log('enrollment enroll error: ' . $e->getMessage());
            throw new Exception('Server error while enroll');
        }
    }


}
?>
