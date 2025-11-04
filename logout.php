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
    <link rel="stylesheet" href="css/logout.css">
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