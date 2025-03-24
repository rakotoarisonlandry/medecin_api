<?php
require_once __DIR__ . '/../vendor/autoload.php';

use MedecinApi\Infrastructure\Controllers\MedecinController;
use MedecinApi\Config\Database;

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$controller = new MedecinController();

$method = $_SERVER['REQUEST_METHOD'];
$params = null;

switch ($method) {
    case 'GET':
        $params = $_GET;
        break;
    case 'POST':
    case 'PUT':
    case 'DELETE':
        $params = json_decode(file_get_contents('php://input'), true);
        break;
}

$response = $controller->handleRequest($method, $params);
echo json_encode($response);