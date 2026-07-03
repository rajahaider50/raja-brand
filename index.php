<?php
define('INCLUDED', true);
include __DIR__ . '/config.php';

if (!isLoggedIn() && !isset($_SESSION['guest'])) {
    redirect('login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Raja Brand - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            -webkit-user-select: none;
            user-select: none;
            -webkit-touch-callout: none;
        }
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            transition: all 0.3s ease;
        }
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.2);
        }
        .badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }
        .scroll-horizontal {
            overflow-x: auto;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }
        .scroll-horizontal::-webkit-scrollbar {
            height: 4px;
        }
        .scroll-horizontal::-webkit-scrollbar-track {
            background: transparent;
        }
        .scroll-horizontal::-webkit-scrollbar-thumb {
            background: rgba(102, 126, 234, 0.3);
            border-radius: 2px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        @media (max-width: 768px) {
            .hero-text {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <?php include 'common/header.php'; ?>
    
    <div class="flex flex-col md:flex-row">
        <?php include 'common/sidebar.php'; ?>
        
        <main class="flex-1 overflow-y-auto pb-20 md:pb-0">
            <!-- Hero Section -->
            <section class="hero-gradient text-white px-4 py-12 md:py-16">
                <div class="max-w-6xl mx-auto">
                    <h1 class="hero-text text-3xl md:text-5xl font-bold mb-4">Welcome to Raja Brand</h1>
                    <p class="text-gray-100 mb-8 text-sm md:text-base">Discover premium products at amazing prices</p>
                    <div class="flex flex-col md:flex-row gap-4">
                        <a href="product.php" class="inline-flex items-center justify-center px-6 py-3 bg-white text-purple-600 font-semibold rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-shopping-bag mr-2"></i> Shop Now
                        </a>
                        <a href="#categories" class="inline-flex items-center justify-center px-6 py-3 bg-white/20 text-white font-semibold rounded-lg hover:bg-white/30 transition border border-white/30">
                            <i class="fas fa-list mr-2"></i> Browse Categories
                        </a>
                    </div>
                </div>
            </section>
            
            <!-- Categories Section -->
            <section id="categories" class="px-4 py-8 md:py-12">
                <div class="max-w-6xl mx-auto">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Shop by Category</h2>
                    <div class="scroll-horizontal flex gap-4 pb-4">
                        <?php
                        global $conn;
                        $result = $conn->query("SELECT * FROM categories LIMIT 10");
                        while ($cat = $result->fetch_assoc()) {
                            echo '<div class="glass-card p-6 min-w-max text-center cursor-pointer" onclick="window.location.href=\"product.php?cat=' . $cat['id'] . '\"">';
                            echo '<div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center mx-auto mb-3">';
                            echo '<i class="fas fa-shopping-bag text-white text-2xl"></i>';
                            echo '</div>';
                            echo '<p class="text-gray-700 font-semibold text-sm">' . htmlspecialchars($cat['name']) . '</p>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </section>
            
            <!-- Featured Products Section -->
            <section class="px-4 py-8 md:py-12 bg-white">
                <div class="max-w-6xl mx-auto">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Featured Products</h2>
                        <a href="product.php" class="text-purple-600 hover:text-purple-800 transition flex items-center">
                            View All <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <?php
                        $result = $conn->query("SELECT * FROM products LIMIT 8");
                        if ($result->num_rows > 0) {
                            while ($product = $result->fetch_assoc()) {
                                echo '<div class="product-card fade-in">';
                                echo '<div class="relative h-40 md:h-48 bg-gray-200 overflow-hidden group">';
                                echo '<img src="' . UPLOAD_URL . 'products/placeholder.jpg" alt="' . htmlspecialchars($product['name']) . '" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">';
                                if ($product['discount_price']) {
                                    $discount = round(((($product['price'] - $product['discount_price']) / $product['price']) * 100));
                                    echo '<div class="badge absolute top-3 right-3">' . $discount . '% OFF</div>';
                                }
                                echo '</div>';
                                echo '<div class="p-4">';
                                echo '<h3 class="font-semibold text-gray-800 text-sm line-clamp-2 mb-2">' . htmlspecialchars($product['name']) . '</h3>';
                                echo '<div class="flex items-center justify-between mb-3">';
                                echo '<div class="flex items-center space-x-2">';
                                echo '<span class="text-lg font-bold text-purple-600">' . formatPrice($product['discount_price'] ?? $product['price']) . '</span>';
                                if ($product['discount_price']) {
                                    echo '<span class="text-sm text-gray-400 line-through">' . formatPrice($product['price']) . '</span>';
                                }
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="flex gap-2">';
                                echo '<a href="product_detail.php?id=' . $product['id'] . '" class="flex-1 bg-purple-100 text-purple-600 py-2 rounded-lg text-center text-sm font-semibold hover:bg-purple-200 transition">View</a>';
                                echo '<button class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 text-white py-2 rounded-lg text-sm font-semibold hover:shadow-lg transition" onclick="addToCart(' . $product['id'] . ')">Add</button>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p class="col-span-4 text-center text-gray-500 py-8">No products available</p>';
                        }
                        ?>
                    </div>
                </div>
            </section>
            
            <!-- Stats Section -->
            <section class="px-4 py-8 md:py-12">
                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-3 md:grid-cols-4 gap-4">
                        <div class="glass-card p-6 text-center text-white">
                            <div class="text-3xl font-bold mb-2">10K+</div>
                            <p class="text-sm">Products</p>
                        </div>
                        <div class="glass-card p-6 text-center text-white">
                            <div class="text-3xl font-bold mb-2">50K+</div>
                            <p class="text-sm">Customers</p>
                        </div>
                        <div class="glass-card p-6 text-center text-white">
                            <div class="text-3xl font-bold mb-2">24/7</div>
                            <p class="text-sm">Support</p>
                        </div>
                        <div class="glass-card p-6 text-center text-white hidden md:block">
                            <div class="text-3xl font-bold mb-2">100%</div>
                            <p class="text-sm">Secure</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
    
    <?php include 'common/bottom.php'; ?>
    
    <script>
        // Prevent interactions
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('selectstart', e => e.preventDefault());
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
        
        function addToCart(productId) {
            // AJAX to add product to cart
            console.log('Adding product ' + productId + ' to cart');
            // Will be implemented later
        }
    </script>
</body>
</html>
