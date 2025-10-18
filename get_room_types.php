<?php
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    http_response_code(401);
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$active = $conn->query("SELECT room_type_id, type_name, description, base_price, max_occupancy FROM room_types WHERE is_archived = 0 ORDER BY type_name");
$archived = $conn->query("SELECT room_type_id, type_name, description, base_price, max_occupancy FROM room_types WHERE is_archived = 1 ORDER BY type_name");

$activeData = [];
$archivedData = [];

while ($row = $active->fetch_assoc()) {
    $activeData[] = $row;
}

while ($row = $archived->fetch_assoc()) {
    $archivedData[] = $row;
}

header('Content-Type: application/json');
echo json_encode(['active' => $activeData, 'archived' => $archivedData]);

$db->close();
?>