<?php
include 'db.php';
header('Content-Type: application/json');

// Get user_id from query parameter
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if($user_id > 0) {
    $stmt = $conn->prepare("SELECT id, title, description, created_at, updated_at FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $tasks = [];
    while($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }

    echo json_encode(["status" => "success", "tasks" => $tasks, "count" => count($tasks)]);
} else {
    echo json_encode(["status" => "error", "message" => "Valid User ID is required"]);
}
?>
