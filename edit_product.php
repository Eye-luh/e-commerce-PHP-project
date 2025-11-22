<?php
session_start();
include 'connection.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}


if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

 
    $sql = "
        SELECT 
            p.product_id,
            p.product_name,
            p.price,
            p.quantity,
            p.image_path,
            c.categoryName,
            c.categoryDesc
        FROM tbl_products AS p
        INNER JOIN tbl_categories AS c 
        ON p.category_id = c.category_id
        WHERE p.product_id = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('Product not found!'); window.location='dashboard.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('No product selected!'); window.location='dashboard.php';</script>";
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
<body >
   <div class="min-h-screen bg-gray-200 p-5 grid grid-flow-col grid-col-14 gap-4  ">

        <div class="col-span-1 ">
            <div class="bg-white  h-full rounded-2xl">
                <div class=" h-26 flex items-center justify-center flex-col">
                    <img class="w-16 mt-6 object-contain" src="uploads/LOGO.png" alt="Adidadidadas Shoes">
                    <h1 class="font-bold mt-2 text-xl">ADIDADIDADAS</h1>
                </div>
                <div class="flex justify-start flex-col gap-4 mt-4 items-center p-4">
                    <a href="dashboard.php" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition">
                            <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard">
                                <rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/>
                                <rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                                <h1 class="text-2xl ms-2 text-gray-500 group-hover:text-white transition">Dashboard</h1>
                    </a>
                   <a href="add_product.php" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition">
                            <svg 
                                class="text-blue-500 group-hover:text-white transition"
                                xmlns="http://www.w3.org/2000/svg" 
                                width="24" height="24" 
                                viewBox="0 0 24 24" 
                                fill="none" 
                                stroke="currentColor" 
                                stroke-width="2" 
                                stroke-linecap="round" 
                                stroke-linejoin="round"
                            >
                                <path d="M16 16h6"/><path d="M19 13v6"/><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/>
                                <path d="m7.5 4.27 9 5.15"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/>
                            </svg>

                            <h1 class="text-2xl ms-2 text-gray-500 group-hover:text-white transition">
                                Add Products
                            </h1>
                    </a>
                    <a href="update.html" class="group hover:bg-blue-500 p-3 rounded-xl mb-12 flex items-center w-full transition">
                           <svg class = "text-blue-500 group-hover:text-white transition" 
                           xmlns="http://www.w3.org/2000/svg" 
                           fill="none" 
                           viewBox="0 0 24 24" 
                           stroke-width="1.5" 
                           stroke="currentColor" 
                           width="24" height="24"
                           >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>


                            <h1 class="text-2xl ms-2 text-gray-500 group-hover:text-white transition">
                                Manage User
                            </h1>
                    </a>
                  
                    <a href="logout.php" class="group hover:bg-blue-500 mt-60  p-3 rounded-xl flex items-center w-full transition">
                            <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out">
                                <path d="m16 17 5-5-5-5"/>
                                <path d="M21 12H9"/>
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>


                            <h1 class="text-2xl ms-4  text-gray-500 group-hover:text-white transition">
                                Log Out
                            </h1>
                    </a>
                </div>
            </div>
        </div>
        <div class="bg-gray-200 rounded-2xl col-span-11  ">
           <div class="bg-white h-20 rounded-xl w-full p-2 flex justify-between items-center">
                <div class="ps-6 w-full">
                    <span>Welcome back!</span>
                  <?php
                     if (isset($_SESSION['username'])) {
                        $userName = $_SESSION['username'];

                        echo '<h1 class="text-2xl font-bold text-blue-500">' . htmlspecialchars($userName) . '</h1>';
                    }
                    ?>
                </div>
                <div class="flex justify-end items-center w-full p-4">
                    <div class="flex justify-center items-center gap-4">
                        <button class="border-2 border-blue-500 p-2 rounded-3xl">
                                <svg 
                                xmlns="http://www.w3.org/2000/svg" 
                                width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" 
                                 stroke="currentColor" stroke-width="2" 
                                 stroke-linecap="round" stroke-linejoin="round"
                                  class="text-blue-500 lucide lucide-bell-icon lucide-bell">
                                  <path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/></svg>
                        </button>
                        <button class="border-2 border-blue-500 p-2 rounded-3xl">
                            <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            width="24" height="24" 
                            viewBox="0 0 24 24" fill="none" 
                            stroke="currentColor" stroke-width="2" 
                            stroke-linecap="round" stroke-linejoin="round" 
                            class="text-blue-500 lucide lucide-settings-icon lucide-settings">
                            <path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"/>
                            <circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <div class="p-4 flex gap-2 items-center max-w-xs sm:max-w-sm md:max-w-md overflow-hidden">
                        <h1 class="text-3xl text-gray-400">|</h1>

                        <?php
                            if (isset($_SESSION['userType'])) {
                                $userType = $_SESSION['userType']; 
                                echo '
                                <div class="flex items-center gap-1 truncate">
                                 
                                    <h1 class="text-2xl text-gray-400 pt-1 truncate">' . htmlspecialchars($userType) . '</h1>
                                </div>';
                            }
                        ?>
                    </div>

                </div>
           </div>
           <div class="flex justify-center items-center mt-5 ">
            <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-3xl"> 
                    <h2 class="text-2xl font-bold mb-6 text-center">Edit Product</h2>

                    <form action="update_product.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">

                        <div>
                            <label class="block text-gray-700">Category Name</label>
                            <input type="text" name="category_name" value="<?php echo htmlspecialchars($row['categoryName']); ?>" required class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-gray-700">Category Description</label>
                            <input type="text" name="descCategoryName" value="<?php echo htmlspecialchars($row['categoryDesc']); ?>" required class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-gray-700">Product Name</label>
                            <input type="text" name="product_name" value="<?php echo htmlspecialchars($row['product_name']); ?>" required class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700">Price</label>
                                <input type="number" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" required class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700">Quantity</label>
                                <input type="number" name="quantity" value="<?php echo htmlspecialchars($row['quantity']); ?>" required class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700">Product Image</label>
                            <input type="file" name="product_image" accept="image/*" class="w-full">
                            <img src="<?php echo $row['image_path']; ?>" class="mt-2 w-16 h-16 object-cover rounded">
                        </div>

                        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">
                            Update
                        </button>
                    </form>
                </div>
           </div>
        </div>
    </div>
   
</body>
</html>