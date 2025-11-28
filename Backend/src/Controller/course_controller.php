<?php
// Backend/src/Controller/course_controller.php
// require_once __DIR__ . '/../../utils/security_utils.php';
// require_once __DIR__ . '/../Services/Course Management/course_builder.php';

class course_controller {
    private $security_service;

    public function __construct($security_service) {
        $this->security_service = $security_service;
    }

    /**
     * Create a new course.
     * Expects $request_data: ['title'=>string, 'description'=>string|null, 'password'=>string|null, 'created_by'=>int]
     * Returns: ['status'=>int, 'body'=>array]
     */
    public function create_course(array $request_data): array {
        $title = $request_data['title'] ?? '';
        $description = $request_data['description'] ?? null;
        $password = $request_data['password'] ?? null;
        $created_by = isset($request_data['created_by']) ? (int)$request_data['created_by'] : 0;

        if (empty($title) || $created_by <= 0) {
            return ['status' => 400, 'body' => ['message' => 'title and created_by (teacher id) are required']];
        }

        try {
            $respond = $this->security_service->create_course($title, $description, $password, $created_by);
            return [
                "status" => $respond['status'] ?? 200,
                "body" => $respond['body']
            ];
        } catch(Exception $e) {
            return [
                "status" => 500,
                "body" => ["error" => $e->getMessage()]
            ];
        }
    }

    /**
     * Edit an existing course.
     * Expects $request_data: ['course_id'=>int, 'title'=>string|null, 'description'=>string|null, 'password'=>string|null]
     */
    public function edit_course(array $request_data): array {
        $course_id = isset($request_data['course_id']) ? (int)$request_data['course_id'] : 0;
        if ($course_id <= 0) {
            return ['status' => 400, 'body' => ['message' => 'course_id is required']];
        }

        $title = $request_data['title'] ?? null;
        $description = $request_data['description'] ?? null;
        $password = $request_data['password'] ?? null;

        try {
            $respond = $this->security_service->edit_course($course_id, $title, $description, $password);
            return [
                "status" => $respond['status'] ?? 200,
                "body" => $respond['body']
            ];
        } catch(Exception $e) {
            return [
                "status" => 500,
                "body" => ["error" => $e->getMessage()]
            ];
        }
    }

    /**
     * Get all courses created by a teacher.
     * Expects $request_data: ['teacher_id'=>int]
     */
    public function get_courses_by_teacher(array $request_data): array {
        $teacher_id = isset($request_data['teacher_id']) ? (int)$request_data['teacher_id'] : 0;
        if ($teacher_id <= 0) {
            return ['status' => 400, 'body' => ['message' => 'teacher_id is required']];
        }

        try {
            $respond = $this->security_service->get_courses_by_teacher($teacher_id);
            return [
                "status" => $respond['status'] ?? 200,
                "body" => $respond['body']
            ];
        } catch(Exception $e) {
            return [
                "status" => 500,
                "body" => ["error" => $e->getMessage()]
            ];
        }
    }

    /**
     * Delete a course.
     * Expects $request_data: ['course_id'=>int]
     */
    public function delete_course(array $request_data): array {
        $course_id = isset($request_data['course_id']) ? (int)$request_data['course_id'] : 0;
        if ($course_id <= 0) {
            return ['status' => 400, 'body' => ['message' => 'course_id is required']];
        }

        try {
            $respond = $this->security_service->delete_course($course_id);
            return [
                "status" => $respond['status'] ?? 200,
                "body" => $respond['body']
            ];
        } catch(Exception $e) {
            return [
                "status" => 500,
                "body" => ["error" => $e->getMessage()]
            ];
        }
    }

    /**
     * Add unit to a course.
     * Expects $request_data: ['course_id'=>int, 'title'=>string, 'description'=>string|null, 'order_index'=>int|null]
     */
    public function add_unit(array $request_data): array {
        $course_id = isset($request_data['course_id']) ? (int)$request_data['course_id'] : 0;
        $title = $request_data['title'] ?? '';
        $description = $request_data['description'] ?? null;
        $order_index = isset($request_data['order_index']) ? (int)$request_data['order_index'] : 1;

        if ($course_id <= 0 || empty($title)) {
            return ['status' => 400, 'body' => ['message' => 'course_id and title are required']];
        }

        if ($order_index <= 0) {
            return ['status' => 400, 'body' => ['message' => 'invalid input']];
        }

        try {
            $respond = $this->security_service->add_unit($course_id, $title, $description, $order_index);
            return [
                "status" => $respond['status'] ?? 200,
                "body" => $respond['body']
            ];
        } catch(Exception $e) {
            return [
                "status" => 500,
                "body" => ["error" => $e->getMessage()]
            ];
        }
    }

    /**
     * Edit a unit.
     * Expects $request_data: ['unit_id'=>int, 'title'=>string|null, 'description'=>string|null, 'order_index'=>int|null]
     */
    public function edit_unit(array $request_data): array {
        $unit_id = isset($request_data['unit_id']) ? (int)$request_data['unit_id'] : 0;
        if ($unit_id <= 0) {
            return ['status' => 400, 'body' => ['message' => 'unit_id is required']];
        }

        $title = $request_data['title'] ?? null;
        $description = $request_data['description'] ?? null;
        $order_index = isset($request_data['order_index']) ? (int)$request_data['order_index'] : null;

        if ($order_index <= 0) {
            return ['status' => 400, 'body' => ['message' => 'invalid input']];
        }

        try {
            $respond = $this->security_service->edit_unit($unit_id, $title, $description, $order_index);
            return [
                "status" => $respond['status'] ?? 200,
                "body" => $respond['body']
            ];
        } catch(Exception $e) {
            return [
                "status" => 500,
                "body" => ["error" => $e->getMessage()]
            ];
        }
    }

