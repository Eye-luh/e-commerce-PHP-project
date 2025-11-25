<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cartItems = $_SESSION['cart'];
$total = 0;

// mag dteremine kung asa siya na page mo direct after logged, mag depende sa iya role
$backUrl = isset($_SESSION['user_id']) ? 'dashboard.php' : 'index.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Shopping Cart</title>
</head>
<body>
    <div class="min-h-screen bg-gray-100">
        <!-- Header -->
        <div class="bg-gray-200 p-4">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-3 sm:gap-6">
                <div class="flex items-center gap-4 w-full sm:w-auto">
                    <a href="<?php echo $backUrl; ?>" class="text-xl font-bold text-gray-800 hover:text-blue-500">
                        ← Back to Shop
                    </a>
                    <h1 class="text-2xl sm:text-4xl font-bold">Adidadidadas</h1>
                </div>
                <div class="flex items-center gap-4">
                    <a href="cart.php" class="text-blue-500 font-semibold">
                        Cart (<?php echo count($cartItems); ?>)
                    </a>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                    <div class="bg-blue-500 rounded px-4 py-2">
                        <a href="login.html" class="text-white">Login</a>
                    </div>
                    <?php else: ?>
                    <div class="bg-blue-500 rounded px-4 py-2">
                        <a href="logout.php" class="text-white">Logout</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-6xl mx-auto p-4">
            <h2 class="text-3xl font-bold mb-6">Shopping Cart</h2>

            <?php if (count($cartItems) === 0): ?>
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <p class="text-xl text-gray-600 mb-4">Your cart is empty</p>
                    <a href="<?php echo $backUrl; ?>" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                        Continue Shopping
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow overflow-x-auto">
                            <table class="w-full text-sm sm:text-base">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="px-2 sm:px-4 py-3 text-left">Product</th>
                                        <th class="px-2 sm:px-4 py-3 text-center">Price</th>
                                        <th class="px-2 sm:px-4 py-3 text-center">Qty</th>
                                        <th class="px-2 sm:px-4 py-3 text-center">Subtotal</th>
                                        <th class="px-2 sm:px-4 py-3 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cartItems as $product_id => $item): 
                                        $subtotal = $item['price'] * $item['qty'];
                                        $total += $subtotal;
                                    ?>
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="px-2 sm:px-4 py-3 font-semibold text-xs sm:text-base"><?php echo htmlspecialchars($item['name']); ?></td>
                                            <td class="px-2 sm:px-4 py-3 text-center text-xs sm:text-base">₱<?php echo number_format($item['price'], 2); ?></td>
                                            <td class="px-2 sm:px-4 py-3">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button 
                                                        class="bg-gray-300 px-3 py-2 sm:px-2 sm:py-1 rounded hover:bg-gray-400 text-sm" 
                                                        onclick="updateQty(<?php echo $product_id; ?>, -1)">
                                                        -
                                                    </button>
                                                    <span id="qty-<?php echo $product_id; ?>" class="w-6 sm:w-8 text-center text-sm">
                                                        <?php echo $item['qty']; ?>
                                                    </span>
                                                    <button 
                                                        class="bg-gray-300 px-3 py-2 sm:px-2 sm:py-1 rounded hover:bg-gray-400 text-sm" 
                                                        onclick="updateQty(<?php echo $product_id; ?>, 1)">
                                                        +
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="px-2 sm:px-4 py-3 text-center font-semibold text-xs sm:text-base">
                                                ₱<?php echo number_format($subtotal, 2); ?>
                                            </td>
                                            <td class="px-2 sm:px-4 py-3 text-center">
                                                <button 
                                                    class="text-red-500 hover:text-red-700 text-sm sm:text-base"
                                                    onclick="removeFromCart(<?php echo $product_id; ?>)">
                                                    🗑️
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-white rounded-lg shadow p-4 sm:p-6 h-fit">
                        <h3 class="text-lg sm:text-xl font-bold mb-4">Order Summary</h3>
                        
                        <div class="space-y-2 sm:space-y-3 mb-4 sm:mb-6 pb-4 sm:pb-6 border-b border-gray-200 text-sm sm:text-base">
                            <div class="flex justify-between text-gray-700">
                                <span>Subtotal</span>
                                <span class="font-semibold">₱<?php echo number_format($total, 2); ?></span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>Shipping</span>
                                <span class="font-semibold">₱0.00</span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>Tax</span>
                                <span class="font-semibold">₱0.00</span>
                            </div>
                        </div>

                        <div class="flex justify-between text-xl sm:text-2xl font-bold mb-4 sm:mb-6">
                            <span>Total</span>
                            <span>₱<?php echo number_format($total, 2); ?></span>
                        </div>

                        <button class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition font-bold text-base sm:text-lg">
                            <a href="checkout.php" class="w-full block">
                                Proceed to Checkout
                            </a>
                        </button>

                        <a href="<?php echo $backUrl; ?>" class="block w-full text-center mt-3 text-blue-500 hover:text-blue-600 border border-blue-500 py-2 rounded font-semibold text-sm sm:text-base">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function updateQty(productId, delta) {
            const newQty = Math.max(1, parseInt(document.getElementById('qty-' + productId).textContent) + delta);
            
            fetch('update_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    qty: newQty
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('qty-' + productId).textContent = newQty;
                    location.reload(); // Reload to update totals
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update cart');
            });
        }

        function removeFromCart(productId) {
            if (confirm('Remove this item from cart?')) {
                fetch('remove_from_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to remove item');
                });
            }
        }
    </script>
</body>
</html>
