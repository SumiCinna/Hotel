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

$stmt = $conn->prepare("SELECT res.reservation_id, res.room_id, res.status FROM reservations res WHERE res.reservation_id = ?");
$stmt->bind_param("i", $reservation_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Reservation not found!";
    header('Location: staff_dashboard.php');
    exit();
}

$reservation = $result->fetch_assoc();

if ($reservation['status'] !== 'confirmed') {
    $_SESSION['error'] = "Only confirmed reservations can be checked in!";
    header('Location: view_reservation.php?id=' . $reservation_id);
    exit();
}

$update_reservation = $conn->prepare("UPDATE reservations SET status = 'checked_in' WHERE reservation_id = ?");
$update_reservation->bind_param("i", $reservation_id);
$update_reservation->execute();

$update_room = $conn->prepare("UPDATE rooms SET status = 'occupied' WHERE room_id = ?");
$update_room->bind_param("i", $reservation['room_id']);
$update_room->execute();

$db->close();

$_SESSION['success'] = "Guest checked in successfully!";
header('Location: view_reservation.php?id=' . $reservation_id);
exit();
?>