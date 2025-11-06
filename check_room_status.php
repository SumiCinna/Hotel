<?php
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    http_response_code(403);
    exit();
}

if (!isset($_GET['room_id'])) {
    http_response_code(400);
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$room_id = intval($_GET['room_id']);
$result = $conn->query("SELECT status FROM rooms WHERE room_id = $room_id");

if ($result && $result->num_rows > 0) {
    $room = $result->fetch_assoc();
    echo json_encode(['status' => $room['status']]);
} else {
    echo json_encode(['status' => 'unknown']);
}

$db->close();
?>