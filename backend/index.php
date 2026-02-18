<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// Simple router
// e.g. /supervisor/create -> ['', 'supervisor', 'create']
// e.g. /status -> ['', 'status']

$resource = isset($uri[1]) ? $uri[1] : null;
$action = isset($uri[2]) ? $uri[2] : null;

// Fallback if running in a subdirectory and index 1 is empty or 'backend'
// This is a simple heuristic; a robust router would be better but keeping it simple for now.
if ($resource === 'backend' || $resource === '') {
    $resource = isset($uri[2]) ? $uri[2] : null;
    $action = isset($uri[3]) ? $uri[3] : null;
}

if ($resource) {
    if ($resource === 'supervisor') {
        include_once 'controllers/SupervisorController.php';
        $controller = new SupervisorController();
        if ($action === 'create')
            $controller->create();
        elseif ($action === 'list')
            $controller->getAll();
        else {
            // Default if no action provided? Or 404
            header("HTTP/1.1 404 Not Found");
            echo json_encode(["message" => "Action not found"]);
        }
    }
    elseif ($resource === 'contract') {
        include_once 'controllers/ContractController.php';
        $controller = new ContractController();
        if ($action === 'create')
            $controller->create();
        elseif ($action === 'expiring')
            $controller->checkExpiring();
        elseif ($action === 'list')
            $controller->getAll();
    }
    elseif ($resource === 'timesheet') {
        include_once 'controllers/TimeSheetController.php';
        $controller = new TimeSheetController();
        if ($action === 'register')
            $controller->register();
    }
    elseif ($resource === 'student') {
        include_once 'controllers/StudentController.php';
        $controller = new StudentController();
        if ($action === 'create')
            $controller->create();
        elseif ($action === 'list')
            $controller->getAll();
    }
    elseif ($resource === 'institution') {
        include_once 'controllers/InstitutionController.php';
        $controller = new InstitutionController();
        if ($action === 'create')
            $controller->create();
        elseif ($action === 'list')
            $controller->getAll();
    }
    elseif ($resource === 'dashboard') {
        include_once 'controllers/DashboardController.php';
        $controller = new DashboardController();
        if ($action === 'manager')
            $controller->getManagerStats();
    }
    elseif ($resource === 'status') {
        include_once 'controllers/StatusController.php';
        $controller = new StatusController();
        $controller->check();
    }
    else {
        header("HTTP/1.1 404 Not Found");
        echo json_encode(["message" => "Resource not found"]);
    }
}
else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(["message" => "No resource specified"]);
}
?>