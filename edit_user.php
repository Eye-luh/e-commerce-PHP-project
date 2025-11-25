<?php
session_start();
include 'connection.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if (isset($_SESSION['userType']) && strtolower($_SESSION['userType']) !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

$error = '';
$success = '';
$user = null;

if (isset($_GET['id'])) {
    // Convert ID to integer for safety
    $user_id = intval($_GET['id']);
    
    // fetch user information
    $sql = "SELECT user_id, userName, email, userType FROM tbl_user WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if user exists
    if ($result->num_rows > 0) {
        
        $user = $result->fetch_assoc();
    } else {
        // User not found - redirect back to manage users page
        header("Location: manage_users.php");
        exit();
    }
    $stmt->close();
}

// Process form submission to update user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    // Get form data
    $user_id = intval($_POST['user_id']);
    $username = htmlspecialchars($_POST['username'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $usertype = htmlspecialchars($_POST['usertype'] ?? '');
    
    
    if (empty($username) || empty($email) || empty($usertype)) {
        $error = "All fields are required!";
    } else {
     
        $sql = "UPDATE tbl_user SET userName = ?, email = ?, userType = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $email, $usertype, $user_id);
        

        if ($stmt->execute()) {
        
            $success = "User updated successfully!";
            $user['userName'] = $username;
            $user['email'] = $email;
            $user['userType'] = $usertype;
        } else {
            $error = "Error updating user: " . mysqli_error($conn);
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit User</title>
</head>
<body>
    <div class="min-h-screen bg-gray-200 px-3 py-5 grid grid-cols-1 md:grid-cols-12 gap-4">

        <!-- SIDEBAR -->
        <div class="col-span-1 md:col-span-2">
            <div class="bg-white h-full rounded-2xl flex flex-col">

                <div class="h-26 flex items-center justify-center flex-col">
                    <img class="w-16 mt-6 object-contain" src="uploads/LOGO.png" alt="Adidadidadas Shoes">
                    <h1 class="font-bold mt-2 text-xl">ADIDADIDADAS</h1>
                </div>

                <div class="flex flex-col gap-4 mt-4 items-center p-4">
                    <a href="dashboard.php" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition">
                        <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="7" height="9" x="3" y="3" rx="1"/>
                            <rect width="7" height="5" x="14" y="3" rx="1"/>
                            <rect width="7" height="9" x="14" y="12" rx="1"/>
                            <rect width="7" height="5" x="3" y="16" rx="1"/>
                        </svg>
                        <h1 class="text-2xl ms-2 text-gray-500 group-hover:text-white transition">Dashboard</h1>
                    </a>

                    <a href="add_product.php" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition">
                        <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 16h6"/><path d="M19 13v6"/><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/>
                            <path d="m7.5 4.27 9 5.15"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/>
                        </svg>
                        <h1 class="text-2xl ms-2 text-gray-500 group-hover:text-white transition">Add Products</h1>
                    </a>

                    <a href="manage_users.php" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition">
                        <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.657-.671-3.157-1.76-4.233m2.76 4.233l.812 2.582m-4.572-8.725a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-9 6.75c1.657 0 3.157.671 4.233 1.76.985.99 1.644 2.338 1.821 3.721H3.75a4.125 4.125 0 0 1 4.275-5.481Zm0 0s3.063-.669 4.275-1.481" />
                        </svg>
                        <h1 class="text-2xl ms-2 text-gray-500 group-hover:text-white transition">Manage User</h1>
                    </a>
                </div>

                
                <div class="mt-auto p-4 w-full">
                    <a href="logout.php" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition">
                        <svg class="text-blue-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m16 17 5-5-5-5"/>
                            <path d="M21 12H9"/>
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        </svg>
                        <h1 class="text-2xl ms-4 text-gray-500 group-hover:text-white transition">Log Out</h1>
                    </a>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="bg-gray-200 rounded-2xl col-span-1 md:col-span-10">

            <div class="bg-white h-20 rounded-xl w-full p-2 flex justify-between items-center">
                <div class="ps-6 w-full">
                    <span>Edit User</span>
                    <?php
                        if (isset($_SESSION['username'])) {
                            echo '<h1 class="text-2xl font-bold text-blue-500">' . htmlspecialchars($_SESSION['username']) . '</h1>';
                        }
                    ?>
                </div>

                <div class="flex justify-end items-center w-full p-4">
                    <div class="p-4 flex gap-2 items-center max-w-xs sm:max-w-sm md:max-w-md overflow-hidden">
                        <h1 class="text-3xl text-gray-400">|</h1>
                        <?php
                            if (isset($_SESSION['userType'])) {
                                echo '<div class="flex items-center gap-1 truncate">
                                        <h1 class="text-2xl text-gray-400 pt-1 truncate">' . htmlspecialchars($_SESSION['userType']) . '</h1>
                                      </div>';
                            }
                        ?>
                    </div>
                </div>
            </div>

            
            <div class="w-full p-6">
                <div class="bg-white rounded-lg shadow p-8 max-w-2xl">
                    <h3 class="text-2xl font-bold mb-6">Edit User</h3>

                    <?php if ($error): ?>
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            ❌ <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            ✅ <?php echo htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($user): ?>
                        <form method="POST" class="space-y-4">
                            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">User ID</label>
                                <input type="text" disabled class="w-full px-4 py-2 border rounded bg-gray-100" value="<?php echo $user['user_id']; ?>">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Username</label>
                                <input type="text" name="username" required class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500 outline-none" value="<?php echo htmlspecialchars($user['userName']); ?>">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Email</label>
                                <input type="email" name="email" required class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500 outline-none" value="<?php echo htmlspecialchars($user['email']); ?>">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">User Type</label>
                                <select name="usertype" required class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500 outline-none">
                                    <option value="Admin" <?php echo $user['userType'] === 'Admin' ? 'selected' : ''; ?>>Admin</option>
                                    <option value="User" <?php echo $user['userType'] === 'User' ? 'selected' : ''; ?>>User</option>
                                </select>
                            </div>

                            <div class="flex gap-2">
                                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition font-semibold">
                                    Save Changes
                                </button>
                                <a href="manage_users.php" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 transition font-semibold">
                                    Back
                                </a>
                            </div>
                        </form>
                    <?php else: ?>
                        <p class="text-red-500">User not found</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
