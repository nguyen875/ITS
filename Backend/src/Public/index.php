<?php 
// This file is for routing api endpoints
header('Content-Type: application/json');

require_once __DIR__ . '/../Controller/auth_controller.php';
require_once __DIR__ . '/../Controller/register_controller.php';
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];
$path = strtok($request_uri, '?');


echo $request_method;
echo $request_uri;
try {
    switch ($request_method) { 
        case 'POST':
        case 'GET':
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