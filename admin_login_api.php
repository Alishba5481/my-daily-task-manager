<?php
include 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if(isset($data->email) && isset($data->password)) {
    $email = $data->email;
    $password = $data->password;

    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if(password_verify($password, $admin['password'])) {
            echo json_encode([
                "status" => "success", 
                "message" => "Admin Login Successful", 
                "admin" => $admin['name'], 
                "admin_id" => $admin['id']
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid Password"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Admin not found"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Email and Password are required"]);
}
?>
