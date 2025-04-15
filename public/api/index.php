<?php

require_once __DIR__ . '/../../app/config/config.php';
require_once __DIR__ . '/../../app/route/route.php';
require_once __DIR__ . '/../../app/controllers/UserController.php';


$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$controller = new UserController();
$data = file_get_contents('php://input');

header('Content-Type: application/json');
switch (true) {
    case ($uri === ROUTE_REGISTER && $method === 'POST'):
        echo json_encode($controller->register($data));
        break;

    case ($uri === ROUTE_LOGIN && $method === 'POST'):
        $clientIp = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        echo json_encode($controller->login($data, $clientIp));
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Not found']);
}
