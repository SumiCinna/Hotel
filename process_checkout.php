<?php
require_once 'config.php';
date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: staff_dashboard.php');
    exit();
}

$reservation_id = $_GET['id'];
$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("CALL sp_get_basic_reservation_info(?)");
$stmt->bind_param("i", $reservation_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Reservation not found!";
    header('Location: staff_dashboard.php');
    exit();
}

$reservation = $result->fetch_assoc();
$stmt->close(); 

if ($reservation['status'] !== 'checked_in') {
    $_SESSION['error'] = "Only checked-in guests can be checked out!";
    header('Location: view_reservation.php?id=' . $reservation_id);
    exit();
}


$stmt = $conn->prepare("CALL sp_update_reservation_status(?, ?)");
$new_reservation_status = 'checked_out';
$stmt->bind_param("is", $reservation_id, $new_reservation_status);
$stmt->execute();
$stmt->close();


$stmt = $conn->prepare("CALL sp_update_room_status(?, ?)");
$new_room_status = 'available';
$stmt->bind_param("is", $reservation['room_id'], $new_room_status);
$stmt->execute();
$stmt->close();

$db->close();

$_SESSION['success'] = "Guest checked out successfully!";
header('Location: view_reservation.php?id=' . $reservation_id);
exit();
?>