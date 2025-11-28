<?php
require_once __DIR__ . '/../Persistence Layer/database_connection.php';

class enrollment_DAO {
    private $conn;

    public function __construct() {
        $this->conn = database_connection::get_instance()->get_connection();
    }

 
     public function enroll(int $student_id, int $course_id) {
        try {
            $sql = 'INSERT INTO enrollment (student_id, course_id) VALUES (?, ?)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$student_id, $course_id]);
            return true;
        } catch (\Exception $e) {
            error_log('enrollment_DAO enroll error: ' . $e->getMessage());
            throw new Exception('Failed to enroll');
        }
    }

    /**
     *  helper: retrieve password by courseid (returns string or null)
     */
    public function retrieve_course_by_courseid(int $courseid): ?array {
        try {
            $stmt = $this->conn->prepare(
                'SELECT course_id, title, description, password, created_by FROM course WHERE course_id = ?'
            );
            $stmt->execute([$courseid]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC); // associative array or false
            return $result === false ? null : $result;
        } catch (\Exception $e) {
            error_log('enrollment_DAO retrieve_course_by_courseid error: ' . $e->getMessage());
            throw new Exception('Failed to retrieve course');
        }
    }

    // returns array of associative arrays (each row is a course) or empty array
    public function get_courses_by_student_id(int $student_id): array {
        try {
            $sql = '
                SELECT c.course_id, c.title, c.description, c.password, c.created_by
                FROM course c
                INNER JOIN enrollment e ON c.course_id = e.course_id
                WHERE e.student_id = ?
            ';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$student_id]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows === false ? [] : $rows;
        } catch (\Exception $e) {
            error_log('enrollment_DAO get_courses_by_student_id error: ' . $e->getMessage());
            throw new Exception('Failed to retrieve enrolled courses');
        }
    }


}
?>
