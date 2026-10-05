<?php
include 'db.php';
header('Content-Type: application/json');

// Get admin_id from query parameter to verify admin access
$admin_id = isset($_GET['admin_id']) ? intval($_GET['admin_id']) : 0;

if($admin_id <= 0) {
    echo json_encode(["status" => "error", "message" => "Admin authentication required"]);
    exit;
}

// Verify admin exists
$admin_check = $conn->prepare("SELECT id FROM admins WHERE id = ?");
$admin_check->bind_param("i", $admin_id);
$admin_check->execute();
if($admin_check->get_result()->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Invalid admin"]);
    exit;
}

// Get all users with their task counts
$users_query = "
    SELECT 
        u.id, 
        u.name, 
        u.email, 
        COUNT(t.id) AS total_tasks,
        MAX(t.created_at) AS last_task_date
    FROM users_register u
    LEFT JOIN tasks t ON u.id = t.user_id
    GROUP BY u.id, u.name, u.email
    ORDER BY u.id DESC
";
$users_result = $conn->query($users_query);

$users = [];
while($row = $users_result->fetch_assoc()) {
    $users[] = $row;
}

// Get all tasks with user info
$tasks_query = "
    SELECT 
        t.id AS task_id, 
        t.title, 
        t.description, 
        t.created_at, 
        t.updated_at,
        u.id AS user_id,
        u.name AS user_name, 
        u.email AS user_email
    FROM tasks t
    JOIN users_register u ON t.user_id = u.id
    ORDER BY t.created_at DESC
";
$tasks_result = $conn->query($tasks_query);

$tasks = [];
while($row = $tasks_result->fetch_assoc()) {
    $tasks[] = $row;
}

// Get summary stats
$total_users = count($users);
$total_tasks = count($tasks);

echo json_encode([
    "status" => "success",
    "total_users" => $total_users,
    "total_tasks" => $total_tasks,
    "users" => $users,
    "tasks" => $tasks
]);
?>
