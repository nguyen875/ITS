<?php 
// This file is for routing api endpoints

require_once __DIR__ . '/../../vendor/autoload.php';

header('Content-Type: application/json');

require_once __DIR__ . '/../Controller/auth_controller.php';
require_once __DIR__ . '/../Controller/register_controller.php';
require_once __DIR__ . '/../Services/Security/security_service.php';
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

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
                default:
                    http_response_code(404);
                    break;
            };
            break;
        case 'GET':
            http_response_code(200);
            echo json_encode(['message' => 'Reached GET route', 'uri' => $request_uri]);
            break;
        default:
            http_response_code(403);
            echo json_encode(['error' => 'Method Not Allowed']);
    } 
} catch(Throwable $e) {
    error_log("Unhandled Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'An unexpected server error occurred.']);
}
?>