<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cartItems = $_SESSION['cart'];
$total = 0;

$continueShoppingUrl = isset($_SESSION['user_id']) ? 'dashboard.php' : 'index.php';

if (count($cartItems) === 0) {
    header("Location: cart.php");
    exit();
}

foreach ($cartItems as $product_id => $item) {
    $subtotal = $item['price'] * $item['qty'];
    $total += $subtotal;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = htmlspecialchars($_POST['full_name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    $address = htmlspecialchars($_POST['address'] ?? '');
    $city = htmlspecialchars($_POST['city'] ?? '');
    $payment_method = htmlspecialchars($_POST['payment_method'] ?? '');

    if (empty($full_name) || empty($email) || empty($phone) || empty($address) || empty($city) || empty($payment_method)) {
        $error = "All fields are required!";
    } else {
        $_SESSION['order_summary'] = [
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'payment_method' => $payment_method,
            'items' => $cartItems,
            'total' => $total,
            'order_date' => date('Y-m-d H:i:s')
        ];
        unset($_SESSION['cart']);
        
        header("Location: order_confirmation.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Checkout</title>
</head>
<body>
    <div class="min-h-screen bg-gray-100">
        <!-- Header -->
        <div class="bg-gray-200 p-4">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-3 sm:gap-6">
                <div class="flex items-center gap-4 w-full sm:w-auto">
                    <a href="index.php" class="text-xl font-bold text-gray-800 hover:text-blue-500">
                        ← Back to Shop
                    </a>
                    <h1 class="text-2xl sm:text-4xl font-bold">Adidadidadas</h1>
                </div>
                <div class="flex items-center gap-4">
                    <a href="cart.php" class="text-blue-500 font-semibold">
                        Cart (<?php echo count($cartItems); ?>)
                    </a>
                    <div class="bg-blue-500 rounded px-4 py-2">
                        <a href="logout.php" class="text-white">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-6xl mx-auto p-4">
            <h2 class="text-3xl font-bold mb-6">Checkout</h2>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-xl font-bold mb-6">Shipping Information</h3>

                        <?php if (isset($error)): ?>
                            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2 text-sm sm:text-base">Full Name</label>
                                    <input type="text" name="full_name" required class="w-full px-3 sm:px-4 py-3 border rounded focus:ring-2 focus:ring-blue-500 outline-none text-base">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2 text-sm sm:text-base">Email</label>
                                    <input type="email" name="email" required class="w-full px-3 sm:px-4 py-3 border rounded focus:ring-2 focus:ring-blue-500 outline-none text-base">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2 text-sm sm:text-base">Phone Number</label>
                                    <input type="tel" name="phone" required class="w-full px-3 sm:px-4 py-3 border rounded focus:ring-2 focus:ring-blue-500 outline-none text-base">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2 text-sm sm:text-base">City</label>
                                    <input type="text" name="city" required class="w-full px-3 sm:px-4 py-3 border rounded focus:ring-2 focus:ring-blue-500 outline-none text-base">
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2 text-sm sm:text-base">Address</label>
                                <textarea name="address" required rows="3" class="w-full px-3 sm:px-4 py-3 border rounded focus:ring-2 focus:ring-blue-500 outline-none text-base"></textarea>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2 text-sm sm:text-base">Payment Method</label>
                                <select name="payment_method" required class="w-full px-3 sm:px-4 py-3 border rounded focus:ring-2 focus:ring-blue-500 outline-none text-base">
                                    <option value="">Select a payment method</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Debit Card">Debit Card</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Cash on Delivery">Cash on Delivery</option>
                                    <option value="E-Wallet">E-Wallet (GCash/PayMaya)</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition font-bold text-base sm:text-lg">
                                Place Order
                            </button>
                            <a href="<?php echo $continueShoppingUrl; ?>" class="block w-full text-center bg-gray-400 text-white py-3 rounded-lg hover:bg-gray-500 transition font-bold text-base sm:text-lg mt-2">
                                Continue Shopping
                            </a>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-white rounded-lg shadow p-4 sm:p-6 h-fit">
                    <h3 class="text-lg sm:text-xl font-bold mb-4">Order Summary</h3>
                    
                    <div class="space-y-2 sm:space-y-3 mb-4 pb-4 border-b border-gray-200 text-xs sm:text-sm">
                        <?php foreach ($cartItems as $product_id => $item): 
                            $subtotal = $item['price'] * $item['qty'];
                        ?>
                            <div class="flex justify-between">
                                <span class="truncate"><?php echo htmlspecialchars($item['name']); ?> x <?php echo $item['qty']; ?></span>
                                <span class="font-semibold ml-2">₱<?php echo number_format($subtotal, 2); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

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

                    <div class="flex justify-between text-lg sm:text-2xl font-bold">
                        <span>Total</span>
                        <span>₱<?php echo number_format($total, 2); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