    /**
     * Delete a unit.
     * Expects $request_data: ['unit_id'=>int]
     */
    public function delete_unit(array $request_data): array {
        $unit_id = isset($request_data['unit_id']) ? (int)$request_data['unit_id'] : 0;
        if ($unit_id <= 0) {
            return ['status' => 400, 'body' => ['message' => 'unit_id is required']];
        }

        try {
            $respond = $this->security_service->delete_unit($unit_id);
            return [
                "status" => $respond['status'] ?? 200,
                "body" => $respond['body']
            ];
        } catch(Exception $e) {
            return [
                "status" => 500,
                "body" => ["error" => $e->getMessage()]
            ];
        }
    }

    /**
     * Add content to a unit.
     * Expects $request_data: ['unit_id'=>int, 'title'=>string, 'content_type'=>string, 'body'=>string|null, 'attachments'=>string|null]
     */
    public function add_content(array $request_data): array {
        $unit_id = isset($request_data['unit_id']) ? (int)$request_data['unit_id'] : 0;
        $title = $request_data['title'] ?? '';
        $content_type = $request_data['content_type'] ?? null;
        $body = $request_data['body'] ?? null;
        $attachments = $request_data['attachments'] ?? null;

        if ($unit_id <= 0 || empty($title) || $content_type === null) {
            return ['status' => 400, 'body' => ['message' => 'unit_id, title and content_type are required']];
        }

        try {
            $respond = $this->security_service->add_content($unit_id, $title, $content_type, $body, $attachments);
            return [
                "status" => $respond['status'] ?? 200,
                "body" => $respond['body']
            ];
        } catch(Exception $e) {
            return [
                "status" => 500,
                "body" => ["error" => $e->getMessage()]
            ];
        }
    }

    /**
     * Edit content.
     * Expects $request_data: ['content_id'=>int, 'title'=>string|null, 'content_type'=>string|null, 'body'=>string|null, 'attachments'=>string|null]
     */
    public function edit_content(array $request_data): array {
        $content_id = isset($request_data['content_id']) ? (int)$request_data['content_id'] : 0;
        if ($content_id <= 0) {
            return ['status' => 400, 'body' => ['message' => 'content_id is required']];
        }

        $title = $request_data['title'] ?? null;
        $content_type = $request_data['content_type'] ?? null;
        $body = $request_data['body'] ?? null;
        $attachments = $request_data['attachments'] ?? null;

        try {
            $respond = $this->security_service->edit_content($content_id, $title, $content_type, $body, $attachments);
            return [
                "status" => $respond['status'] ?? 200,
                "body" => $respond['body']
            ];
        } catch(Exception $e) {
            return [
                "status" => 500,
                "body" => ["error" => $e->getMessage()]
            ];
        }
    }

    /**
     * Delete content.
     * Expects $request_data: ['content_id'=>int]
     */
    public function delete_content(array $request_data): array {
        $content_id = isset($request_data['content_id']) ? (int)$request_data['content_id'] : 0;
        if ($content_id <= 0) {
            return ['status' => 400, 'body' => ['message' => 'content_id is required']];
        }

        try {
            $respond = $this->security_service->delete_content($content_id);
            return [
                "status" => $respond['status'] ?? 200,
                "body" => $respond['body']
            ];
        } catch(Exception $e) {
            return [
                "status" => 500,
                "body" => ["error" => $e->getMessage()]
            ];
        }
    }

    /**
     * enroll
     * Expects $request_data: ['student_id'=>int, 'course_id'=>int]
     */
    public function enroll(array $request_data): array {
        $student_id = isset($request_data['user_id']) ? (int)$request_data['user_id'] : 0;
        $course_id = isset($request_data['course_id']) ? (int)$request_data['course_id'] : 0;
        $password = $request_data['password'] ?? null;

        if ($student_id <= 0) {
            return ['status' => 400, 'body' => ['message' => 'invalid or missing student id']];
        }

        if ($course_id <= 0) {
            return ['status' => 400, 'body' => ['message' => 'invalid or missing course id']];
        }

        try {
            $respond = $this->security_service->enroll($student_id, $course_id, $password);
            return [
                "status" => $respond['status'] ?? 200,
                "body" => $respond['body']
            ];
        } catch(Exception $e) {
            return [
                "status" => 500,
                "body" => ["error" => $e->getMessage()]
            ];
        }
    }

    public function get_enrolled_courses(array $request_data): array {
        $student_id = isset($request_data['user_id']) ? (int)$request_data['user_id'] : 0;

        if ($student_id <= 0) {
            return ['status' => 400, 'body' => ['message' => 'invalid or missing student id']];
        }

        try {
            $respond = $this->security_service->get_enrolled_courses($student_id, $course_id, $password);
            return [
                "status" => $respond['status'] ?? 200,
                "body" => $respond['body']
            ];
        } catch(Exception $e) {
            return [
                "status" => 500,
                "body" => ["error" => $e->getMessage()]
            ];
        }
    }

}
?>
