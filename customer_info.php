<?php
// Siguraduha nga naay session_start() sa imong connection.php o diri
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$success_message = '';
$error_message = '';
$uid = intval($_SESSION['user_id']);

// --- 1. DATA FETCHING LOGIC ---
// Kuhaon ang data gikan sa tbl_user (para sa userName ug email)
$user_query = mysqli_query($conn, "SELECT * FROM tbl_user WHERE user_id = $uid");
$user_info = mysqli_fetch_assoc($user_query);

// Kuhaon ang data gikan sa tbl_customers (kung naa na)
$cust_query = mysqli_query($conn, "SELECT * FROM tbl_customers WHERE user_id = $uid");
$existing_customer = mysqli_fetch_assoc($cust_query);

// I-merge: Priority ang tbl_customers, Fallback ang tbl_user
// Importante: Ang 'userName' sa tbl_user maoy mahimong 'fullname' sa form kung walay record sa tbl_customers
$customer_data = $existing_customer ? $existing_customer : $user_info;

// --- 2. FORM SUBMISSION LOGIC ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name'] ?? ''));
    $email = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone'] ?? ''));
    $address = mysqli_real_escape_string($conn, trim($_POST['address'] ?? ''));
    $bday = mysqli_real_escape_string($conn, trim($_POST['bday'] ?? ''));

    if (empty($full_name) || empty($email)) {
        $error_message = "Full name and email are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        $check = mysqli_query($conn, "SELECT customerID FROM tbl_customers WHERE user_id = $uid");
        
        if ($check && mysqli_num_rows($check) > 0) {
            // UPDATE existing customer
            $update = "UPDATE tbl_customers SET 
                fullname = '$full_name',
                email = '$email',
                phone = '$phone',
                address = '$address',
                bday = '$bday'
                WHERE user_id = $uid";
            if (mysqli_query($conn, $update)) {
                $success_message = "Information updated successfully!";
            } else {
                $error_message = "Update error: " . mysqli_error($conn);
            }
        } else {
            // INSERT new customer
            $insert = "INSERT INTO tbl_customers (fullname, email, phone, address, bday, user_id) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert);
            $stmt->bind_param('sssssi', $full_name, $email, $phone, $address, $bday, $uid);
            if ($stmt->execute()) {
                $success_message = "Information saved successfully!";
            } else {
                $error_message = "Save error: " . $conn->error;
            }
        }

        // I-refresh ang data para sa display
        $refresh = mysqli_query($conn, "SELECT * FROM tbl_customers WHERE user_id = $uid");
        if ($refresh && mysqli_num_rows($refresh) > 0) {
            $customer_data = mysqli_fetch_assoc($refresh);
            $_SESSION['customerID'] = $customer_data['customerID'];
        }
    }
}

function render_customer_info_form($customer_data, $success_message, $error_message) {
    ob_start();
    ?>
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mt-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Customer Information</h2>
            <p class="text-sm text-gray-500 mt-1">Update your personal and contact information</p>
        </div>

        <?php if (!empty($success_message)): ?>
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3 text-green-800">
                <i class="fas fa-check-circle text-green-600"></i>
                <span><?php echo htmlspecialchars($success_message); ?></span>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3 text-red-800">
                <i class="fas fa-exclamation-circle text-red-600"></i>
                <span><?php echo htmlspecialchars($error_message); ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                    <input 
                        type="text" id="full_name" name="full_name" 
                        /* Dinhi ang logic: itatala ang 'fullname' OR 'userName' */
                        value="<?php echo htmlspecialchars($customer_data['fullname'] ?? $customer_data['userName'] ?? ''); ?>"
                        required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition"
                        placeholder="John Doe"
                    >
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                    <input 
                        type="email" id="email" name="email" 
                        value="<?php echo htmlspecialchars($customer_data['email'] ?? ''); ?>"
                        required readonly
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition bg-gray-50 text-gray-600 cursor-not-allowed"
                    >
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                    <input 
                        type="tel" id="phone" name="phone" 
                        value="<?php echo htmlspecialchars($customer_data['phone'] ?? ''); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition"
                        placeholder="09XXXXXXXXX"
                    >
                </div>

                <div>
                    <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Address</label>
                    <input 
                        type="text" id="address" name="address" 
                        value="<?php echo htmlspecialchars($customer_data['address'] ?? ''); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition"
                        placeholder="Complete Address"
                    >
                </div>

                <div>
                    <label for="bday" class="block text-sm font-semibold text-gray-700 mb-2">Day of Birth</label>
                    <input 
                        type="date" id="bday" name="bday" 
                        value="<?php echo htmlspecialchars($customer_data['bday'] ?? ''); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition"
                    >
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-500 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-pink-600 transition-all duration-300 shadow-md">
                    <i class="fas fa-save mr-2"></i> Save Information
                </button>
                <a href="dashboard.php" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-all duration-300 text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
    <?php
    return ob_get_clean();
}

// Para sa separate rendering
if (basename($_SERVER['PHP_SELF']) !== basename(__FILE__)) {
    echo render_customer_info_form($customer_data, $success_message, $error_message);
    return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Customer Information</title>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-4xl mx-auto p-6">
        <?php echo render_customer_info_form($customer_data, $success_message, $error_message); ?>
    </div>
</body>
</html>