<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$host = "localhost";
$user = "root";
$pass = "YOUR_MYSQL_PASSWORD";
$dbname = "task_manager_db";
$port = 3306;

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database Connection Failed"]));
}
?>