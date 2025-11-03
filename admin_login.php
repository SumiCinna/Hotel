<?php
require_once 'config.php';

$error = '';

define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'admin123');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $error = 'Username and password are required';
    } else {
        // Check built-in admin first
        if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
            // Built-in superadmin login
            $_SESSION['user_id'] = 999999;
            $_SESSION['username'] = 'superadmin';
            $_SESSION['email'] = 'admin@hotel.com';
            $_SESSION['full_name'] = 'Super Administrator';
            $_SESSION['phone'] = '0000000000';
            $_SESSION['role'] = 'admin';
            
            header('Location: admin.php');
            exit();
        }
        
        // If not built-in admin, check database
        $db = new Database();
        $conn = $db->getConnection();
        
        $stmt = $conn->prepare("SELECT user_id, username, password, email, full_name, phone, role, is_active 
                                FROM users 
                                WHERE username = ? 
                                AND is_active = TRUE 
                                AND role IN ('admin', 'manager')");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['full_name'] = $row['full_name'];
                $_SESSION['phone'] = $row['phone'];
                $_SESSION['role'] = $row['role'];
                
                header('Location: admin.php');
                exit();
            } else {
                $error = 'Invalid admin credentials';
            }
        } else {
            $error = 'Invalid admin credentials or insufficient permissions';
        }
        
        $stmt->close();
        $db->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Hotel Reservation System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }
        
        .admin-badge {
            background: #1e3c72;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        h2 {
            color: #1e3c72;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 600;
        }
        
        input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: #1e3c72;
        }
        
        .btn {
            width: 100%;
            padding: 15px;
            background: #1e3c72;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn:hover {
            background: #2a5298;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
        }
        
        .links {
            text-align: center;
            margin-top: 20px;
        }
        
        .links a {
            color: #1e3c72;
            text-decoration: none;
            font-weight: 600;
        }
        
        .links a:hover {
            text-decoration: underline;
        }
        
        .warning {
            background: #fff3cd;
            color: #856404;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #ffc107;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="admin-badge">🔐 Admin Access</div>
        <h2>Admin Login</h2>
        
        <div class="warning">
            ⚠️ This area is restricted to administrators and managers only.
        </div>
        
        <?php if($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Admin Username</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">Admin Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">🔑 Login as Admin</button>
        </form>
        
        <div class="links">
            <p><a href="login.php">← Regular User Login</a></p>
            <p><a href="index.php">Back to Home</a></p>
        </div>
    </div>
</body>
</html>