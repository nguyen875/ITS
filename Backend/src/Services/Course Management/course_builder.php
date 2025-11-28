<?php
// Backend/src/Services/Course Management/course_builder.php

// require_once __DIR__ . '/../Data Access Object/course_DAO.php';
// require_once __DIR__ . '/../../utils/security_utils.php';

class course_builder {
    private $course_DAO;

    public function __construct($course_DAO) {
        $this->course_DAO = $course_DAO;
    }

  
    public function create_course($title,$description,$password,$created_by): array {
        $title = security_utils::sanitize_input($title);
        $description = $description !== null ? security_utils::sanitize_input($description) : null;
        $password = $password !== null ? security_utils::sanitize_input($password) : null;

        try {
            $created = $this->course_DAO->create_course($title, $description, $password, $created_by);
            return ['success' => $created, 'body' => ['message' => $created ? 'Course created successfully' : 'Failed to create course']];
        } catch (Exception $e) {
            error_log('course_builder create_course error: ' . $e->getMessage());
            throw new Exception('Server error while creating course');
        }
    }

    public function edit_course($course_id, $title, $description, $password): array {
        $title = $title !== null ? security_utils::sanitize_input($title) : null;
        $description = $description !== null ? security_utils::sanitize_input($description) : null;
        $password = $password !== null ? security_utils::sanitize_input($password) : null;

        try {
            $updated = $this->course_DAO->update_course($course_id, $title, $description, $password);
            return ['success' => $updated, 'body' => ['message' => $updated ? 'Course updated successfully' : 'Failed to update course']];
        } catch (Exception $e) {
            error_log('course_builder edit_course error: ' . $e->getMessage());
            throw new Exception('Server error while updating course');
        }
    }


    public function get_courses_by_teacher($teacher_id): array {

        try {
            $courses = $this->course_DAO->get_courses_by_teacher($teacher_id);
            return ['success' => true, 'body' => ['courses' => $courses]];
        } catch (Exception $e) {
            error_log('course_builder get_courses_by_teacher error: ' . $e->getMessage());
            throw new Exception('Server error while retrieving courses');
        }
    }


    public function delete_course($course_id): array {

        try {
            $deleted = $this->course_DAO->delete_course($course_id);
            return ['success' => $deleted, 'body' => ['message' => $deleted ? 'Course deleted successfully' : 'Failed to delete course']];
        } catch (Exception $e) {
            error_log('course_builder delete_course error: ' . $e->getMessage());
            throw new Exception('Server error while deleting course');
        }
    }


    public function add_unit($course_id, $title, $description, $order_index = 1): array {
        $course_id = (int)$course_id;
        $title = security_utils::sanitize_input($title);
        $description = $description !== null ? security_utils::sanitize_input($description) : null;


        try {
            $created = $this->course_DAO->create_unit($course_id, $title, $description, $order_index);
            return ['success' => $created, 'body' => ['message' => $created ? 'Unit added successfully' : 'Failed to add unit']];
        } catch (Exception $e) {
            error_log('course_builder add_unit error: ' . $e->getMessage());
            throw new Exception('Server error while adding unit');
        }
    }


    public function edit_unit($unit_id, $title, $description, $order_index): array {
        $title = $title !== null ? security_utils::sanitize_input($title) : null;
        $description = $description !== null ? security_utils::sanitize_input($description) : null;
        $order_index = $order_index !== null ? (int)$order_index : null;


        try {
            $updated = $this->course_DAO->update_unit($unit_id, $title, $description, $order_index);
            return ['success' => $updated, 'body' => ['message' => $updated ? 'Unit updated successfully' : 'Failed to update unit']];
        } catch (Exception $e) {
            error_log('course_builder edit_unit error: ' . $e->getMessage());
            throw new Exception('Server error while updating unit');
        }
    }


    public function delete_unit($unit_id): array {

        try {
            $deleted = $this->course_DAO->delete_unit($unit_id);
            return ['success' => $deleted, 'body' => ['message' => $deleted ? 'Unit deleted successfully' : 'Failed to delete unit']];
        } catch (Exception $e) {
            error_log('course_builder delete_unit error: ' . $e->getMessage());
            throw new Exception('Server error while deleting unit');
        }
    }


    public function add_content($unit_id, $title, $content_type, $body, $attachments): array {
        $title = security_utils::sanitize_input($title);
        $content_type = security_utils::sanitize_input($content_type);
        $body = $body !== null ? security_utils::sanitize_input($body) : null;

        try {
            $created = $this->course_DAO->create_content($unit_id, $title, $content_type, $body, $attachments);
            return ['success' => $created, 'body' => ['message' => $created ? 'Content added successfully' : 'Failed to add content']];
        } catch (Exception $e) {
            error_log('course_builder add_content error: ' . $e->getMessage());
            throw new Exception('Server error while adding content');
        }
    }


    public function edit_content($content_id, $title, $content_type, $body, $attachments): array {
        $title = $title !== null ? security_utils::sanitize_input($title) : null;
        $content_type = $content_type !== null ? security_utils::sanitize_input($content_type) : null;
        $body = $body !== null ? security_utils::sanitize_input($body) : null;


        try {
            $updated = $this->course_DAO->update_content($content_id, $title, $content_type, $body, $attachments);
            return ['success' => $updated, 'body' => ['message' => $updated ? 'Content updated successfully' : 'Failed to update content']];
        } catch (Exception $e) {
            error_log('course_builder edit_content error: ' . $e->getMessage());
            throw new Exception('Server error while updating content');
        }
    }


    public function delete_content($content_id): array {

        try {
            $deleted = $this->course_DAO->delete_content($content_id);
            return ['success' => $deleted, 'body' => ['message' => $deleted ? 'Content deleted successfully' : 'Failed to delete content']];
        } catch (Exception $e) {
            error_log('course_builder delete_content error: ' . $e->getMessage());
            throw new Exception('Server error while deleting content');
        }
    }
}
?>
