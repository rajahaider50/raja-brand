<?php
session_start();

// Database Configuration
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'raja_brand');
define('DB_PORT', 3306);

// App Configuration
define('APP_NAME', 'Raja Brand');
define('APP_URL', 'http://localhost/raja-brand');
define('UPLOAD_PATH', __DIR__ . '/uploads/');
define('UPLOAD_URL', APP_URL . '/uploads/');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

// Set charset
$conn->set_charset("utf8mb4");

// Helper Functions
function sanitize($data) {
    global $conn;
    return $conn->real_escape_string(trim($data));
}

function response($status, $message, $data = null) {
    $response = ['status' => $status, 'message' => $message];
    if ($data !== null) {
        $response['data'] = $data;
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function formatPrice($price) {
    return '₹' . number_format($price, 2, '.', ',');
}

function uploadFile($file, $folder = 'products') {
    if (!is_dir(UPLOAD_PATH . $folder)) {
        mkdir(UPLOAD_PATH . $folder, 0755, true);
    }
    
    $filename = time() . '_' . basename($file['name']);
    $target_path = UPLOAD_PATH . $folder . '/' . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return UPLOAD_URL . $folder . '/' . $filename;
    }
    return null;
}

// Global Variables
$page = basename($_SERVER['PHP_SELF'], '.php');
$is_mobile = preg_match('/(Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini)/i', $_SERVER['HTTP_USER_AGENT']);
?>
