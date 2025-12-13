<?php
    session_start();
    include 'connection.php';
    if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- GI ADD: Font Awesome icons para parehas sa index.php -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Dashboard - Adidadidadas</title>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); /* Same gradient sa index.php */
        }
        .sidebar-btn {
            transition: all 0.3s ease;
        }
        .sidebar-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); /* Hover effect parehas sa index.php */
        }
        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            height: 8px;
            width: 8px;
            background-color: #ef4444;
            border-radius: 50%;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

     
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-12 gap-0">

        <!-- Ge change ang Sidebar design gihimo nga gradient ug naay icons -->
        <!--from bg-gray-200, walay icons to gradient background with icons-->
        
        <div class="lg:col-span-2 bg-gradient-to-b from-purple-800 to-purple-900 text-white">
            <div class="p-6">
               
                <div class="flex items-center gap-3 mb-10">
                    <?php
                    $logo_path = 'uploads/LOGO.png';
                    if (file_exists($logo_path)) {
                        echo '<img src="' . $logo_path . '" alt="Adidadidadas Logo" class="h-10 w-auto rounded-lg border-2 border-white shadow-lg">';
                    }
                    ?>
                    <h1 class="text-xl font-bold">Adidadidadas</h1>
                </div>

                <!-- ge chaneg ang Navigation design nag add og icons ug hover effects -->
                <nav class="space-y-2">
                    <a href="dashboard.php" class="sidebar-btn flex items-center gap-3 px-4 py-3 rounded-lg bg-purple-700">
                        <i class="fas fa-home text-lg"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="sidebar-btn flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700/50">
                        <i class="fas fa-box text-lg"></i>
                        <span>Shop</span>
                    </a>
                    <a href="cart.php" class="sidebar-btn flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700/50">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span>Cart</span>
                        <!-- Nag add ug Cart badge -->
                        <span class="ml-auto bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                    </a>
                    <?php if (isset($_SESSION['userType']) && strtolower($_SESSION['userType']) === 'admin'): ?>
                    <a href="#" class="sidebar-btn flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700/50">
                        <i class="fas fa-cog text-lg"></i>
                        <span>Settings</span>
                    </a>
                    <?php endif; ?>
                    <a href="logout.php" class="sidebar-btn flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-600/20 mt-8">
                        <i class="fas fa-sign-out-alt text-lg"></i>
                        <span>Logout</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-10 p-6">
            <!-- ge change ang Top Bar design -->
            <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <!-- Welcome section  -->
                    <div class="flex-1">
                        <div class="text-gray-600">Welcome back!</div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            <?php
                                if (isset($_SESSION['username'])) {
                                    echo htmlspecialchars($_SESSION['username']);
                                }
                            ?>
                        </h1>
                    </div>

                    <!-- ge change ang Search Bar -->
                    <!-- Input with search icon ug gradient button -->
                    <div class="flex-1 max-w-xl">
                        <form method="GET" class="relative">
                            <input 
                                type="text" 
                                name="search" 
                                placeholder="Search products..." 
                                value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-gray-50 text-gray-800 transition duration-300"
                            >
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-purple-600 to-pink-500 text-white px-4 py-1.5 rounded-lg hover:from-purple-700 hover:to-pink-600 transition-all duration-300 text-sm font-medium">
                                Search
                            </button>
                        </form>
                    </div>

                    <!-- ge change ang  User Actions area  -->
                    <div class="flex items-center gap-4">
            
                        <a href="cart.php" class="relative bg-gradient-to-r from-purple-600 to-pink-500 text-white px-6 py-3 rounded-full font-semibold flex items-center gap-2 hover:from-purple-700 hover:to-pink-600 transition-all duration-300">
                            <i class="fas fa-shopping-cart"></i>
                            Cart
                            <span class="bg-white text-purple-600 text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                        </a>

                        <!-- ge change ang Notification button nag add og icon -->
                        
                        <button class="relative p-3 rounded-full hover:bg-gray-100 transition">
                            <i class="fas fa-bell text-gray-600 text-xl"></i>
                            <span class="notification-badge"></span>
                        </button>

                        
                        <!-- ge change into  Avatar circle with user initial ang user info-->
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 bg-gradient-to-r from-purple-600 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                <?php
                                    if (isset($_SESSION['username'])) {
                                        echo strtoupper(substr(htmlspecialchars($_SESSION['username']), 0, 1));
                                    }
                                ?>
                            </div>
                            <div class="hidden md:block">
                                <div class="font-medium text-gray-800"><?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></div>
                                <div class="text-sm text-purple-600 font-medium"><?php echo htmlspecialchars($_SESSION['userType'] ?? ''); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clear Search -->
                <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                <div class="mt-4 flex justify-end">
                    <a href="dashboard.php" class="inline-flex items-center gap-2 text-sm text-purple-600 hover:text-purple-800 font-medium">
                        <i class="fas fa-times"></i>
                        Clear Search
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- ADMIN STATS cards nag add og icons ug hover effects -->

            <?php if (isset($_SESSION['userType']) && strtolower($_SESSION['userType']) === 'admin'): ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-600 font-medium">Total Products</div>
                            <div class="text-3xl font-bold text-gray-800 mt-2">120,000</div>
                        </div>
                        <div class="bg-blue-50 p-3 rounded-full">
                            <i class="fas fa-box text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-600 font-medium">Products Sold</div>
                            <div class="text-3xl font-bold text-gray-800 mt-2">15,000</div>
                        </div>
                        <div class="bg-green-50 p-3 rounded-full">
                            <i class="fas fa-chart-line text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-600 font-medium">Total Sales</div>
                            <div class="text-3xl font-bold text-gray-800 mt-2">₱500,000</div>
                        </div>
                        <div class="bg-purple-50 p-3 rounded-full">
                            <i class="fas fa-coins text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!--ge change Main content area nag gi-add og border ug shadow -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <!-- Title -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">
                        <?php 
                            $title = (isset($_SESSION['userType']) && strtolower($_SESSION['userType']) === 'admin') ? 'Manage Products' : 'Shop Now';
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $title .= ' - "' . htmlspecialchars($_GET['search']) . '"';
                            }
                            echo $title;
                        ?>
                    </h2>
                    <p class="text-gray-600">
                        <?php
                            if (isset($_SESSION['userType']) && strtolower($_SESSION['userType']) === 'admin') {
                                echo 'Manage your products and inventory';
                            } else {
                                echo 'Browse our latest collection';
                            }
                        ?>
                    </p>
                </div>

                <!-- Product Grid-->
                <div id="contentArea">
                    <?php
                        $limit = isset($_SESSION['userType']) && strtolower($_SESSION['userType']) === 'admin' ? 4 : null;
                        $show_actions = isset($_SESSION['userType']) && strtolower($_SESSION['userType']) === 'admin' ? true : false;
                        $show_add_to_cart = isset($_SESSION['userType']) && strtolower($_SESSION['userType']) !== 'admin' ? true : false;
                        $search_query = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
                        include 'components/product_grid.php';
                    ?>
                </div>

                <!-- Nag add ug View All Button para sa non-admin users -->
                <?php if (isset($_SESSION['userType']) && strtolower($_SESSION['userType']) !== 'admin'): ?>
                <div class="mt-8 text-center">
                    <a href="index.php" class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white px-6 py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-pink-600 transition-all duration-300">
                        <i class="fas fa-store"></i>
                        View All Products
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Nag add ug Footer -->
            <footer class="bg-gray-900 text-white mt-12 pt-8 pb-8">
                <div class="container mx-auto px-4">
                    <div class="text-center">
                        <p class="text-gray-400">&copy; 2025 Adidadidadas. Premium footwear and apparel.</p>
                        <div class="flex justify-center gap-6 mt-4">
                            <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Nag add  ug Notification system parehas sa index.php -->
    <script>
        function addToCart(productId) {
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            button.disabled = true;
            
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    qty: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // nag add ug Notification parehas sa index.php
                    showNotification('Product added to cart!', 'success');
                    // Update ang cart badges
                    const cartBadges = document.querySelectorAll('.bg-red-500, .bg-white.text-purple-600');
                    cartBadges.forEach(badge => {
                        const currentCount = parseInt(badge.textContent) || 0;
                        badge.textContent = currentCount + 1;
                    });
                } else {
                    showNotification('Error: ' + data.error, 'error');
                }
                button.innerHTML = originalText;
                button.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Failed to add product to cart', 'error');
                button.innerHTML = originalText;
                button.disabled = false;
            });
        }
        
        // nag add Notification function parehas sa index.php
        function showNotification(message, type) {
            // 
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Mawa human sa 3 seconds (Removes after 3 seconds)
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
</body>
</html>