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

$stmt = $conn->prepare("
    SELECT DISTINCT r.check_in_date, r.check_out_date, r.status
    FROM reservations r
    JOIN rooms rm ON r.room_id = rm.room_id
    WHERE rm.room_type_id = ? 
    AND r.status IN ('pending', 'confirmed', 'checked_in')
    AND r.check_out_date >= CURDATE()
    ORDER BY r.check_in_date ASC
");
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