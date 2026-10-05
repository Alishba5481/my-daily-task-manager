<?php
include 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if(isset($data->user_id) && isset($data->title)) {
    $user_id = intval($data->user_id);
    $title = $data->title;
    $description = isset($data->description) ? $data->description : '';

    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $description);

    if($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Task added successfully", "task_id" => $stmt->insert_id]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add task"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User ID and Task title are required"]);
}
?>
