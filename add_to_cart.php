<?php
session_start();
include 'connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$data = json_decode(file_get_contents('php://input'), true);
$product_id = isset($data['product_id']) ? intval($data['product_id']) : 0;
$qty = isset($data['qty']) ? intval($data['qty']) : 1;

if ($product_id <= 0 || $qty <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid product ID or quantity']);
    exit();
}

$sql = "SELECT product_name, price, quantity FROM tbl_products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Product not found']);
    exit();
}

$product = $result->fetch_assoc();

if ($qty > $product['quantity']) {
    http_response_code(400);
    echo json_encode(['error' => 'Insufficient stock. Available: ' . $product['quantity']]);
    exit();
}

if (isset($_SESSION['cart'][$product_id])) {
    // Calculate sa new total quantity
    $new_qty = $_SESSION['cart'][$product_id]['qty'] + $qty;
    // Verify new total doesn't exceed available stock
    if ($new_qty > $product['quantity']) {
        http_response_code(400);
        echo json_encode(['error' => 'Insufficient stock. Max available: ' . $product['quantity']]);
        exit();
    }
    // Update quantity sa cart
    $_SESSION['cart'][$product_id]['qty'] = $new_qty;
} else {
    // pag add og new product sa cart with details
    $_SESSION['cart'][$product_id] = [
        'qty' => $qty,
        'price' => floatval($product['price']),
        'name' => $product['product_name']
    ];
}

http_response_code(200);
echo json_encode([
    'success' => true,
    'message' => 'Product added to cart',
    'cart_count' => count($_SESSION['cart']),
    'item_qty' => $_SESSION['cart'][$product_id]['qty']
]);

$stmt->close();
$conn->close();
?>
