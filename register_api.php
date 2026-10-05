<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

if(isset($data->name) && isset($data->email) && isset($data->password)) {
    $name = $data->name;
    $email = $data->email;
    $password = password_hash($data->password, PASSWORD_DEFAULT); // Password encryption is required

    $stmt = $conn->prepare("INSERT INTO users_register (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Registration Successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Email already exists"]);
    }
}
?>