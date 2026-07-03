<?php
session_start();
$host = '127.0.0.1';
$user = 'root';
$pass = 'root';
$dbname = 'raja_brand';

// Create connection without database first
$conn = new mysqli($host, $user, $pass, '', 3306);

if ($conn->connect_error) {
    die('<div style="font-family: Arial; text-align: center; margin-top: 50px; color: #d32f2f;"><h2>Database Connection Failed</h2><p>' . $conn->connect_error . '</p></div>');
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if (!$conn->query($sql)) {
    die('<div style="font-family: Arial; text-align: center; margin-top: 50px; color: #d32f2f;"><h2>Error Creating Database</h2></div>');
}

// Select database
$conn->select_db($dbname);

// Create tables
$tables = [
    "CREATE TABLE IF NOT EXISTS `users` (
        `id` INT PRIMARY KEY AUTO_INCREMENT,
        `name` VARCHAR(100) NOT NULL,
        `email` VARCHAR(100) UNIQUE NOT NULL,
        `phone` VARCHAR(20),
        `password` VARCHAR(255) NOT NULL,
        `address` TEXT,
        `city` VARCHAR(50),
        `state` VARCHAR(50),
        `zipcode` VARCHAR(10),
        `profile_image` VARCHAR(255),
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
    
    "CREATE TABLE IF NOT EXISTS `admin` (
        `id` INT PRIMARY KEY AUTO_INCREMENT,
        `username` VARCHAR(100) UNIQUE NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `email` VARCHAR(100),
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
    
    "CREATE TABLE IF NOT EXISTS `categories` (
        `id` INT PRIMARY KEY AUTO_INCREMENT,
        `name` VARCHAR(100) NOT NULL,
        `image` VARCHAR(255),
        `description` TEXT,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
    
    "CREATE TABLE IF NOT EXISTS `products` (
        `id` INT PRIMARY KEY AUTO_INCREMENT,
        `cat_id` INT NOT NULL,
        `name` VARCHAR(100) NOT NULL,
        `description` TEXT,
        `price` DECIMAL(10, 2) NOT NULL,
        `discount_price` DECIMAL(10, 2),
        `stock` INT DEFAULT 0,
        `image` VARCHAR(255),
        `rating` FLOAT DEFAULT 0,
        `reviews` INT DEFAULT 0,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`cat_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
    
    "CREATE TABLE IF NOT EXISTS `orders` (
        `id` INT PRIMARY KEY AUTO_INCREMENT,
        `user_id` INT NOT NULL,
        `total_amount` DECIMAL(10, 2) NOT NULL,
        `status` ENUM('Placed', 'Dispatched', 'Delivered', 'Cancelled') DEFAULT 'Placed',
        `payment_method` VARCHAR(50) DEFAULT 'COD',
        `delivery_address` TEXT,
        `delivery_phone` VARCHAR(20),
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
    
    "CREATE TABLE IF NOT EXISTS `order_items` (
        `id` INT PRIMARY KEY AUTO_INCREMENT,
        `order_id` INT NOT NULL,
        `product_id` INT NOT NULL,
        `quantity` INT NOT NULL,
        `price` DECIMAL(10, 2) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
    
    "CREATE TABLE IF NOT EXISTS `cart` (
        `id` INT PRIMARY KEY AUTO_INCREMENT,
        `user_id` INT NOT NULL,
        `product_id` INT NOT NULL,
        `quantity` INT DEFAULT 1,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY `unique_cart` (`user_id`, `product_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
    
    "CREATE TABLE IF NOT EXISTS `wishlist` (
        `id` INT PRIMARY KEY AUTO_INCREMENT,
        `user_id` INT NOT NULL,
        `product_id` INT NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY `unique_wishlist` (`user_id`, `product_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
];

foreach ($tables as $sql) {
    if (!$conn->query($sql)) {
        die('<div style="font-family: Arial; text-align: center; margin-top: 50px; color: #d32f2f;"><h2>Error Creating Tables</h2><p>' . $conn->error . '</p></div>');
    }
}

// Insert default admin
$admin_password = password_hash('admin123', PASSWORD_BCRYPT);
$conn->query("INSERT IGNORE INTO `admin` (`username`, `password`, `email`) VALUES ('admin', '$admin_password', 'admin@rajabrand.com')");

// Insert sample categories
$categories = [
    ['name' => 'Electronics', 'image' => '/uploads/categories/electronics.png'],
    ['name' => 'Fashion', 'image' => '/uploads/categories/fashion.png'],
    ['name' => 'Home & Kitchen', 'image' => '/uploads/categories/home.png'],
    ['name' => 'Sports', 'image' => '/uploads/categories/sports.png'],
    ['name' => 'Books', 'image' => '/uploads/categories/books.png']
];

foreach ($categories as $cat) {
    $conn->query("INSERT IGNORE INTO `categories` (`name`, `image`) VALUES ('" . $cat['name'] . "', '" . $cat['image'] . "')");
}

// Create upload folders
$folders = ['uploads', 'uploads/products', 'uploads/categories', 'uploads/users'];
foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raja Brand - Installation Complete</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
    </style>
</head>
<body>
    <div class="glass p-8 md:p-12 max-w-md w-full mx-4">
        <div class="text-center">
            <i class="fas fa-check-circle text-green-400 text-5xl mb-4"></i>
            <h1 class="text-3xl font-bold text-white mb-2">Installation Complete!</h1>
            <p class="text-gray-100 mb-6">Raja Brand Database Setup Successfully</p>
            
            <div class="bg-white bg-opacity-10 rounded-lg p-4 mb-6 text-left">
                <p class="text-sm text-gray-100"><strong>Database:</strong> raja_brand</p>
                <p class="text-sm text-gray-100 mt-2"><strong>Admin Username:</strong> admin</p>
                <p class="text-sm text-gray-100 mt-2"><strong>Admin Password:</strong> admin123</p>
            </div>
            
            <a href="login.php" class="inline-block bg-gradient-to-r from-purple-500 to-pink-500 text-white px-8 py-3 rounded-lg font-semibold hover:shadow-lg transition">
                <i class="fas fa-arrow-right mr-2"></i> Go to Login
            </a>
        </div>
    </div>
</body>
</html>