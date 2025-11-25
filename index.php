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
            <div class="flex flex-col gap-4 w-full">
                
               
                <h1 class="text-3xl sm:text-4xl text-center font-bold">Adidadidadas</h1>
                
             
                <div class="w-full flex justify-center">
                <input 
                    class="p-3 w-full sm:w-96 rounded border border-gray-400 text-base"
                    type="text" 
                    placeholder="Search for Product"
                >
                </div>
                
               
                <div class="flex gap-3 justify-center">
                    <div class="bg-blue-500 rounded px-6 py-3 grid place-items-center">
                        <a href="cart.php" class="text-white font-semibold text-lg">Cart</a>
                    </div>
                    <div class="bg-blue-500 rounded px-6 py-3 grid place-items-center">
                        <a href="login.html" class="text-white font-semibold text-lg">Create/Login</a>
                    </div>
                </div>

            </div>
        </div>

        <div class="grid grid-flow-row p-4 place-items-center w-full">
            <div class="flex w-full max-w-6xl border-b-2 border-gray-300 border-dashed items-center gap-2 mb-4">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <h1 class="cursor-pointer text-lg font-semibold">Home</h1>

            </div>
           
           <div class="w-full max-w-6xl p-2 sm:p-4 mx-auto">
                <?php
                $show_add_to_cart = true;
                include 'components/product_grid.php';
                ?>
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