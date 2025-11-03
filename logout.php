<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Confirmation</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-overlay {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        .modal-content {
            background: white;
            padding: 50px 40px;
            border-radius: 20px;
            width: 90%;
            max-width: 450px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .modal-icon {
            font-size: 70px;
            color: #7c3aed;
            margin-bottom: 25px;
            animation: bounce 1s ease infinite;
        }
        
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .modal-content h2 {
            color: #1e293b;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 15px;
            font-family: 'Playfair Display', serif;
        }
        
        .modal-content p {
            color: #64748b;
            font-size: 16px;
            margin-bottom: 35px;
            line-height: 1.6;
        }
        
        .modal-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        
        .btn {
            padding: 15px 35px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-cancel {
            background: #e2e8f0;
            color: #475569;
        }
        
        .btn-cancel:hover {
            background: #cbd5e1;
            transform: translateY(-2px);
        }
        
        .btn-confirm {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }
        
        .btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
        }
        
        @media (max-width: 768px) {
            .modal-content {
                padding: 40px 30px;
            }
            
            .modal-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="modal-overlay">
        <div class="modal-content">
            <div class="modal-icon">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <h2>Confirm Logout</h2>
            <p>Are you sure you want to logout from your account?</p>
            <div class="modal-buttons">
                <button class="btn btn-cancel" onclick="goBack()">
                    <i class="fas fa-arrow-left"></i>
                    Cancel
                </button>
                <button class="btn btn-confirm" onclick="confirmLogout()">
                    <i class="fas fa-check"></i>
                    Yes, Logout
                </button>
            </div>
        </div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }

        function confirmLogout() {
            window.location.href = 'logout_confirm.php';
        }
    </script>
</body>
</html>