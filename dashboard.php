<?php
    session_start();
    include 'connection.php';
    if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
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
                     <?php if (isset($_SESSION['userType']) && (strtolower($_SESSION['userType']) !== 'admin' && strtolower($_SESSION['userType']) !== 'staff')) : ?>
                        <a href="index.php" class="sidebar-btn flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700/50">
                            <i class="fas fa-box text-lg"></i>
                            <span>Shop</span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['userType']) && strtolower($_SESSION['userType']) === 'admin' || strtolower($_SESSION['userType']) === 'staff') :  ?>
                        <a href="?content=add_product" class="sidebar-btn flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700/50">
                            <i class="fas fa-shopping-cart text-lg"></i>
                            <span>Add Product</span>
                        
                        </a>
                         <a href="?content=manage_product" class="sidebar-btn flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700/50">
                            <i class="fas fa-shopping-cart text-lg"></i>
                            <span>Manage Product</span>
                        
                        </a>
                        <a href="?content=user_log" class="sidebar-btn flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700/50">
                           <i class="fa-solid fa-user text-lg"></i>
                            <span>User Log</span>
                        
                        </a>
                    <?php else : ?>
                        <a href="?content=history" class="sidebar-btn flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700/50">
                            <i class="fas fa-shopping-cart text-lg"></i>
                            <span>History</span>
                        
                        </a>
                        <a href="?content=cart" class="sidebar-btn flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700/50">
                            <i class="fas fa-shopping-cart text-lg"></i>
                            <span>Cart</span>
                        
                        </a>
                        <a href="?content=edit_profile" class="sidebar-btn flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700/50">
                            <i class="fa-solid fa-pen-to-square text-lg"></i>
                            <span>Edit Profile</span>
                        
                        </a>

                    <?php endif; ?>

                    <?php if (isset($_SESSION['userType']) && strtolower($_SESSION['userType']) === 'admin'): ?>
                    <a href="#" class="sidebar-btn flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700/50">
                        <i class="fas fa-cog text-lg"></i>
                        <span>Settings</span>
                    </a>
                    <?php else :?>
                        <a href="#" class="sidebar-btn flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-700/50">
                        <i class="fas fa-cog text-lg"></i>
                        <span>Account Settings</span>
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
           <?php if(isset($_SESSION['userType']) && strtolower($_SESSION['userType']) === 'admin' || strtolower($_SESSION['userType']) === 'staff') :?>

                    <?php include './components/header-dashboard.php'?>

            <?php endif ; ?>
           

           

            <!--ge change Main content area nag gi-add og border ug shadow -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                

                <!-- Product Grid-->
                <div id="contentArea">
                    <?php

                        if(isset($_GET['content'])){
                            $content = $_GET['content'];
                            if($content === 'add_product'){
                                include './add_product.php';
                            }elseif($content === 'cart'){
                                include './cart.php';
                            }elseif($content === 'history'){
                                include './order_history.php';
                            }elseif($content === 'edit_profile'){
                                include './customer_info.php';
                            }

                           
                            
                        }
                        else{
                                 $limit = isset($_SESSION['userType']) && strtolower($_SESSION['userType']) === 'admin' ? 4 : null;
                                $show_actions = isset($_SESSION['userType']) && strtolower($_SESSION['userType']) === 'admin' ? true : false;
                                $show_add_to_cart = isset($_SESSION['userType']) && strtolower($_SESSION['userType']) !== 'admin' ? true : false;
                                $search_query = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
                                include './order_history.php';
                            }
                      
                    ?>
                </div>
               

               


            </div>

            <!-- Nag add ug Footer -->
            
        </div>
        
    </div>
    <footer class="bg-gray-900 text-white  pt-8 pb-8">
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