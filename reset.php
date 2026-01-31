<?php
require_once 'config.php';

$hash = password_hash('password', PASSWORD_BCRYPT);

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("UPDATE users SET password = ? WHERE username IN ('admin1', 'manager1', 'staff1')");
$stmt->bind_param("s", $hash);
$stmt->execute();

echo "Done! Hash used: " . $hash;
$stmt->close();
$db->close();
?>
