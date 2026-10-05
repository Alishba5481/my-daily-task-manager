<?php
include 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if(isset($data->task_id) && isset($data->user_id) && isset($data->title)) {
    $task_id = intval($data->task_id);
    $user_id = intval($data->user_id);
    $title = $data->title;
    $description = isset($data->description) ? $data->description : '';

    // First check if the task exists and belongs to this user
    $check = $conn->prepare("SELECT id FROM tasks WHERE id = ? AND user_id = ?");
    $check->bind_param("ii", $task_id, $user_id);
    $check->execute();
    $result = $check->get_result();

    if($result->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "Task not found or you do not have permission to edit it"]);
        exit;
    }

    // Task belongs to this user, proceed with update
    $stmt = $conn->prepare("UPDATE tasks SET title = ?, description = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssii", $title, $description, $task_id, $user_id);

    if($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Task updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update task"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Task ID, User ID, and Title are required"]);
}
?>
