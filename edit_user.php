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
    
    $stmt = $conn->prepare("CALL sp_update_user_admin(?, ?, ?)");
    $stmt->bind_param("isi", $user_id, $role, $is_active);
    
    if ($stmt->execute()) {
        $success = 'User updated successfully!';
    } else {
        $error = 'Failed to update user.';
    }
    $stmt->close();
}

$stmt = $conn->prepare("SELECT * FROM vw_user_details WHERE user_id = ?");
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
    <link rel="stylesheet" href="css/edit_user.css">
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