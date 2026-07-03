<?php if (!defined('INCLUDED')) { include __DIR__ . '/../config.php'; } ?>
<header class="sticky top-0 z-50 backdrop-blur-xl bg-white/10 border-b border-white/10">
    <div class="flex items-center justify-between px-4 py-3 md:px-6">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-crown text-white text-lg"></i>
            </div>
            <span class="text-lg md:text-2xl font-bold bg-gradient-to-r from-purple-500 to-pink-500 bg-clip-text text-transparent">Raja</span>
        </div>
        
        <!-- Search Bar (Desktop) -->
        <div class="hidden md:flex flex-1 mx-6">
            <input type="text" placeholder="Search products..." class="w-full px-4 py-2 rounded-lg bg-white/10 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>
        
        <!-- Right Menu -->
        <div class="flex items-center space-x-4 md:space-x-6">
            <?php if (isLoggedIn()) { ?>
                <a href="cart.php" class="relative text-gray-600 hover:text-purple-500 transition md:text-lg">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                </a>
                <a href="profile.php" class="text-gray-600 hover:text-purple-500 transition md:text-lg">
                    <i class="fas fa-user"></i>
                </a>
            <?php } else { ?>
                <a href="login.php" class="text-gray-600 hover:text-purple-500 transition md:text-lg">
                    <i class="fas fa-sign-in-alt"></i>
                </a>
            <?php } ?>
            
            <!-- Mobile Menu Toggle -->
            <button class="md:hidden text-gray-600 hover:text-purple-500 transition" onclick="toggleSidebar()">
                <i class="fas fa-bars text-lg"></i>
            </button>
        </div>
    </div>
</header>
