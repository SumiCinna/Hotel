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
$available_rooms = null;

$result = $conn->query("CALL sp_get_room_types()");
$room_types = $result->fetch_all(MYSQLI_ASSOC);
$result->close();
$conn->next_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['search'])) {
        $check_in = $_POST['check_in'];
        $check_out = $_POST['check_out'];
        $room_type_id = !empty($_POST['room_type_id']) ? $_POST['room_type_id'] : null;
        
        if (strtotime($check_in) < strtotime(date('Y-m-d'))) {
            $error = 'Check-in date cannot be in the past';
        } elseif (strtotime($check_out) <= strtotime($check_in)) {
            $error = 'Check-out date must be after check-in date';
        } else {
            $stmt = $conn->prepare("CALL sp_get_available_rooms(?, ?, ?)");
            $stmt->bind_param("ssi", $check_in, $check_out, $room_type_id);
            $stmt->execute();
            $available_rooms = $stmt->get_result();
            $stmt->close();
            $conn->next_result();
            
            $_SESSION['search_check_in'] = $check_in;
            $_SESSION['search_check_out'] = $check_out;
        }
    } elseif (isset($_POST['book'])) {
        $room_id = $_POST['room_id'];
        $check_in = $_SESSION['search_check_in'];
        $check_out = $_SESSION['search_check_out'];
        $special_requests = $_POST['special_requests'];
        
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
            $error = 'This date is already booked, Please select other dates.';
        }
        
        $stmt->close();
        $conn->next_result();
    }
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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
            overflow-x: hidden;
        }
        
        .playfair {
            font-family: 'Playfair Display', serif;
        }
        
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(180deg, #7c3aed 0%, #6366f1 100%);
            padding: 30px 0;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .sidebar-header {
            padding: 0 30px 30px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 30px;
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .sidebar-logo i {
            font-size: 36px;
            color: white;
        }
        
        .sidebar-logo h2 {
            color: white;
            font-size: 22px;
            font-weight: 700;
        }
        
        .user-info {
            color: white;
            margin-top: 15px;
        }
        
        .user-info h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .user-info p {
            font-size: 13px;
            opacity: 0.9;
        }
        
        .sidebar-menu {
            padding: 0 15px;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            font-size: 15px;
            font-weight: 500;
        }
        
        .menu-item i {
            font-size: 18px;
            width: 20px;
        }
        
        .menu-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }
        
        .menu-item.active {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .menu-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 20px 15px;
        }
        
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            background: #f0f2f5;
        }
        
        .top-bar {
            background: white;
            padding: 25px 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .top-bar-left h1 {
            color: #1e293b;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .breadcrumb {
            color: #64748b;
            font-size: 14px;
        }
        
        .breadcrumb i {
            margin: 0 8px;
            font-size: 12px;
        }
        
        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .date-time {
            text-align: right;
        }
        
        .date-time p {
            color: #64748b;
            font-size: 13px;
        }
        
        .date-time h4 {
            color: #1e293b;
            font-size: 16px;
            font-weight: 600;
        }
        
        .container {
            padding: 40px;
        }
        
        .search-section {
            background: white;
            padding: 35px;
            border-radius: 20px;
            margin-bottom: 35px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        
        .search-section h2 {
            color: #1e293b;
            margin-bottom: 25px;
            font-size: 24px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .search-section h2 i {
            color: #7c3aed;
        }
        
        .search-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            align-items: end;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        label {
            margin-bottom: 8px;
            color: #475569;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        label i {
            color: #7c3aed;
            font-size: 16px;
        }
        
        input, select {
            padding: 14px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
            color: #334155;
        }
        
        input:focus, select:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }
        
        .btn {
            padding: 14px 28px;
            background: linear-gradient(135deg, #7c3aed 0%, #6366f1 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(124, 58, 237, 0.3);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(124, 58, 237, 0.4);
        }
        
        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 18px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            border-left: 4px solid #dc2626;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .error i {
            font-size: 20px;
        }
        
        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 18px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            border-left: 4px solid #10b981;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .success i {
            font-size: 20px;
        }
        
        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }
        
        .room-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        
        .room-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, #7c3aed 0%, #6366f1 100%);
        }
        
        .room-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }
        
        .room-card h3 {
            color: #1e293b;
            margin-bottom: 15px;
            font-size: 22px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .room-card h3 i {
            color: #7c3aed;
            font-size: 24px;
        }
        
        .room-info {
            margin-bottom: 20px;
        }
        
        .room-info p {
            color: #64748b;
            margin-bottom: 8px;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .room-info p strong {
            color: #475569;
            font-weight: 600;
        }
        
        .room-details {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            padding: 15px;
            background: #f8fafc;
            border-radius: 10px;
        }
        
        .room-detail-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }
        
        .room-detail-item i {
            font-size: 20px;
            color: #7c3aed;
        }
        
        .room-detail-item span {
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
        }
        
        .room-price {
            font-size: 28px;
            color: #7c3aed;
            font-weight: 700;
            margin: 20px 0;
            display: flex;
            align-items: baseline;
            gap: 5px;
        }
        
        .room-price span {
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
        }
        
        .book-form {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #f0f2f5;
        }
        
        textarea {
            width: 100%;
            padding: 14px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            resize: vertical;
            min-height: 80px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            color: #334155;
            transition: all 0.3s;
        }
        
        textarea:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }
        
        .empty-state {
            background: white;
            padding: 80px 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        
        .empty-state i {
            font-size: 80px;
            color: #cbd5e1;
            margin-bottom: 25px;
        }
        
        .empty-state h3 {
            color: #475569;
            margin-bottom: 15px;
            font-size: 24px;
            font-weight: 700;
        }
        
        .empty-state p {
            color: #64748b;
            font-size: 16px;
            margin-bottom: 25px;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .search-form {
                grid-template-columns: 1fr;
            }
            
            .rooms-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
            <div class="search-section">
                <h2 class="playfair"><i class="fas fa-search"></i> Search Available Rooms</h2>
                
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
                
                <form method="POST" class="search-form">
                    <div class="form-group">
                        <label for="check_in">
                            <i class="fas fa-calendar-check"></i>
                            Check-In Date
                        </label>
                        <input type="date" id="check_in" name="check_in" required min="<?php echo date('Y-m-d'); ?>" value="<?php echo isset($_POST['check_in']) ? $_POST['check_in'] : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="check_out">
                            <i class="fas fa-calendar-times"></i>
                            Check-Out Date
                        </label>
                        <input type="date" id="check_out" name="check_out" required min="<?php echo date('Y-m-d'); ?>" value="<?php echo isset($_POST['check_out']) ? $_POST['check_out'] : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="room_type_id">
                            <i class="fas fa-bed"></i>
                            Room Type
                        </label>
                        <select id="room_type_id" name="room_type_id">
                            <option value="">All Types</option>
                            <?php foreach($room_types as $type): ?>
                                <option value="<?php echo $type['room_type_id']; ?>" <?php echo (isset($_POST['room_type_id']) && $_POST['room_type_id'] == $type['room_type_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($type['type_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" name="search" class="btn">
                            <i class="fas fa-search"></i>
                            Search Rooms
                        </button>
                    </div>
                </form>
            </div>
            
            <?php if($available_rooms !== null): ?>
                <?php if($available_rooms->num_rows > 0): ?>
                    <div class="rooms-grid">
                        <?php while($room = $available_rooms->fetch_assoc()): ?>
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
                                
                                <form method="POST" class="book-form">
                                    <input type="hidden" name="room_id" value="<?php echo $room['room_id']; ?>">
                                    <div class="form-group">
                                        <label for="special_requests_<?php echo $room['room_id']; ?>">
                                            <i class="fas fa-comment-dots"></i>
                                            Special Requests (Optional)
                                        </label>
                                        <textarea id="special_requests_<?php echo $room['room_id']; ?>" name="special_requests" placeholder="Any special requirements..."></textarea>
                                    </div>
                                    <button type="submit" name="book" class="btn" style="width: 100%; margin-top: 15px; justify-content: center;">
                                        <i class="fas fa-calendar-check"></i>
                                        Book Now
                                    </button>
                                </form>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-bed"></i>
                        <h3>No Rooms Available</h3>
                        <p>Sorry, no rooms are available for the selected dates</p>
                        <p>Please try different dates or room types</p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>