<?php
include 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if(isset($data->task_id) && isset($data->user_id)) {
    $task_id = intval($data->task_id);
    $user_id = intval($data->user_id);

    // Only allow deleting if the task belongs to this user
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);
    $stmt->execute();

    if($stmt->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Task deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Task not found or you do not have permission to delete it"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Task ID and User ID are required"]);
}
?>
