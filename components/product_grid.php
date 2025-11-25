<?php


if (!isset($limit)) {
    $limit = null; // null = show all products
}
if (!isset($show_actions)) {
    $show_actions = false; 
}
if (!isset($show_add_to_cart)) {
    $show_add_to_cart = false; 
}
if (!isset($search_query)) {
    $search_query = ''; 
}

$sql = "
SELECT 
p.product_id,
p.product_name,
p.price,
p.quantity,
p.image_path,
c.categoryName,
c.categoryDesc AS category_description
FROM tbl_products AS p
INNER JOIN tbl_categories AS c 
ON p.category_id = c.category_id
";

// Add search filter if user searched for products
if (!empty($search_query)) {
    $sql .= "WHERE p.product_name LIKE '%" . mysqli_real_escape_string($conn, $search_query) . "%' ";
    $sql .= "OR c.categoryName LIKE '%" . mysqli_real_escape_string($conn, $search_query) . "%' ";
    $sql .= "OR CAST(p.price AS CHAR) LIKE '%" . mysqli_real_escape_string($conn, $search_query) . "%' ";
}

// Sort sa mga new products
$sql .= "ORDER BY p.product_id DESC";

// Limit results if specified (used by admin dashboard)
if ($limit) {
    $sql .= " LIMIT " . intval($limit);
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">';

    while ($row = mysqli_fetch_assoc($result)) {
        $imagePath = htmlspecialchars($row['image_path']);
        $productId = intval($row['product_id']);
        $productName = htmlspecialchars($row['product_name']);
        $categoryName = htmlspecialchars($row['categoryName']);
        $categoryDesc = htmlspecialchars($row['category_description']);
        $price = number_format($row['price'], 2);

        echo '
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition duration-300 overflow-hidden">
            <img src="' . $imagePath . '" alt="' . $productName . '" 
                class="w-full h-40 sm:h-48 object-cover">
            
            <div class="p-3 sm:p-4">
                <h2 class="text-base sm:text-lg font-bold text-gray-800 mb-2">' . $productName . '</h2>
                <p class="text-gray-600 font-semibold mb-2 text-lg">₱' . $price . '</p>
                <p class="text-gray-500 text-xs sm:text-sm"><span class="font-semibold">Category:</span> ' . $categoryName . '</p>
                <p class="text-gray-400 text-xs sm:text-sm mt-1 line-clamp-2">' . $categoryDesc . '</p>
                <div class="mt-3 flex gap-2">';

        if ($show_add_to_cart) {
            echo '
                    <button title="Add to cart" onclick="addToCart(' . $productId . ')" class="text-red-500 hover:text-red-700 p-2 rounded transition"> 
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 sm:size-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                    </button>
                    <button title="View Details" class="text-blue-500 hover:text-blue-700 p-2 rounded transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 sm:size-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>';
        }

        if ($show_actions) {
            if (isset($_SESSION['userType']) && strtolower($_SESSION['userType']) === 'admin') {
                echo '
                    <a href="edit_product.php?id=' . $productId . '" class="text-black hover:text-blue-700 p-2 rounded transition" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 sm:size-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                    </a>

                    <a href="delete_product.php?id=' . $productId . '" class="text-red-500 hover:text-red-700 p-2 rounded transition" title="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 sm:size-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </a>';
            }
        }

        echo '
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
