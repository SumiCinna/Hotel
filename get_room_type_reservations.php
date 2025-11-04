<?php
require_once 'config.php';
header('Content-Type: application/json');

$room_type_id = isset($_GET['room_type_id']) ? (int)$_GET['room_type_id'] : 0;

if ($room_type_id <= 0) {
    echo json_encode(['reservations' => []]);
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("CALL sp_get_room_type_reservations(?)");
$stmt->bind_param("i", $room_type_id);
$stmt->execute();
$result = $stmt->get_result();

$reservations = [];
while ($row = $result->fetch_assoc()) {
    $reservations[] = $row;
}

$stmt->close();
$db->close();

echo json_encode(['reservations' => $reservations]);
?>