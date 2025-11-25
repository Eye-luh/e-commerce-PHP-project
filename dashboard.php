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
    <title>Dashboard</title>
</head>
<body>

    <!-- FIXED MAIN GRID --> 
    <div class="min-h-screen bg-gray-200 px-3 py-5 grid grid-cols-1 md:grid-cols-12 gap-4">

        <!-- SIDEBAR -->
        <div class="col-span-1 md:col-span-2">
            <div class="bg-white h-full rounded-2xl flex flex-col">

                <div class="h-26 flex items-center justify-center flex-col">
                    <img class="w-16 mt-6 object-contain" src="uploads/LOGO.png" alt="Adidadidadas Shoes">
                    <h1 class="font-bold mt-2 text-xl">ADIDADIDADAS</h1>
                </div>

                        <div class="flex flex-col gap-4 mt-4 items-center p-4">
            <a href="dashboard.php" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition">
                <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="7" height="9" x="3" y="3" rx="1"/>
                    <rect width="7" height="5" x="14" y="3" rx="1"/>
                    <rect width="7" height="9" x="14" y="12" rx="1"/>
                    <rect width="7" height="5" x="3" y="16" rx="1"/>
                </svg>
                <h1 class="text-2xl ms-2 text-gray-500 group-hover:text-white transition">Shop</h1>
            </a>

            <a href="cart.php" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition">
                <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24" height="24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
                <h1 class="text-2xl ms-2 text-gray-500 group-hover:text-white transition">Cart</h1>
            </a>

            <?php if (isset($_SESSION['userType']) && strtolower($_SESSION['userType']) === 'admin'): ?>
            <a href="add_product.php" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition">
                <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 16h6"/><path d="M19 13v6"/><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/>
                    <path d="m7.5 4.27 9 5.15"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/>
                </svg>
                <h1 class="text-2xl ms-2 text-gray-500 group-hover:text-white transition">Add Products</h1>
            </a>

            <a href="manage_users.php" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition">
                <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24" height="24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.657-.671-3.157-1.76-4.233m2.76 4.233l.812 2.582m-4.572-8.725a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-9 6.75c1.657 0 3.157.671 4.233 1.76.985.99 1.644 2.338 1.821 3.721H3.75a4.125 4.125 0 0 1 4.275-5.481Zm0 0s3.063-.669 4.275-1.481" />
                </svg>
                <h1 class="text-2xl ms-2 text-gray-500 group-hover:text-white transition">Manage User</h1>
            </a>
            <?php endif; ?>
        </div>

        <!-- Logout button at the bottom -->
        <div class="mt-auto p-4 w-full">
            <a href="logout.php" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition">
                <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m16 17 5-5-5-5"/>
                    <path d="M21 12H9"/>
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                </svg>
                <h1 class="text-2xl ms-4 text-gray-500 group-hover:text-white transition">Log Out</h1>
            </a>
        </div>
    </div>
</div>

        <!-- MAIN CONTENT -->
        <div class="bg-gray-200 rounded-2xl col-span-1 md:col-span-10">
            <!-- Search Bar -->
            <div class="bg-white rounded-xl w-full p-4 mb-4">
                <form method="GET" class="flex gap-2">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search products..." 
                        value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>"
                        class="flex-1 px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500 outline-none text-base"
                    >
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition font-semibold">
                        Search
                    </button>
                    <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                    <a href="dashboard.php" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 transition font-semibold">
                        Clear
                    </a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="bg-white h-20 rounded-xl w-full p-2 flex justify-between items-center">
                <div class="ps-6 w-full">
                    <span>Welcome back!</span>
                    <?php
                        if (isset($_SESSION['username'])) {
                            echo '<h1 class="text-2xl font-bold text-blue-500">' . htmlspecialchars($_SESSION['username']) . '</h1>';
                        }
                    ?>
                </div>

                <div class="flex justify-end items-center w-full p-4">
                    <div class="flex justify-center items-center gap-4">
                        <button class="border-2 border-blue-500 p-2 rounded-3xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/>
                            </svg>
                        </button>

                        <button class="border-2 border-blue-500 p-2 rounded-3xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>

                    <div class="p-4 flex gap-2 items-center max-w-xs sm:max-w-sm md:max-w-md overflow-hidden">
                        <h1 class="text-3xl text-gray-400">|</h1>
                        <?php
                            if (isset($_SESSION['userType'])) {
                                echo '<div class="flex items-center gap-1 truncate">
                                        <h1 class="text-2xl text-gray-400 pt-1 truncate">' . htmlspecialchars($_SESSION['userType']) . '</h1>
                                      </div>';
                            }
                        ?>
                    </div>
                </div>
            </div>

            <!-- ADMIN STATS (only visible to admins) -->
            <?php if (isset($_SESSION['userType']) && strtolower($_SESSION['userType']) === 'admin'): ?>
            <div class="w-full py-4 mt-4 rounded-xl grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <div class="w-full bg-white rounded-xl p-4">
                    <h1 class="text-xl font-semibold">Total Products</h1>
                    <h1 class="text-4xl text-blue-400 font-semibold">120,000</h1>
                </div>

                <div class="w-full bg-white rounded-xl p-4">
                    <h1 class="text-xl font-semibold">Total Products Sold</h1>
                    <h1 class="text-4xl text-blue-400 font-semibold">15000</h1>
                </div>

                <div class="w-full bg-white rounded-xl p-4">
                    <h1 class="text-2xl font-semibold">Total Sales</h1>
                    <h1 class="text-4xl text-blue-400 flex items-center font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.31m5.582 3.531A9 9 0 1 1 12 3a9 9 0 0 1 9 9Z" />
                        </svg>
                        500,000.00
                    </h1>
                </div>
            </div>
            <?php endif; ?>

            <!-- PRODUCT GRID -->
            <div id="contentArea" class="w-full max-w-14xl p-4 mx-auto">
                <div class="w-full max-w-6xl p-4 mx-auto">
                    <h2 class="text-2xl font-bold mb-4 text-gray-800">
                        <?php 
                            $title = (isset($_SESSION['userType']) && strtolower($_SESSION['userType']) === 'admin') ? 'Manage Products' : 'Shop Now';
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $title .= ' - "' . htmlspecialchars($_GET['search']) . '"';
                            }
                            echo $title;
                        ?>
                    </h2>
                    <?php
                        $limit = isset($_SESSION['userType']) && strtolower($_SESSION['userType']) === 'admin' ? 4 : null;
                        $show_actions = isset($_SESSION['userType']) && strtolower($_SESSION['userType']) === 'admin' ? true : false;
                        $show_add_to_cart = isset($_SESSION['userType']) && strtolower($_SESSION['userType']) !== 'admin' ? true : false;
                        $search_query = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
                        include 'components/product_grid.php';
                    ?>
                </div>
            </div>

        </div>

    </div>

    <script>
        function addToCart(productId) {
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
                    alert('✅ Product added to cart! (Qty: ' + data.item_qty + ')');
                } else {
                    alert('❌ Error: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to add product to cart');
            });
        }
    </script>
</body>
</html>
