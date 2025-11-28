<?php 
// This act as a main entry point for all component in the service
require_once __DIR__ . '/../../utils/security_utils.php';
require_once __DIR__ . '/../Data Access Object/student_DAO.php';
require_once __DIR__ . '/../Data Access Object/user_DAO.php';
require_once __DIR__ . '/../Data Access Object/admin_DAO.php';
require_once __DIR__ . '/../Data Access Object/course_DAO.php';
require_once __DIR__ . '/authentication.php';
require_once __DIR__ . '/user_register.php';
require_once __DIR__ . '/jwt_service.php';
require_once __DIR__ . '/../Course Management/course_builder.php';
require_once __DIR__ . '/../User Management/admin_create.php';
require_once __DIR__ . '/../User Management/admin_delete.php';
require_once __DIR__ . '/../User Management/admin_edit.php';
require_once __DIR__ . '/../../../Config/jwt_key.php';
class security_service {
    private $student_DAO;
    private $user_DAO;
    private $admin_DAO;
    private $course_DAO;
    private $jwt_service;
    private $authentication;
    private $user_register;
    private $admin_create;
    private $admin_edit;
    private $admin_delete;
    private $course_builder;
    // private $create_course;
    // private $edit_course;
    // private $get_courses_by_teacher;
    // private $delete_course;
    // private $add_unit;
    // private $edit_unit;
    // private $delete_unit;
    // private $add_content;
    // private $edit_content;
    // private $delete_content;

    public function __construct() {
        $this->student_DAO = new student_DAO();
        $this->user_DAO = new user_DAO();
        $this->admin_DAO = new admin_DAO();
        $this->course_DAO = new course_DAO();
        $this->jwt_service = new jwt_service(jwt_key: JWT_KEY);
        $this->authentication = new authentication($this->user_DAO, $this->jwt_service);
        $this->user_register = new user_register($this->user_DAO);
        $this->admin_create = new admin_create($this->admin_DAO);
        $this->admin_delete = new admin_delete($this->admin_DAO);
        $this->admin_edit = new admin_edit($this->admin_DAO);
        $this->course_builder = new course_builder($this->course_DAO);

    }

    public function user_login($email, $password) {
        return $this->authentication->user_login($email, $password);
    }

    public function user_register($email, $password, $role) {
        return $this->user_register->user_register($email, $password, $role);
    }

    public function admin_create($email, $password, $name, $role) {
        return $this->admin_create->create($email, $password, $name, $role);
    }

    public function admin_delete($user_id) {
        return $this->admin_delete->delete($user_id);
    }

    public function admin_edit($user_id, $email, $password, $name, $role) {
        return $this->admin_edit->edit($user_id, $email, $password, $name, $role);
    }

    public function create_course($title, $description, $password, $created_by) {
        return $this->course_builder->create_course($title,$description,$password,$created_by);
    }
    
    public function edit_course($course_id, $title, $description, $password) {
        return $this->course_builder->edit_course($course_id, $title, $description, $password);
    }

    public function get_courses_by_teacher($teacher_id) {
        return $this->course_builder->get_courses_by_teacher($teacher_id);
    }

    public function delete_course($course_id) {
        return $this->course_builder->delete_course($course_id);
    }

    public function add_unit($course_id, $title, $description, $order_index) {
        return $this->course_builder->add_unit($course_id, $title, $description, $order_index);
    }

    public function edit_unit($unit_id, $title, $description, $order_index) {
        return $this->course_builder->edit_unit($unit_id, $title, $description, $order_index);
    }

    public function delete_unit($unit_id) {
        return $this->course_builder->delete_unit($unit_id);
    }

    public function add_content($unit_id, $title, $content_type, $body, $attachments) {
        return $this->course_builder->add_content($unit_id, $title, $content_type, $body, $attachments);
    }

    public function edit_content($content_id, $title, $content_type, $body, $attachments) {
        return $this->course_builder->edit_content($content_id, $title, $content_type, $body, $attachments);
    }

    public function delete_content($content_id) {
        return $this->course_builder->delete_content($content_id);
    }

}
?>