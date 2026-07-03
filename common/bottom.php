<?php if (!defined('INCLUDED')) { include __DIR__ . '/../config.php'; } ?>
<footer class="fixed md:static bottom-0 left-0 right-0 md:relative z-40 bg-gradient-to-r from-purple-900 to-pink-900 text-white">
    <!-- Mobile Bottom Nav -->
    <div class="md:hidden flex items-center justify-around py-3 border-t border-white/10">
        <a href="index.php" class="flex flex-col items-center space-y-1 text-xs">
            <i class="fas fa-home text-xl"></i>
            <span>Home</span>
        </a>
        <a href="product.php" class="flex flex-col items-center space-y-1 text-xs">
            <i class="fas fa-shopping-bag text-xl"></i>
            <span>Shop</span>
        </a>
        <a href="cart.php" class="flex flex-col items-center space-y-1 text-xs relative">
            <i class="fas fa-shopping-cart text-xl"></i>
            <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">0</span>
            <span>Cart</span>
        </a>
        <a href="<?php echo isLoggedIn() ? 'profile.php' : 'login.php'; ?>" class="flex flex-col items-center space-y-1 text-xs">
            <i class="fas fa-user text-xl"></i>
            <span><?php echo isLoggedIn() ? 'Profile' : 'Login'; ?></span>
        </a>
    </div>
    
    <!-- Desktop Footer -->
    <div class="hidden md:block py-12 px-6 border-t border-white/10">
        <div class="grid grid-cols-4 gap-8 mb-8">
            <div>
                <h4 class="font-bold mb-4">About</h4>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><a href="#" class="hover:text-white transition">About Us</a></li>
                    <li><a href="#" class="hover:text-white transition">Careers</a></li>
                    <li><a href="#" class="hover:text-white transition">Blog</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Support</h4>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><a href="#" class="hover:text-white transition">Contact Us</a></li>
                    <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                    <li><a href="#" class="hover:text-white transition">Shipping</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Legal</h4>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><a href="#" class="hover:text-white transition">Privacy</a></li>
                    <li><a href="#" class="hover:text-white transition">Terms</a></li>
                    <li><a href="#" class="hover:text-white transition">Cookies</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Follow</h4>
                <div class="flex space-x-4">
                    <a href="#" class="text-xl hover:text-pink-400 transition"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-xl hover:text-pink-400 transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-xl hover:text-pink-400 transition"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <div class="text-center text-sm text-gray-400 border-t border-white/10 pt-4">
            <p>&copy; 2024 Raja Brand. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Bottom padding for mobile -->
<div class="h-20 md:h-0"></div>
