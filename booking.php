<?php
require_once 'config.php';
date_default_timezone_set('Asia/Manila');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$error = '';
$success = '';

$result = $conn->query("CALL sp_get_room_types()");
$room_types = $result->fetch_all(MYSQLI_ASSOC);
$result->close();
$conn->next_result();

$room_type_filter = !empty($_GET['room_type_id']) ? $_GET['room_type_id'] : null;

$stmt = $conn->prepare("CALL sp_get_all_rooms_with_availability(?)");
$stmt->bind_param("i", $room_type_filter);
$stmt->execute();
$all_rooms = $stmt->get_result();
$stmt->close();
$conn->next_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book'])) {
    $room_id = $_POST['room_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $special_requests = $_POST['special_requests'];
    
    if (strtotime($check_in) < strtotime(date('Y-m-d'))) {
        $error = 'Check-in date cannot be in the past';
    } elseif (strtotime($check_out) <= strtotime($check_in)) {
        $error = 'Check-out date must be after check-in date';
    } else {
        $stmt = $conn->prepare("CALL sp_check_date_conflict(?, ?, ?)");
        $stmt->bind_param("iss", $room_id, $check_in, $check_out);
        $stmt->execute();
        $result = $stmt->get_result();
        $conflict = $result->fetch_assoc();
        $stmt->close();
        $conn->next_result();
        
        if ($conflict['conflict_count'] > 0) {
            $error = 'The selected dates are already booked for this room. Please choose different dates.';
        } else {
            $stmt = $conn->prepare("CALL sp_create_reservation(?, ?, ?, ?, ?)");
            $stmt->bind_param("iisss", $_SESSION['user_id'], $room_id, $check_in, $check_out, $special_requests);
            
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result && $row = $result->fetch_assoc()) {
                    $reservation_id = $row['reservation_id'];
                    header('Location: payment.php?id=' . $reservation_id);
                    exit();
                }
            } else {
                $error = 'Unable to create reservation. Please try again.';
            }
            
            $stmt->close();
            $conn->next_result();
        }
    }
}

function getReservedDates($conn, $room_id) {
    $stmt = $conn->prepare("CALL sp_get_room_reservations(?)");
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reserved_dates = [];
    
    while ($row = $result->fetch_assoc()) {
        $reserved_dates[] = [
            'check_in' => $row['check_in_date'],
            'check_out' => $row['check_out_date'],
            'status' => $row['status']
        ];
    }
    
    $stmt->close();
    $conn->next_result();
    
    return $reserved_dates;
}

