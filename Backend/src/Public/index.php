<?php 
// This file is for routing api endpoints

require_once __DIR__ . '/../../vendor/autoload.php';

header('Content-Type: application/json');

require_once __DIR__ . '/../Controller/auth_controller.php';
require_once __DIR__ . '/../Controller/register_controller.php';
require_once __DIR__ . '/../Controller/admin_controller.php';
require_once __DIR__ . '/../Services/Security/security_service.php';
require_once __DIR__ . '/../Services/Security/authorization_middleware.php';
require_once __DIR__ . '/../Services/Security/jwt_service.php';
require_once __DIR__ . '/../../Config/jwt_key.php';

$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

$jwt_service = new jwt_service(jwt_key: JWT_KEY);
$authorization_middleware = new authorization_middleware($jwt_service);

$path = parse_url($request_uri, PHP_URL_PATH);
try {
    switch ($request_method) { 
        case 'POST':
            $segments = explode('/', trim($path, '/'));
            switch($segments[1]) {
                case 'student_register':
                    $register_controller = new register_controller(new security_service());
                    $request_data = json_decode(file_get_contents("php://input"), true);
                    $respond = $register_controller->student_register($request_data);
                    http_response_code($respond['status']);
                    echo json_encode($respond['body']);
                    break;
                case 'teacher_register':
                    $register_controller = new register_controller(new security_service());
                    $request_data = json_decode(file_get_contents("php://input"), true);
                    $respond = $register_controller->teacher_register($request_data);
                    http_response_code(response_code: $respond['status']);
                    echo json_encode($respond['body']);
                    break;
                case 'user_login':
                    $auth_controller = new auth_controller(new security_service());
                    $request_data = json_decode(file_get_contents("php://input"), true);
                    $respond = $auth_controller->user_login($request_data);
                    http_response_code($respond['status']);
                    echo json_encode($respond['body']);
                    break;
                  
                 //newly add section
                case 'admin_create':
                    $admin_controller = new admin_controller(new security_service());
                    $request_data = json_decode(file_get_contents("php://input"), true);
                    $respond = $admin_controller->create($request_data);
                    http_response_code($respond['status']);
                    echo json_encode($respond['body']);
                    break;

                case 'admin_delete':
                    $admin_controller = new admin_controller(new security_service());
                    $request_data = json_decode(file_get_contents("php://input"), true);
                    $respond = $admin_controller->delete($request_data);
                    http_response_code($respond['status']);
                    echo json_encode($respond['body']);
                    break;

                case 'admin_edit':
                    $admin_controller = new admin_controller(new security_service());
                    $request_data = json_decode(file_get_contents("php://input"), true);
                    $respond = $admin_controller->edit($request_data);
                    http_response_code($respond['status']);
                    echo json_encode($respond['body']);
                    break;
                 //newly added section
                default:
                    http_response_code(404);
                    break;
            };
            break;
        case 'GET':
            $segments = explode('/', trim($path, '/'));
            switch($segments[1]) {
                case 'teacher_profile':
                    $authorization_middleware->authorize_request($segments[1]);
                    http_response_code(200);
                    echo json_encode(['message' => 'Reached GET teacher_profile route', 'uri' => $request_uri]);
                    break;
                default:
                    http_response_code(404);
                    break;
            }
            break;
        default:
            http_response_code(403);
            echo json_encode(['error' => 'Method Not Allowed']);
            break;
    } 
} catch(Throwable $e) {
    error_log("Unhandled Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'An unexpected server error occurred.']);
}
?>