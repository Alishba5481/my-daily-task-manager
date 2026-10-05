<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

if(isset($data->email) && isset($data->password)) {
    $email = $data->email;
    $password = $data->password;

    $stmt = $conn->prepare("SELECT * FROM users_register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])) {
            
            // Save login entry in the logins table (separate table requirement)
            $log_stmt = $conn->prepare("INSERT INTO user_logins (email, status) VALUES (?, 'Success')");
            $log_stmt->bind_param("s", $email);
            $log_stmt->execute();

            echo json_encode(["status" => "success", "message" => "Login Successful", "user" => $user['name'], "user_id" => $user['id']]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid Password"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "User not found"]);
    }
}
?>