function getDisabledDatesJson($reserved_dates) {
    $disabled_dates = [];
    
    foreach ($reserved_dates as $reservation) {
        if ($reservation['status'] === 'confirmed' || $reservation['status'] === 'checked_in') {
            $start = strtotime($reservation['check_in']);
            $end = strtotime($reservation['check_out']);
            
            for ($date = $start; $date < $end; $date = strtotime('+1 day', $date)) {
                $disabled_dates[] = date('Y-m-d', $date);
            }
        }
    }
    
    return json_encode($disabled_dates);
}

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Room - Hotel Reservation System</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/booking.css"> 
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-hotel"></i>
                <h2 class="playfair">LuxeStay</h2>
            </div>
            <div class="user-info">
                <h3><?php echo htmlspecialchars($_SESSION['full_name']); ?></h3>
                <p><i class="fas fa-user"></i> Customer</p>
            </div>
        </div>
        
        <div class="sidebar-menu">
            <a href="dashboard.php" class="menu-item">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            <a href="booking.php" class="menu-item active">
                <i class="fas fa-calendar-check"></i>
                <span>Book Room</span>
            </a>
            
            <div class="menu-divider"></div>
            
            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager'): ?>
            <a href="admin_dashboard.php" class="menu-item">
                <i class="fas fa-user-shield"></i>
                <span>Admin Panel</span>
            </a>
            <?php endif; ?>
            <a href="index.php" class="menu-item">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="logout.php" class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
    
    <div class="main-content">
        <div class="top-bar">
            <div class="top-bar-left">
                <h1 class="playfair">Book a Room</h1>
                <div class="breadcrumb">
                    <span>Home</span>
                    <i class="fas fa-chevron-right"></i>
                    <span>Booking</span>
                </div>
            </div>
            <div class="top-bar-right">
                <div class="date-time">
                    <p><?php echo date('l'); ?></p>
                    <h4><?php echo date('F d, Y'); ?></h4>
                </div>
            </div>
        </div>
        
        <div class="container">
            <?php if($error): ?>
                <div class="error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <?php if($success): ?>
                <div class="success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>
            
            <div class="filter-section">
                <label for="room_type_filter">
                    <i class="fas fa-filter"></i>
                    Filter by Room Type:
                </label>
                <select id="room_type_filter" onchange="window.location.href='booking.php?room_type_id='+this.value">
                    <option value="">All Types</option>
                    <?php foreach($room_types as $type): ?>
                        <option value="<?php echo $type['room_type_id']; ?>" <?php echo ($room_type_filter == $type['room_type_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($type['type_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <?php if($all_rooms->num_rows > 0): ?>
                <div class="rooms-grid">
                    <?php 
                    $db_temp = new Database();
                    $conn_temp = $db_temp->getConnection();
                    
                    while($room = $all_rooms->fetch_assoc()): 
                        $reserved_dates = getReservedDates($conn_temp, $room['room_id']);
                        $disabled_dates_json = getDisabledDatesJson($reserved_dates);
                        
                        $active_reservations = array_filter($reserved_dates, function($res) {
                            return $res['status'] === 'confirmed' || $res['status'] === 'checked_in';
                        });
                    ?>
                        <div class="room-card">
                            <h3>
                                <i class="fas fa-door-open"></i>
                                Room <?php echo htmlspecialchars($room['room_number']); ?>
                            </h3>
                            <div class="room-info">
                                <p><strong>Type:</strong> <?php echo htmlspecialchars($room['type_name']); ?></p>
                                <p><?php echo htmlspecialchars($room['description']); ?></p>
                            </div>
                            <div class="room-details">
                                <div class="room-detail-item">
                                    <i class="fas fa-users"></i>
                                    <span><?php echo $room['max_occupancy']; ?> Guests</span>
                                </div>
                                <div class="room-detail-item">
                                    <i class="fas fa-building"></i>
                                    <span>Floor <?php echo $room['floor']; ?></span>
                                </div>
                            </div>
                            <div class="room-price">
                                ₱<?php echo number_format($room['base_price'], 2); ?>
                                <span>/night</span>
                            </div>
                            
                            <div class="reserved-dates">
                                <h4><i class="fas fa-calendar-times"></i> Reserved Dates</h4>
                                <?php if(count($active_reservations) > 0): ?>
                                    <ul>
                                        <?php foreach($active_reservations as $reservation): ?>
                                            <li>
                                                <i class="fas fa-circle"></i>
                                                <?php echo date('M d, Y', strtotime($reservation['check_in'])); ?> - <?php echo date('M d, Y', strtotime($reservation['check_out'])); ?>
                                                (<?php echo ucfirst($reservation['status']); ?>)
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="no-reservations">
                                        <i class="fas fa-check-circle"></i>
                                        No upcoming reservations
                                    </p>
                                <?php endif; ?>
                            </div>
                            
                            <form method="POST" class="book-form" id="form_<?php echo $room['room_id']; ?>" onsubmit="return validateDates(<?php echo $room['room_id']; ?>)">
                                <input type="hidden" name="room_id" value="<?php echo $room['room_id']; ?>">
                                <input type="hidden" id="disabled_dates_<?php echo $room['room_id']; ?>" value='<?php echo $disabled_dates_json; ?>'>
                                
                                <div class="form-group">
                                    <label for="check_in_<?php echo $room['room_id']; ?>">
                                        <i class="fas fa-calendar-check"></i>
                                        Check-In Date
                                    </label>
                                    <input type="date" 
                                           id="check_in_<?php echo $room['room_id']; ?>" 
                                           name="check_in" 
                                           required 
                                           min="<?php echo date('Y-m-d'); ?>"
                                           onchange="validateDateRange(<?php echo $room['room_id']; ?>)">
                                    <div class="date-warning" id="check_in_warning_<?php echo $room['room_id']; ?>">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <span>This date is already occupied</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="check_out_<?php echo $room['room_id']; ?>">
                                        <i class="fas fa-calendar-times"></i>
                                        Check-Out Date
                                    </label>
                                    <input type="date" 
                                           id="check_out_<?php echo $room['room_id']; ?>" 
                                           name="check_out" 
                                           required 
                                           min="<?php echo date('Y-m-d'); ?>"
                                           onchange="validateDateRange(<?php echo $room['room_id']; ?>)">
                                    <div class="date-warning" id="check_out_warning_<?php echo $room['room_id']; ?>">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <span>This date is already occupied</span>
                                    </div>
                                </div>
                                
                                <div class="date-warning" id="range_warning_<?php echo $room['room_id']; ?>">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span>Selected date range includes occupied dates</span>
                                </div>
                                
                                <div class="form-group">
                                    <label for="special_requests_<?php echo $room['room_id']; ?>">
                                        <i class="fas fa-comment-dots"></i>
                                        Special Requests (Optional)
                                    </label>
                                    <textarea id="special_requests_<?php echo $room['room_id']; ?>" name="special_requests" placeholder="Any special requirements..."></textarea>
                                </div>
                                <button type="submit" name="book" class="btn" id="book_btn_<?php echo $room['room_id']; ?>" style="width: 100%; justify-content: center;">
                                    <i class="fas fa-calendar-check"></i>
                                    Book Now
                                </button>
                            </form>
                        </div>
                    <?php endwhile; ?>
                    <?php $db_temp->close(); ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-bed"></i>
                    <h3>No Rooms Available</h3>
                    <p>No rooms found matching your criteria</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        function validateDateRange(roomId) {
            const checkInInput = document.getElementById('check_in_' + roomId);
            const checkOutInput = document.getElementById('check_out_' + roomId);
            const disabledDatesInput = document.getElementById('disabled_dates_' + roomId);
            const checkInWarning = document.getElementById('check_in_warning_' + roomId);
            const checkOutWarning = document.getElementById('check_out_warning_' + roomId);
            const rangeWarning = document.getElementById('range_warning_' + roomId);
            const bookBtn = document.getElementById('book_btn_' + roomId);
            
            const checkIn = checkInInput.value;
            const checkOut = checkOutInput.value;
            const disabledDates = JSON.parse(disabledDatesInput.value);
            
            let hasError = false;
            
            checkInWarning.classList.remove('show');
            checkOutWarning.classList.remove('show');
            rangeWarning.classList.remove('show');
            
            if (checkIn && disabledDates.includes(checkIn)) {
                checkInWarning.classList.add('show');
                hasError = true;
            }
            
            if (checkOut && disabledDates.includes(checkOut)) {
                checkOutWarning.classList.add('show');
                hasError = true;
            }
            
            if (checkIn && checkOut && !hasError) {
                const startDate = new Date(checkIn);
                const endDate = new Date(checkOut);
                
                if (endDate <= startDate) {
                    hasError = true;
                } else {
                    for (let d = new Date(startDate); d < endDate; d.setDate(d.getDate() + 1)) {
                        const dateStr = d.toISOString().split('T')[0];
                        if (disabledDates.includes(dateStr)) {
                            rangeWarning.classList.add('show');
                            hasError = true;
                            break;
                        }
                    }
                }
            }
            
            if (hasError) {
                bookBtn.disabled = true;
                bookBtn.style.opacity = '0.5';
                bookBtn.style.cursor = 'not-allowed';
            } else {
                bookBtn.disabled = false;
                bookBtn.style.opacity = '1';
                bookBtn.style.cursor = 'pointer';
            }
        }
        
        function validateDates(roomId) {
            const checkInInput = document.getElementById('check_in_' + roomId);
            const checkOutInput = document.getElementById('check_out_' + roomId);
            const disabledDatesInput = document.getElementById('disabled_dates_' + roomId);
            
            const checkIn = checkInInput.value;
            const checkOut = checkOutInput.value;
            const disabledDates = JSON.parse(disabledDatesInput.value);
            
            if (!checkIn || !checkOut) {
                alert('Please select both check-in and check-out dates');
                return false;
            }
            
            const startDate = new Date(checkIn);
            const endDate = new Date(checkOut);
            
            if (endDate <= startDate) {
                alert('Check-out date must be after check-in date');
                return false;
            }
            
            if (disabledDates.includes(checkIn)) {
                alert('Check-in date is already occupied. Please select a different date.');
                return false;
            }
            
            if (disabledDates.includes(checkOut)) {
                alert('Check-out date is already occupied. Please select a different date.');
                return false;
            }
            
            for (let d = new Date(startDate); d < endDate; d.setDate(d.getDate() + 1)) {
                const dateStr = d.toISOString().split('T')[0];
                if (disabledDates.includes(dateStr)) {
                    alert('Selected date range includes occupied dates. Please choose different dates.');
                    return false;
                }
            }
            
            return true;
        }
    </script>
</body>
</html>