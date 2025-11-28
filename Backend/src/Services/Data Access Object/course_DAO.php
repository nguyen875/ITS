<?php
// Backend/src/Services/Data Access Object/course_DAO.php
require_once __DIR__ . '/../Persistence Layer/database_connection.php';

class course_DAO {
    private $conn;

    public function __construct() {
        $this->conn = database_connection::get_instance()->get_connection();
    }

    /* Courses */
    public function create_course(string $title, ?string $description, ?string $password, int $created_by): bool {
        try {
            $this->conn->beginTransaction();
            $sql = 'INSERT INTO course (title, description, password, created_by) VALUES (?, ?, ?, ?)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$title, $description, $password, $created_by]);
            $this->conn->commit();
            return true;
        } catch (\Exception $e) {
            $this->conn->rollBack();
            error_log('course_DAO create_course error: ' . $e->getMessage());
            throw new Exception('Failed to create course');
        }
    }

    public function update_course(int $course_id, ?string $title, ?string $description, ?string $password): bool {
        try {
            $fields = [];
            $values = [];
            if ($title !== null) { $fields[] = 'title = ?'; $values[] = $title; }
            if ($description !== null) { $fields[] = 'description = ?'; $values[] = $description; }
            if ($password !== null) { $fields[] = 'password = ?'; $values[] = $password; }

            if (empty($fields)) return true; // nothing to update

            $values[] = $course_id;
            $sql = 'UPDATE course SET ' . implode(', ', $fields) . ' WHERE course_id = ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($values);
            return true;
        } catch (\Exception $e) {
            error_log('course_DAO update_course error: ' . $e->getMessage());
            throw new Exception('Failed to update course');
        }
    }

    public function get_courses_by_teacher(int $teacher_id): array {
        try {
            $sql = 'SELECT course_id, title, description, created_by, created_at FROM course WHERE created_by = ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$teacher_id]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows === false ? [] : $rows;
        } catch (\Exception $e) {
            error_log('course_DAO get_courses_by_teacher error: ' . $e->getMessage());
            throw new Exception('Failed to retrieve courses');
        }
    }

    public function delete_course(int $course_id): bool {
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE FROM course WHERE course_id = ?');
            $stmt->execute([$course_id]);
            $this->conn->commit();
            return true;
        } catch (\Exception $e) {
            $this->conn->rollBack();
            error_log('course_DAO delete_course error: ' . $e->getMessage());
            throw new Exception('Failed to delete course');
        }
    }

    /* Units */
    public function create_unit(int $course_id, string $title, ?string $description, int $order_index): bool {
        try {
            $sql = 'INSERT INTO unit (course_id, title, description, order_index) VALUES (?, ?, ?, ?)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$course_id, $title, $description, $order_index]);
            return true;
        } catch (\Exception $e) {
            error_log('course_DAO create_unit error: ' . $e->getMessage());
            throw new Exception('Failed to create unit');
        }
    }

    public function update_unit(int $unit_id, ?string $title, ?string $description, ?int $order_index): bool {
        try {
            $fields = [];
            $values = [];
            if ($title !== null) { $fields[] = 'title = ?'; $values[] = $title; }
            if ($description !== null) { $fields[] = 'description = ?'; $values[] = $description; }
            if ($order_index !== null) { $fields[] = 'order_index = ?'; $values[] = $order_index; }

            if (empty($fields)) return true;

            $values[] = $unit_id;
            $sql = 'UPDATE unit SET ' . implode(', ', $fields) . ' WHERE unit_id = ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($values);
            return true;
        } catch (\Exception $e) {
            error_log('course_DAO update_unit error: ' . $e->getMessage());
            throw new Exception('Failed to update unit');
        }
    }

    public function delete_unit(int $unit_id): bool {
        try {
            $stmt = $this->conn->prepare('DELETE FROM unit WHERE unit_id = ?');
            $stmt->execute([$unit_id]);
            return true;
        } catch (\Exception $e) {
            error_log('course_DAO delete_unit error: ' . $e->getMessage());
            throw new Exception('Failed to delete unit');
        }
    }

    /* Content items */
    public function create_content(int $unit_id, string $title, string $content_type, ?string $body, ?string $attachments): bool {
        try {
            $sql = 'INSERT INTO content_item (unit_id, title, content_type, body, attachments) VALUES (?, ?, ?, ?, ?)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$unit_id, $title, $content_type, $body, $attachments]);
            return true;
        } catch (\Exception $e) {
            error_log('course_DAO create_content error: ' . $e->getMessage());
            throw new Exception('Failed to create content');
        }
    }

    public function update_content(int $content_id, ?string $title, ?string $content_type, ?string $body, ?string $attachments): bool {
        try {
            $fields = [];
            $values = [];
            if ($title !== null) { $fields[] = 'title = ?'; $values[] = $title; }
            if ($content_type !== null) { $fields[] = 'content_type = ?'; $values[] = $content_type; }
            if ($body !== null) { $fields[] = 'body = ?'; $values[] = $body; }
            if ($attachments !== null) { $fields[] = 'attachments = ?'; $values[] = $attachments; }

            if (empty($fields)) return true;

            $values[] = $content_id;
            $sql = 'UPDATE content_item SET ' . implode(', ', $fields) . ' WHERE content_id = ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($values);
            return true;
        } catch (\Exception $e) {
            error_log('course_DAO update_content error: ' . $e->getMessage());
            throw new Exception('Failed to update content');
        }
    }

    public function delete_content(int $content_id): bool {
        try {
            $stmt = $this->conn->prepare('DELETE FROM content_item WHERE content_id = ?');
            $stmt->execute([$content_id]);
            return true;
        } catch (\Exception $e) {
            error_log('course_DAO delete_content error: ' . $e->getMessage());
            throw new Exception('Failed to delete content');
        }
    }
}
?>
