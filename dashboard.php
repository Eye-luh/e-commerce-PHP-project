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
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dahsboard</title>
</head>
<body>

    <!-- FIXED MAIN GRID -->
    <div class="min-h-screen bg-gray-200 p-5 grid grid-cols-1 md:grid-cols-14 gap-4">

        <!-- SIDEBAR -->
        <div class="col-span-1 md:col-span-1">
            <div class="bg-white h-full rounded-2xl">
                <div class="h-26 flex items-center justify-center flex-col">
                    <img class="w-16 mt-6 object-contain" src="uploads/LOGO.png" alt="Adidadidadas Shoes">
                    <h1 class="font-bold mt-2 text-xl">ADIDADIDADAS</h1>
                </div>
                <div class="flex justify-start flex-col gap-4 mt-4 items-center p-4">
                    <a href="dashboard.php" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition">
                        <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="7" height="9" x="3" y="3" rx="1"/>
                            <rect width="7" height="5" x="14" y="3" rx="1"/>
                            <rect width="7" height="9" x="14" y="12" rx="1"/>
                            <rect width="7" height="5" x="3" y="16" rx="1"/>
                        </svg>
                        <h1 class="text-2xl ms-2 text-gray-500 group-hover:text-white transition">Dashboard</h1>
                    </a>

                    <a href="add_product.php" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition">
                        <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 16h6"/><path d="M19 13v6"/><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/>
                            <path d="m7.5 4.27 9 5.15"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/>
                        </svg>
                        <h1 class="text-2xl ms-2 text-gray-500 group-hover:text-white transition">Add Products</h1>
                    </a>

                    <a href="update.html" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition">
                        <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        <h1 class="text-2xl ms-2 text-gray-500 group-hover:text-white transition">Manage User</h1>
                    </a>

                    <a href="logout.php" class="group hover:bg-blue-500 mt-60 p-3 rounded-xl flex items-center w-full transition">
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
        <div class="bg-gray-200 rounded-2xl col-span-1 md:col-span-11">

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

            <!-- FIXED CARDS (GRID ON MOBILE) -->
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

            <!-- PRODUCT GRID (already responsive) -->
            <div id="contentArea" class="w-full max-w-14xl p-4 mx-auto">
                <div class="w-full max-w-6xl p-4 mx-auto">
                    <?php
                        include 'connection.php';
                        $sql = "
                        SELECT 
                        p.product_name,
                        p.price,
                        p.product_id,
                        p.image_path,
                        c.categoryName,
                        c.categoryDesc AS category_description
                        FROM tbl_products AS p
                        INNER JOIN tbl_categories AS c 
                        ON p.category_id = c.category_id
                        ORDER BY p.product_id DESC LIMIT 4
                        ";

                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            echo '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">';

                            while ($row = mysqli_fetch_assoc($result)) {
                                $imagePath = htmlspecialchars($row['image_path']);

                                echo '
                                <div class="bg-white rounded-lg shadow hover:shadow-lg transition duration-300 overflow-hidden">
                                    <img src="' . $imagePath . '" alt="' . htmlspecialchars($row['product_name']) . '" 
                                        class="w-full h-48 object-cover">
                                    
                                    <div class="p-4">
                                        <h2 class="text-xl font-bold text-gray-800 mb-1">' . htmlspecialchars($row['product_name']) . '</h2>
                                        <p class="text-gray-600 font-semibold mb-1">₱' . number_format($row['price'], 2) . '</p>
                                        <p class="text-gray-500 text-sm"><span class="font-semibold">Category:</span> ' . htmlspecialchars($row['categoryName']) . '</p>
                                        <p class="text-gray-400 text-sm mt-1">' . htmlspecialchars($row['category_description']) . '</p>

                                        <div class="mt-2">
                                            <h1>Action</h1>
                                            <div class="flex gap-2">
                                                <a href="edit_product.php?id=' . $row['product_id'] . '" class="text-black" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </a>

                                                <a href="delete_product.php?id=' . $row['product_id'] . '" class="text-red-500 hover:text-red-700" title="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>';
                            }

                            echo '</div>';
                        } else {
                            echo '<p class="text-gray-500 text-center">No products found.</p>';
                        }

                        mysqli_close($conn);
                    ?>
                </div>
            </div>

        </div>

    </div>
</body>
</html>
