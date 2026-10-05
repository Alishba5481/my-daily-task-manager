<?php
include 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if(isset($data->name) && isset($data->email) && isset($data->password)) {
    $name = $data->name;
    $email = $data->email;
    $password = password_hash($data->password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admins (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Admin Registration Successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Email already exists"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Name, Email, and Password are required"]);
}
?>
