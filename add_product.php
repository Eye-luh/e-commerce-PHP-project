<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
if (isset($_SESSION['userType']) && strtolower($_SESSION['userType']) !== 'admin') {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product & Category</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
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
                    <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="7" height="9" x="3" y="3" rx="1"/>
                        <rect width="7" height="5" x="14" y="3" rx="1"/>
                        <rect width="7" height="9" x="14" y="12" rx="1"/>
                        <rect width="7" height="5" x="3" y="16" rx="1"/>
                    </svg>
                    <h1 class="text-2xl ms-2 text-gray-500 group-hover:text-white transition">Dashboard</h1>
                </a>

                <a href="add_product.php" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition">
                    <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 16h6"/><path d="M19 13v6"/><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/>
                        <path d="m7.5 4.27 9 5.15"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/>
                    </svg>
                    <h1 class="text-2xl ms-2 text-gray-500 group-hover:text-white transition">Add Products</h1>
                </a>

                <a href="manage_users.php" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition">
                    <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10 15H6a4 4 0 0 0-4 4v2"/>
                        <path d="m14.305 16.53.923-.382"/>
                        <path d="m15.228 13.852-.923-.383"/>
                        <path d="m16.852 12.228-.383-.923"/>
                        <path d="m16.852 17.772-.383.924"/>
                        <path d="m19.148 12.228.383-.923"/>
                        <path d="m19.53 18.696-.382-.924"/>
                        <path d="m20.772 13.852.924-.383"/>
                        <path d="m20.772 16.148.924.383"/>
                        <circle cx="18" cy="15" r="3"/>
                        <circle cx="9" cy="7" r="4"/>
                    </svg>
                    <h1 class="text-2xl ms-2 text-gray-500 group-hover:text-white transition">Manage User</h1>
                </a>
            </div>

            <!-- Logout button at the bottom -->
            <div class="mt-auto p-4 w-full">
                <a href="logout.php" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition">
                    <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
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
                            <path d="M10.268 21a2 2 0 0 0 3.464 0"/>
                            <path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/>
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

        <!-- ADD PRODUCT FORM -->
        <div class="flex justify-center items-center mt-10">
            <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-3xl">
                <h2 class="text-2xl font-bold mb-6 text-center">Add Product</h2>

                <form action="add_product.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                 
                    <div>
                        <label class="block text-gray-700">Category Name</label>
                        <input type="text" name="category_name" required class="w-full px-3 py-2 border rounded outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700">Category Description</label>
                        <input type="text" name="descCategoryName" required class="w-full px-3 py-2 border rounded outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                  
                    <div>
                        <label class="block text-gray-700">Product Name</label>
                        <input type="text" name="product_name" required class="w-full px-3 py-2 border rounded outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700">Price</label>
                            <input type="number" name="price" required class="w-full px-3 py-2 border rounded outline-none focus:ring-2 focus:ring-blue-500 no-spinners">
                        </div>
                        <div>
                            <label class="block text-gray-700">Quantity</label>
                            <input type="number" name="quantity" required class="w-full px-3 py-2 border rounded outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700">Product Image</label>
                        <input type="file" name="product_image" accept="image/*" required class="w-full">
                        <img id="preview" class="mt-2 w-32 h-32 object-cover rounded" style="display:none;">
                    </div>

                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $category_name = $_POST['category_name'];
    $descCategoryName = $_POST['descCategoryName'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $targetDir = "uploads/";
    $fileName = basename($_FILES["product_image"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFilePath)) {
        $sql_category = "INSERT INTO tbl_categories (categoryName, categoryDesc) VALUES (?, ?)";
        $stmt_cat = $conn->prepare($sql_category);
        $stmt_cat->bind_param("ss", $category_name, $descCategoryName);

        if ($stmt_cat->execute()) {
            $category_id = $conn->insert_id;
            $sql_product = "INSERT INTO tbl_products (product_name, price, quantity, image_path, category_id) VALUES (?, ?, ?, ?, ?)";
            $stmt_prod = $conn->prepare($sql_product);
            $stmt_prod->bind_param("sdiss", $product_name, $price, $quantity, $targetFilePath, $category_id);

            if ($stmt_prod->execute()) {
                echo "<script>alert('Product added successfully!'); window.location='dashboard.php';</script>";
            } else {
                echo "<script>alert('Failed to insert product.');</script>";
            }
        } else {
            echo "<script>alert('Failed to insert category.');</script>";
        }
    } else {
        echo "<script>alert('Image upload failed.');</script>";
    }
}
?>
</body>
</html>
