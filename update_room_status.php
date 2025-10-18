<?php
require_once 'config.php';
date_default_timezone_set('Asia/Manila');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: staff_rooms.php');
    exit();
}

$room_id = $_GET['id'];
$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT r.room_id, r.room_number, rt.type_name, r.floor, r.status, rt.price_per_night, rt.capacity FROM rooms r JOIN room_types rt ON r.type_id = rt.type_id WHERE r.room_id = ?");
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: staff_rooms.php');
    exit();
}

$room = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $new_status = $_POST['status'];
    $allowed_statuses = ['available', 'occupied', 'maintenance'];
    
    if (in_array($new_status, $allowed_statuses)) {
        $update_stmt = $conn->prepare("UPDATE rooms SET status = ? WHERE room_id = ?");
        $update_stmt->bind_param("si", $new_status, $room_id);
        $update_stmt->execute();
        
        $_SESSION['success'] = "Room status updated successfully!";
        header("Location: staff_rooms.php");
        exit();
    }
}

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Room Status - Hotel Reservation System</title>
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
            background: linear-gradient(180deg, #059669 0%, #047857 100%);
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
            max-width: 800px;
            margin: 0 auto;
        }
        
        .section {
            background: white;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f2f5;
        }
        
        .section-header h3 {
            color: #1e293b;
            font-size: 22px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-header h3 i {
            color: #059669;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .info-item {
            padding: 15px;
            background: #f8fafc;
            border-radius: 10px;
        }
        
        .info-item label {
            display: block;
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-item p {
            color: #1e293b;
            font-size: 16px;
            font-weight: 500;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            color: #1e293b;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .status-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }
        
        .status-option {
            position: relative;
        }
        
        .status-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }
        
        .status-option label {
            display: block;
            padding: 20px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .status-option label i {
            font-size: 32px;
            margin-bottom: 10px;
            display: block;
        }
        
        .status-option input[type="radio"]:checked + label {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            border-color: #059669;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        }
        
        .status.available {
            background: #d1fae5;
            color: #065f46;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
        }
        
        .status.occupied {
            background: #fee2e2;
            color: #991b1b;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
        }
        
        .status.maintenance {
            background: #fef3c7;
            color: #92400e;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
        }
        
        .btn {
            padding: 12px 24px;
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(5, 150, 105, 0.3);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(5, 150, 105, 0.4);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            box-shadow: 0 4px 10px rgba(107, 114, 128, 0.3);
        }
        
        .btn-secondary:hover {
            box-shadow: 0 6px 15px rgba(107, 114, 128, 0.4);
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .info-grid {
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
                <p><i class="fas fa-user-tie"></i> Staff Member</p>
            </div>
        </div>
        
        <div class="sidebar-menu">
            <a href="staff_dashboard.php" class="menu-item">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            <a href="manage_bookings.php" class="menu-item">
                <i class="fas fa-calendar-check"></i>
                <span>Manage Bookings</span>
            </a>
            <a href="staff_rooms.php" class="menu-item active">
                <i class="fas fa-door-open"></i>
                <span>Room Management</span>
            </a>
            <a href="check_in_out.php" class="menu-item">
                <i class="fas fa-exchange-alt"></i>
                <span>Check In/Out</span>
            </a>
            
            <div class="menu-divider"></div>
            
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
                <h1 class="playfair">Update Room Status</h1>
                <div class="breadcrumb">
                    <span>Home</span>
                    <i class="fas fa-chevron-right"></i>
                    <span>Room Management</span>
                    <i class="fas fa-chevron-right"></i>
                    <span>Update Status</span>
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
            <div class="section">
                <div class="section-header">
                    <h3 class="playfair"><i class="fas fa-door-closed"></i> Room Information</h3>
                    <span class="status <?php echo $room['status']; ?>"><?php echo ucfirst($room['status']); ?></span>
                </div>
                
                <div class="info-grid">
                    <div class="info-item">
                        <label><i class="fas fa-door-closed"></i> Room Number</label>
                        <p><?php echo htmlspecialchars($room['room_number']); ?></p>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-bed"></i> Room Type</label>
                        <p><?php echo htmlspecialchars($room['type_name']); ?></p>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-building"></i> Floor</label>
                        <p><?php echo $room['floor']; ?></p>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-users"></i> Capacity</label>
                        <p><?php echo $room['capacity']; ?> Guests</p>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-peso-sign"></i> Price per Night</label>
                        <p>₱<?php echo number_format($room['price_per_night'], 2); ?></p>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <div class="section-header">
                    <h3 class="playfair"><i class="fas fa-edit"></i> Update Status</h3>
                </div>
                
                <form method="POST">
                    <div class="form-group">
                        <label>Select New Status</label>
                        <div class="status-options">
                            <div class="status-option">
                                <input type="radio" id="available" name="status" value="available" <?php echo $room['status'] === 'available' ? 'checked' : ''; ?>>
                                <label for="available">
                                    <i class="fas fa-door-open"></i>
                                    <div>Available</div>
                                </label>
                            </div>
                            <div class="status-option">
                                <input type="radio" id="occupied" name="status" value="occupied" <?php echo $room['status'] === 'occupied' ? 'checked' : ''; ?>>
                                <label for="occupied">
                                    <i class="fas fa-bed"></i>
                                    <div>Occupied</div>
                                </label>
                            </div>
                            <div class="status-option">
                                <input type="radio" id="maintenance" name="status" value="maintenance" <?php echo $room['status'] === 'maintenance' ? 'checked' : ''; ?>>
                                <label for="maintenance">
                                    <i class="fas fa-tools"></i>
                                    <div>Maintenance</div>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i>
                            Update Status
                        </button>
                        <a href="staff_rooms.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>