<?php
define('INCLUDED', true);
include __DIR__ . '/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = sanitize($_POST['action']);
        
        if ($action == 'login') {
            $email = sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            if (empty($email) || empty($password)) {
                $error = 'Email and password are required';
            } else {
                $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    if (password_verify($password, $user['password'])) {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_name'] = $user['name'];
                        $_SESSION['user_email'] = $user['email'];
                        redirect('index.php');
                    } else {
                        $error = 'Invalid password';
                    }
                } else {
                    $error = 'User not found';
                }
            }
        } elseif ($action == 'register') {
            $name = sanitize($_POST['name'] ?? '');
            $email = sanitize($_POST['email'] ?? '');
            $phone = sanitize($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            if (empty($name) || empty($email) || empty($password)) {
                $error = 'Name, email, and password are required';
            } elseif ($password !== $confirm_password) {
                $error = 'Passwords do not match';
            } else {
                $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
                if ($result->num_rows > 0) {
                    $error = 'Email already registered';
                } else {
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                    $sql = "INSERT INTO users (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$hashed_password')";
                    if ($conn->query($sql)) {
                        $success = 'Registration successful! Please login.';
                    } else {
                        $error = 'Registration failed: ' . $conn->error;
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Raja Brand - Login & Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            -webkit-user-select: none;
            user-select: none;
            -webkit-touch-callout: none;
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
        }
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        .glass-input {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 10px;
            padding: 12px 16px;
            width: 100%;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .glass-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .glass-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 20px rgba(168, 85, 247, 0.3);
        }
        .glass-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 10px;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 14px;
        }
        .glass-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }
        .glass-btn:active {
            transform: translateY(0);
        }
        .tab-btn {
            padding: 12px 24px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            border-bottom: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .tab-btn.active {
            color: white;
            border-bottom-color: white;
        }
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 14px;
            display: flex;
            align-items: center;
            space-x: 8px;
        }
        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }
        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
        }
        .glow {
            animation: glow 2s ease-in-out infinite;
        }
        @keyframes glow {
            0%, 100% { box-shadow: 0 0 5px rgba(168, 85, 247, 0.3); }
            50% { box-shadow: 0 0 20px rgba(168, 85, 247, 0.6); }
        }
        @media (max-width: 768px) {
            .container {
                min-height: 100vh;
                padding-bottom: 20px;
            }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen px-4 py-8">
    <div class="glass p-8 md:p-10 w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg items-center justify-center mb-4 glow">
                <i class="fas fa-crown text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Raja Brand</h1>
            <p class="text-gray-200 text-sm">Premium E-commerce Platform</p>
        </div>
        
        <!-- Tabs -->
        <div class="flex border-b border-white/20 mb-6">
            <button class="tab-btn active" onclick="switchTab('login')">Login</button>
            <button class="tab-btn" onclick="switchTab('register')">Register</button>
        </div>
        
        <!-- Login Tab -->
        <div id="login-tab" class="tab-content">
            <?php if ($error && !$success) { ?>
                <div class="alert alert-error mb-4">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span><?php echo $error; ?></span>
                </div>
            <?php } ?>
            
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="login">
                <input type="email" name="email" placeholder="Email Address" class="glass-input" required>
                <input type="password" name="password" placeholder="Password" class="glass-input" required>
                <button type="submit" class="glass-btn">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </button>
                <p class="text-center text-gray-300 text-sm mt-4">
                    Don't have an account? <a href="#" onclick="switchTab('register')" class="text-purple-300 hover:text-white transition">Sign up</a>
                </p>
            </form>
            
            <!-- Guest Login -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-white/20"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-gradient-to-b from-purple-600 to-pink-600 text-gray-300">OR</span>
                </div>
            </div>
            
            <button type="button" class="glass-btn bg-gradient-to-r from-gray-600 to-gray-700" onclick="guestLogin()">
                <i class="fas fa-eye mr-2"></i> Continue as Guest
            </button>
        </div>
        
        <!-- Register Tab -->
        <div id="register-tab" class="tab-content hidden">
            <?php if ($success) { ?>
                <div class="alert alert-success mb-4">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span><?php echo $success; ?></span>
                </div>
            <?php } ?>
            <?php if ($error && $success) { ?>
                <div class="alert alert-error mb-4">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span><?php echo $error; ?></span>
                </div>
            <?php } ?>
            
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="register">
                <input type="text" name="name" placeholder="Full Name" class="glass-input" required>
                <input type="email" name="email" placeholder="Email Address" class="glass-input" required>
                <input type="tel" name="phone" placeholder="Phone Number" class="glass-input">
                <input type="password" name="password" placeholder="Password" class="glass-input" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" class="glass-input" required>
                <button type="submit" class="glass-btn">
                    <i class="fas fa-user-plus mr-2"></i> Create Account
                </button>
                <p class="text-center text-gray-300 text-sm mt-4">
                    Already have an account? <a href="#" onclick="switchTab('login')" class="text-purple-300 hover:text-white transition">Sign in</a>
                </p>
            </form>
        </div>
    </div>
    
    <script>
        // Prevent interactions
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('selectstart', e => e.preventDefault());
        document.addEventListener('keydown', e => {
            if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && e.key === 'I')) e.preventDefault();
        });
        
        function switchTab(tab) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            
            document.getElementById(tab + '-tab').classList.remove('hidden');
            event.target.classList.add('active');
        }
        
        function guestLogin() {
            sessionStorage.setItem('guest', 'true');
            window.location.href = 'index.php';
        }
    </script>
</body>
</html>
