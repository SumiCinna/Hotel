<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $terms_accepted = isset($_POST['terms_accepted']) ? true : false;
    
    if (empty($username) || empty($password) || empty($email) || empty($full_name)) {
        $error = 'Username, email, full name, and password are required';
    } elseif (strlen($username) > 30) {
        $error = 'Username must not exceed 30 characters';
    } elseif (strlen($email) > 100) {
        $error = 'Email must not exceed 100 characters';
    } elseif (strlen($full_name) > 60) {
        $error = 'Full name must not exceed 60 characters';
    } elseif (strlen($password) > 50) {
        $error = 'Password must not exceed 50 characters';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } elseif (!preg_match('/@/', $email) || !preg_match('/\.com$/', $email)) {
        $error = 'Email must contain @ and end with .com';
    } elseif (!empty($phone) && !preg_match('/^[0-9]{1,11}$/', $phone)) {
        $error = 'Phone number must contain only digits and be up to 11 numbers';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters';
    } elseif (!$terms_accepted) {
        $error = 'You must accept the Terms of Service and Privacy Policy';
    } else {
        $db = new Database();
        $conn = $db->getConnection();
        
        if (!empty($phone)) {
            $stmt_check = $conn->prepare("SELECT user_id FROM users WHERE phone = ?");
            $stmt_check->bind_param("s", $phone);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();
            
            if ($result_check->num_rows > 0) {
                $error = 'Phone number is already registered';
                $stmt_check->close();
                $db->close();
            } else {
                $stmt_check->close();
            }
        }
        
        if (empty($error)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("CALL sp_register_user(?, ?, ?, ?, ?, 'customer')");
            $stmt->bind_param("sssss", $username, $hashed_password, $email, $full_name, $phone);
            
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result && $row = $result->fetch_assoc()) {
                    $success = 'Registration successful! You can now login.';
                }
            } else {
                if ($conn->errno === 1062) {
                    $error = 'Username or email already exists';
                } else {
                    $error = 'Registration failed: ' . $conn->error;
                }
            }
            
            $stmt->close();
            $db->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Hotel Reservation System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -250px;
            right: -250px;
            animation: float 6s ease-in-out infinite;
        }
        
        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            bottom: -200px;
            left: -200px;
            animation: float 8s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(20px); }
        }
        
        .register-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 50px 45px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 550px;
            width: 100%;
            position: relative;
            z-index: 1;
            animation: slideUp 0.5s ease-out;
            max-height: 95vh;
            overflow-y: auto;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .register-container::-webkit-scrollbar {
            width: 8px;
        }
        
        .register-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .register-container::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 10px;
        }
        
        .logo-section {
            text-align: center;
            margin-bottom: 35px;
        }
        
        .logo-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .logo-icon i {
            font-size: 40px;
            color: white;
        }
        
        h2 {
            color: #2d3748;
            margin-bottom: 10px;
            text-align: center;
            font-size: 32px;
            font-weight: 700;
        }
        
        .subtitle {
            text-align: center;
            color: #718096;
            font-size: 14px;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 22px;
            position: relative;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #2d3748;
            font-weight: 600;
            font-size: 14px;
        }
        
        .required {
            color: #e53e3e;
            margin-left: 3px;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 16px;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"] {
            width: 100%;
            padding: 14px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: white;
            font-family: 'Poppins', sans-serif;
        }
        
        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #a0aec0;
            transition: color 0.3s;
            font-size: 16px;
        }
        
        .password-toggle:hover {
            color: #667eea;
        }
        
        .terms-group {
            margin-bottom: 25px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        
        .terms-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-top: 3px;
            cursor: pointer;
            accent-color: #667eea;
        }
        
        .terms-text {
            font-size: 13px;
            color: #4a5568;
            line-height: 1.6;
        }
        
        .terms-text a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .terms-text a:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        
        .btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            font-family: 'Poppins', sans-serif;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .error {
            background: linear-gradient(135deg, #fee 0%, #fdd 100%);
            color: #c33;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 25px;
            border-left: 4px solid #c33;
            font-size: 14px;
            display: flex;
            align-items: center;
            animation: shake 0.5s ease;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        
        .error i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .success {
            background: linear-gradient(135deg, #efe 0%, #dfd 100%);
            color: #2d5016;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 25px;
            border-left: 4px solid #48bb78;
            font-size: 14px;
            display: flex;
            align-items: center;
            animation: slideDown 0.5s ease;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .success i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .links {
            text-align: center;
            margin-top: 30px;
        }
        
        .links p {
            margin: 10px 0;
            color: #4a5568;
            font-size: 14px;
        }
        
        .links a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            position: relative;
        }
        
        .links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: #667eea;
            transition: width 0.3s ease;
        }
        
        .links a:hover::after {
            width: 100%;
        }
        
        .links a:hover {
            color: #764ba2;
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0;
            color: #a0aec0;
            font-size: 13px;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .divider span {
            padding: 0 15px;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 40px;
            border-radius: 20px;
            width: 90%;
            max-width: 700px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
        }
        
        .modal-content::-webkit-scrollbar {
            width: 8px;
        }
        
        .modal-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .modal-content::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 10px;
        }
        
        .close {
            color: #a0aec0;
            float: right;
            font-size: 32px;
            font-weight: bold;
            line-height: 1;
            cursor: pointer;
            transition: color 0.3s;
        }
        
        .close:hover {
            color: #667eea;
        }
        
        .modal-content h3 {
            color: #2d3748;
            margin: 20px 0 15px 0;
            font-size: 24px;
        }
        
        .modal-content h4 {
            color: #4a5568;
            margin: 15px 0 10px 0;
            font-size: 18px;
        }
        
        .modal-content p,
        .modal-content ul {
            color: #4a5568;
            line-height: 1.8;
            margin-bottom: 15px;
        }
        
        .modal-content ul {
            padding-left: 20px;
        }
        
        .modal-content li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo-section">
            <div class="logo-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h2>Create Account</h2>
            <p class="subtitle">Join us and start booking</p>
        </div>
        
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
        
        <form method="POST" action="" id="registerForm">
            <div class="form-group">
                <label for="username">Username<span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" id="username" name="username" maxlength="30" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Email<span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" id="email" name="email" maxlength="100" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="full_name">Full Name<span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-id-card input-icon"></i>
                    <input type="text" id="full_name" name="full_name" maxlength="60" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone</label>
                <div class="input-wrapper">
                    <i class="fas fa-phone input-icon"></i>
                    <input type="tel" id="phone" name="phone" maxlength="11" pattern="[0-9]*">
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Password<span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="password" name="password" maxlength="50" required minlength="8">
                    <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                </div>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password<span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="confirm_password" name="confirm_password" maxlength="50" required>
                    <i class="fas fa-eye password-toggle" id="toggleConfirmPassword"></i>
                </div>
            </div>
            
            <div class="terms-group">
                <input type="checkbox" id="terms_accepted" name="terms_accepted" required>
                <label for="terms_accepted" class="terms-text">
                    I agree to the <a href="#" id="termsLink">Terms of Service</a> and <a href="#" id="privacyLink">Privacy Policy</a><span class="required">*</span>
                </label>
            </div>
            
            <button type="submit" class="btn">
                <i class="fas fa-user-plus" style="margin-right: 8px;"></i>
                Create Account
            </button>
        </form>
        
        <div class="divider">
            <span>OR</span>
        </div>
        
        <div class="links">
            <p>Already have an account? <a href="login.php">Login here</a></p>
            <p><a href="index.php"><i class="fas fa-arrow-left" style="margin-right: 5px;"></i>Back to Home</a></p>
        </div>
    </div>
    
    <div id="termsModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeTerms">&times;</span>
            <h3>Terms of Service</h3>
            <p>By using our services and making a reservation at Hotel MS, you agree to the following terms and conditions:</p>
            <ul>
                <li><strong>Eligibility:</strong> You must be at least 18 years old to make a reservation or book a room at our hotel.</li>
                <li><strong>Reservation Policy:</strong> All reservations must be made through our official website or phone line, or. Upon booking, an invoice will be provided for your reference. Please note that payment is not processed online, and the reservation is confirmed upon receipt of the invoice.</li>
                <li><strong>Check-In/Check-Out:</strong> Late check-outs may incur additional fees unless otherwise arranged with the hotel in advance.</li>
                <li><strong>Identification:</strong> You must present a valid government-issued photo ID and a credit/debit card upon check-in.</li>
                <li><strong>Payment Policy:</strong> Payment for your stay must be made in person at the hotel front desk at the time of check-in. Upon booking, you will receive an invoice for your reservation, which serves as a reference. The payment must be settled at the hotel using accepted payment methods, including credit/debit cards or cash. Please note that payment will be processed when you check in, and your reservation may be canceled if payment is not received at that time.</li>
                <li><strong>Guest Conduct:</strong> Guests are expected to behave in a respectful and lawful manner while staying at the hotel. Any disruptive or illegal behavior may result in eviction from the hotel without refund.</li>
                <li><strong>No Smoking:</strong> Smoking is prohibited in all indoor areas of the hotel, including guest rooms, corridors, and common areas. Smoking is only allowed in designated outdoor smoking areas. Violators may incur a cleaning fee.</li>
                <li><strong>Pets:</strong> Pets are not allowed at our hotel.</li>
                <li><strong>Account Suspension:</strong> Cancellations must be made at least 1 day prior to your scheduled check-in date. Late cancellations or no-shows will result in the suspension of your account.</li>
                <li><strong>Damages:</strong> You are responsible for any damage or loss caused to hotel property during your stay. Any damages will be charged to your credit card on file.</li>
                <li><strong>Hotel Liability:</strong> The hotel is not liable for any loss, theft, or damage to your personal belongings during your stay. Please keep valuables in your room's safe or at the front desk.</li>
                <li><strong>Third-Party Services:</strong> The hotel may offer third-party services such as other amenities. We are not responsible for the actions, services, or liabilities of these third-party providers.</li>
                <li><strong>Force Majeure:</strong> The hotel is not responsible for any disruptions, cancellations, or delays due to unforeseen circumstances, including but not limited to natural disasters, strikes, or government actions.</li>
                <li><strong>Changes to Terms:</strong> We reserve the right to update or modify these Terms of Service at any time. All changes will be posted on this page, and continued use of our services constitutes acceptance of the updated terms.</li>
                <li><strong>Governing Law:</strong> These Terms of Service are governed by the applicable laws of the jurisdiction where the service provider is based. Any disputes will be resolved in the courts of the same jurisdiction.</li>
                <li><strong>Indemnification:</strong> You agree to indemnify and hold harmless HotelMS and its affiliates from any claims, damages, or expenses arising from your use of our services or violations of these terms.</li>
            </ul>
        </div>
    </div>
    
    <div id="privacyModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closePrivacy">&times;</span>
            <h3>Privacy Policy</h3>
            <p>At Hotel MS, we respect your privacy and are committed to protecting your personal information. By using our services and making a reservation, you agree to the following privacy terms:</p>
            <ul>
                <li><strong>Information Collection:</strong> We collect personal information such as your name, email address, phone number, date of birth, picture, address, and reservation preferences when you make a booking or interact with our website.</li>
                <li><strong>Use of Information:</strong> The personal information we collect is used for processing your reservation, improving your experience, sending you booking confirmations, and providing customer support. We may also use your information for marketing purposes if you consent.</li>
                <li><strong>Payment Processing:</strong> We do not process payments online. All payments are made in person at the hotel front desk at the time of check-in. Your payment details are not stored on our website.</li>
                <li><strong>Data Security:</strong> We take appropriate security measures to protect your personal information from unauthorized access, alteration, or destruction. Your data is stored securely.</li>
                <li><strong>Sharing of Information:</strong> We do not sell or rent your personal information to third parties. However, we may share your information with trusted service providers to help us manage your reservation or improve our services.</li>
                <li><strong>Cookies and Tracking:</strong> Our website uses cookies to enhance your browsing experience and track usage patterns. You can control cookies through your browser settings, but some features of the site may not work properly if cookies are disabled.</li>
                <li><strong>Data Retention:</strong> We will retain your personal data for as long as necessary to fulfill the purposes for which it was collected or as required by law. After this period, your data will be securely deleted.</li>
                <li><strong>Your Rights:</strong> You have the right to access, correct, or delete your personal information. If you wish to make any changes or have concerns about how your data is handled, please contact us directly.</li>
                <li><strong>Children's Privacy:</strong> Hotel MS does not knowingly collect personal information from children under the age of 13. If we discover that a child under 13 has provided us with personal information, we will take steps to remove it as soon as possible.</li>
                <li><strong>Policy Changes:</strong> We may update this Privacy Policy from time to time. Any changes will be posted on this page, and continued use of our services will constitute acceptance of the updated policy.</li>
                <li><strong>Governing Law:</strong> This Privacy Policy is governed by the laws of the jurisdiction in which Hotel MS is based. Any disputes regarding privacy will be resolved under the applicable laws.</li>
            </ul>
        </div>
    </div>
    
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPassword = document.getElementById('confirm_password');
        const phoneInput = document.getElementById('phone');
        const emailInput = document.getElementById('email');
        const registerForm = document.getElementById('registerForm');
        
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
        
        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
        
        phoneInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 11) {
                this.value = this.value.slice(0, 11);
            }
        });
        
        registerForm.addEventListener('submit', function(e) {
            const emailValue = emailInput.value;
            if (!emailValue.includes('@') || !emailValue.endsWith('.com')) {
                e.preventDefault();
                alert('Email must contain @ and end with .com');
                return false;
            }
            
            if (password.value.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters');
                return false;
            }
            
            if (password.value !== confirmPassword.value) {
                e.preventDefault();
                alert('Passwords do not match');
                return false;
            }
        });
        
        const termsModal = document.getElementById('termsModal');
        const privacyModal = document.getElementById('privacyModal');
        const termsLink = document.getElementById('termsLink');
        const privacyLink = document.getElementById('privacyLink');
        const closeTerms = document.getElementById('closeTerms');
        const closePrivacy = document.getElementById('closePrivacy');
        
        termsLink.addEventListener('click', function(e) {
            e.preventDefault();
            termsModal.style.display = 'block';
        });
        
        privacyLink.addEventListener('click', function(e) {
            e.preventDefault();
            privacyModal.style.display = 'block';
        });
        
        closeTerms.addEventListener('click', function() {
            termsModal.style.display = 'none';
        });
        
        closePrivacy.addEventListener('click', function() {
            privacyModal.style.display = 'none';
        });
        
        window.addEventListener('click', function(e) {
            if (e.target == termsModal) {
                termsModal.style.display = 'none';
            }
            if (e.target == privacyModal) {
                privacyModal.style.display = 'none';
            }
        });
    </script>
</body>
</html>