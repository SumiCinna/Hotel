<?php
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    http_response_code(401);
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("CALL sp_get_room_types()");
$stmt->execute();
$result = $stmt->get_result();

$activeData = [];
$archivedData = [];

while ($row = $result->fetch_assoc()) {
    if ($row['is_archived'] == 0) {
        unset($row['is_archived']);
        $activeData[] = $row;
    } else {
        unset($row['is_archived']);
        $archivedData[] = $row;
    }
}

$stmt->close();
$db->close();

header('Content-Type: application/json');
echo json_encode(['active' => $activeData, 'archived' => $archivedData]);
?>