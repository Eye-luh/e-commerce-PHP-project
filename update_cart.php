<?php
session_start();
include 'connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
// Get product ID and new quantity
$product_id = isset($data['product_id']) ? intval($data['product_id']) : 0;
$qty = isset($data['qty']) ? intval($data['qty']) : 0;

// Validate input parameters
if ($product_id <= 0 || $qty <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid product ID or quantity']);
    exit();
}

// Check if product exists in cart
if (!isset($_SESSION['cart'][$product_id])) {
    http_response_code(404);
    echo json_encode(['error' => 'Item not in cart']);
    exit();
}

// Query database to check available stock
$sql = "SELECT quantity FROM tbl_products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

// Product not found in database
if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Product not found']);
    exit();
}

// Get product stock info
$product = $result->fetch_assoc();

// Check if requested quantity exceeds available stock
if ($qty > $product['quantity']) {
    http_response_code(400);
    echo json_encode(['error' => 'Insufficient stock. Available: ' . $product['quantity']]);
    exit();
}

// Update quantity in cart
$_SESSION['cart'][$product_id]['qty'] = $qty;

http_response_code(200);
echo json_encode([
    'success' => true,
    'message' => 'Cart updated',
    'new_qty' => $qty
]);

$stmt->close();
$conn->close();
?>
