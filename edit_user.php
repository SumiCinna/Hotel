<?php
require_once 'config.php';
date_default_timezone_set('Asia/Manila');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$error = '';
$success = '';

if ($user_id <= 0) {
    header('Location: admin_dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    $stmt = $conn->prepare("UPDATE users SET role = ?, is_active = ? WHERE user_id = ?");
    $stmt->bind_param("sii", $role, $is_active, $user_id);
    
    if ($stmt->execute()) {
        $success = 'User updated successfully!';
    } else {
        $error = 'Failed to update user.';
    }
    $stmt->close();
}

$stmt = $conn->prepare("SELECT user_id, username, email, full_name, phone, role, is_active, created_at FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    header('Location: admin_dashboard.php');
    exit();
}

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Admin Dashboard</title>
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
        
        .btn-back {
            padding: 10px 20px;
            background: linear-gradient(135deg, #7c3aed 0%, #6366f1 100%);
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
            box-shadow: 0 4px 10px rgba(124, 58, 237, 0.3);
        }
        
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(124, 58, 237, 0.4);
        }
        
        .container {
            padding: 40px;
            max-width: 900px;
            margin: 0 auto;
        }
        
        .form-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        
        .form-header {
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 2px solid #f0f2f5;
        }
        
        .form-header h2 {
            color: #1e293b;
            font-size: 26px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }
        
        .form-header h2 i {
            color: #7c3aed;
        }
        
        .form-header p {
            color: #64748b;
            font-size: 14px;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .alert i {
            font-size: 18px;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
        
        .info-section {
            background: #f8fafc;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            border-left: 4px solid #7c3aed;
        }
        
        .info-section h3 {
            color: #1e293b;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .info-section h3 i {
            color: #7c3aed;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
        }
        
        .info-item label {
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        
        .info-item span {
            color: #1e293b;
            font-size: 15px;
            font-weight: 500;
        }
        
        .form-section {
            margin-bottom: 30px;
        }
        
        .form-section h3 {
            color: #1e293b;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-section h3 i {
            color: #7c3aed;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            color: #334155;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .form-group select {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background: white;
            color: #1e293b;
        }
        
        .form-group select:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .checkbox-group:hover {
            border-color: #7c3aed;
            background: #fff;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: 22px;
            height: 22px;
            cursor: pointer;
            accent-color: #7c3aed;
        }
        
        .checkbox-group label {
            margin: 0;
            cursor: pointer;
            font-weight: 500;
            color: #1e293b;
        }
        
        .helper-text {
            font-size: 13px;
            color: #64748b;
            margin-left: 34px;
            margin-top: 8px;
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            padding-top: 25px;
            border-top: 2px solid #f0f2f5;
        }
        
        .btn {
            padding: 14px 30px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #7c3aed 0%, #6366f1 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(124, 58, 237, 0.3);
            flex: 1;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(124, 58, 237, 0.4);
        }
        
        .btn-secondary {
            background: #e2e8f0;
            color: #475569;
            flex: 1;
        }
        
        .btn-secondary:hover {
            background: #cbd5e1;
            transform: translateY(-2px);
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
            
            .form-actions {
                flex-direction: column;
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
                <p><i class="fas fa-user-shield"></i> Administrator</p>
            </div>
        </div>
        
        <div class="sidebar-menu">
            <a href="admin_dashboard.php" class="menu-item">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            <a href="manage_users.php" class="menu-item active">
                <i class="fas fa-users"></i>
                <span>Manage Users</span>
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
                <h1 class="playfair">Edit User</h1>
                <div class="breadcrumb">
                    <span>Home</span>
                    <i class="fas fa-chevron-right"></i>
                    <span>Dashboard</span>
                    <i class="fas fa-chevron-right"></i>
                    <span>Edit User</span>
                </div>
            </div>
            <div class="top-bar-right">
                <a href="admin_dashboard.php" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>
        
        <div class="container">
            <div class="form-card">
                <div class="form-header">
                    <h2 class="playfair"><i class="fas fa-user-edit"></i> Edit User Information</h2>
                    <p>Modify user role and account status</p>
                </div>
                
                <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span><?php echo $success; ?></span>
                </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo $error; ?></span>
                </div>
                <?php endif; ?>
                
                <div class="info-section">
                    <h3><i class="fas fa-info-circle"></i> User Details</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>User ID</label>
                            <span>#<?php echo $user['user_id']; ?></span>
                        </div>
                        <div class="info-item">
                            <label>Username</label>
                            <span><?php echo htmlspecialchars($user['username']); ?></span>
                        </div>
                        <div class="info-item">
                            <label>Full Name</label>
                            <span><?php echo htmlspecialchars($user['full_name']); ?></span>
                        </div>
                        <div class="info-item">
                            <label>Email Address</label>
                            <span><?php echo htmlspecialchars($user['email']); ?></span>
                        </div>
                        <div class="info-item">
                            <label>Phone Number</label>
                            <span><?php echo htmlspecialchars($user['phone']); ?></span>
                        </div>
                        <div class="info-item">
                            <label>Member Since</label>
                            <span><?php echo date('F d, Y', strtotime($user['created_at'])); ?></span>
                        </div>
                    </div>
                </div>
                
                <form method="POST" action="">
                    <div class="form-section">
                        <h3><i class="fas fa-cog"></i> Account Settings</h3>
                        
                        <div class="form-group">
                            <label for="role">
                                <i class="fas fa-user-tag"></i> User Role
                            </label>
                            <select name="role" id="role" required>
                                <option value="customer" <?php echo $user['role'] === 'customer' ? 'selected' : ''; ?>>Customer</option>
                                <option value="staff" <?php echo $user['role'] === 'staff' ? 'selected' : ''; ?>>Staff</option>
                                <option value="manager" <?php echo $user['role'] === 'manager' ? 'selected' : ''; ?>>Manager</option>
                                <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrator</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>
                                <i class="fas fa-toggle-on"></i> Account Status
                            </label>
                            <div class="checkbox-group">
                                <input type="checkbox" name="is_active" id="is_active" <?php echo $user['is_active'] ? 'checked' : ''; ?>>
                                <label for="is_active">Account is Active</label>
                            </div>
                            <p class="helper-text">Uncheck to deactivate this user account. Deactivated users cannot log in to the system.</p>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                        <a href="manage_users.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>