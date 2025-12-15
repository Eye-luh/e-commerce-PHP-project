<?php

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
    <title>Add Product & Category</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="min-h-screen bg-gray-200 px-3 py-5 ">

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
