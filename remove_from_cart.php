<?php
session_start();

header('Content-Type: application/json');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

// Parse JSON data from AJAX request
$data = json_decode(file_get_contents('php://input'), true);
// Get product ID to remove from cart
$product_id = isset($data['product_id']) ? intval($data['product_id']) : 0;

if ($product_id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid product ID']);
    exit();
}

// Check if product exists sa cart
if (!isset($_SESSION['cart'][$product_id])) {
    http_response_code(404);
    echo json_encode(['error' => 'Item not in cart']);
    exit();
}

// Remove item from cart session
unset($_SESSION['cart'][$product_id]);

// Send success response with updated cart count
http_response_code(200);
echo json_encode([
    'success' => true,
    'message' => 'Item removed from cart',
    'cart_count' => count($_SESSION['cart'])
]);
?>
