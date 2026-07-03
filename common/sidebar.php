<?php if (!defined('INCLUDED')) { include __DIR__ . '/../config.php'; } ?>
<div id="sidebar" class="fixed inset-0 z-40 transform -translate-x-full transition-transform duration-300 md:static md:translate-x-0 md:w-64 md:bg-gradient-to-b md:from-gray-50 md:to-gray-100">
    <!-- Mobile Sidebar -->
    <div class="md:hidden bg-gradient-to-b from-purple-600 to-pink-600 text-white h-screen w-64 p-4 overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Menu</h2>
            <button onclick="toggleSidebar()" class="text-2xl">&times;</button>
        </div>
        
        <nav class="space-y-3">
            <a href="index.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/20 transition">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="product.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/20 transition">
                <i class="fas fa-shopping-bag"></i>
                <span>Products</span>
            </a>
            <?php if (isLoggedIn()) { ?>
                <a href="cart.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/20 transition">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Cart</span>
                </a>
                <a href="order.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/20 transition">
                    <i class="fas fa-box"></i>
                    <span>Orders</span>
                </a>
                <a href="profile.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/20 transition">
                    <i class="fas fa-user-circle"></i>
                    <span>Profile</span>
                </a>
                <button onclick="logout()" class="w-full flex items-center space-x-3 p-3 rounded-lg hover:bg-white/20 transition text-left">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            <?php } else { ?>
                <a href="login.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/20 transition">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </a>
            <?php } ?>
        </nav>
    </div>
    
    <!-- Desktop Sidebar -->
    <div class="hidden md:block bg-gradient-to-b from-gray-50 to-gray-100 h-screen w-64 p-4 overflow-y-auto border-r border-gray-200">
        <h2 class="text-lg font-bold text-gray-800 mb-6">Categories</h2>
        <nav class="space-y-2">
            <a href="product.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-purple-100 transition text-gray-700">
                <i class="fas fa-list"></i>
                <span>All Products</span>
            </a>
            <?php 
            global $conn;
            $result = $conn->query("SELECT * FROM categories LIMIT 5");
            while ($cat = $result->fetch_assoc()) {
                echo '<a href="product.php?cat=' . $cat['id'] . '" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-purple-100 transition text-gray-700">';
                echo '<i class="fas fa-tag"></i>';
                echo '<span>' . htmlspecialchars($cat['name']) . '</span>';
                echo '</a>';
            }
            ?>
        </nav>
    </div>
</div>

<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden" onclick="toggleSidebar()"></div>
