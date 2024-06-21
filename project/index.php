<?php
require_once 'controllers/UserController.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uriSegments = explode('/', $uri);

$controller = new UserController();
$id = null;

if (isset($uriSegments[2])) {
    $id = (int)$uriSegments[2];
}

$controller->processRequest($requestMethod, $id);