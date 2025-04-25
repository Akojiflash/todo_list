<?php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();
$hostName = $_ENV['DB_HOSTNAME'];
$userName = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbName = $_ENV['DB_NAME'];


$database = new Database($hostName, $dbName, $userName, $password );

