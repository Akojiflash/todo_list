<?php
header('Access-Control-Allow-Origin: *'); // Adjust for production
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Authorization, Content-Type');
require_once "../vendor/autoload.php";
require_once "../config/config.php";

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");
header("content-type: application/json; charset=UTF-8");

use Firebase\JWT\JWT;
use Firebase\JWT\Key;




$jwtHandler = new JwtHandler(new jwt);

$paths = $_SERVER['REQUEST_URI'];

$method = $_SERVER['REQUEST_METHOD'];

$part = explode("/", $paths);



if ($part[2] === "api" && $part[3] === "register") {

    $userModel = new \Models\User($database);

    $userService = new \Services\User($userModel, $jwtHandler);

    $userController = new \Controllers\User($userService);

    $userController->processRequest($method, $part[3]);
    exit();
}else if($part[2] === "api" && $part[3] === "login"){
    $userModel = new \Models\User($database);

    $userService = new \Services\User($userModel, $jwtHandler);

    $userController = new \Controllers\User($userService);

    $userController->processRequest($method, $part[3]);

    exit();

}



http_response_code(404);
echo json_encode(['error' => "Not Found"], true);
exit();
