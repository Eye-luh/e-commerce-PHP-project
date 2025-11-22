<?php

    include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <script src="https://cdn.tailwindcss.com"></script>
    <title>Adidadidadas</title>
</head>
<body>
    <div class="min-h-screen bg-gray-100 ">
        
        <div class="bg-gray-200 p-4">
            <div class="flex flex-col sm:flex-row justify-center items-center gap-3 sm:gap-6">
                
               
                <h1 class="text-2xl sm:text-4xl text-center font-bold">Adidadidadas</h1>
                
             
                <div class="w-full sm:w-auto flex justify-center">
                <input 
                    class="p-2 w-full sm:w-96 rounded border border-gray-400"
                    type="text" 
                    placeholder="Search for Product"
                >
                </div>
                
               
                <div class="bg-blue-500 rounded w-full sm:w-32 grid place-items-center mt-2 sm:mt-0">
                <a href="login.html" class="p-2 sm:p-4 text-white w-full sm:w-auto">Create/Login</a>
                </div>

            </div>
        </div>

        <div class="grid grid-flow-row p-4 place-items-center">
            <div class="flex w-full max-w-5xl border-b-2 border-gray-300 border-dashed">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <h1 class="cursor-pointer mb-4">Home</h1>

            </div>
           
           <div class="w-full max-w-6xl p-4 mx-auto">
                <?php

                $sql = "
                SELECT 
                p.product_name,
                p.price,
                p.image_path,
                c.categoryName,
                c.categoryDesc AS category_description
                FROM tbl_products AS p
                INNER JOIN tbl_categories AS c 
                ON p.category_id = c.category_id
                ORDER BY p.product_id DESC
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
                                <div class = "mt-2 flex gap-2">
                                    <button title = "Add to cart" class= "text-red-500 hover:text-red-700 "> 
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                        </svg>
                                    </button>
                                    <button title = "View Details" class = "text-blue-500 hover:text-blue-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                    </button>
                                </div>
                                
                            </div>
                        </div>
                        ';
                    }

                    echo '</div>'; // close grid container
                } else {
                    echo '<p class="text-gray-500 text-center">No products found.</p>';
                }

                mysqli_close($conn);
                ?>
                </div>



        </div>


    </div>
</body>
</html>