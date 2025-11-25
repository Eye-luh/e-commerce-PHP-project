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

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_id = max(1, $delete_id); // Prevent deleting admin
    
    $sql = "DELETE FROM tbl_user WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        header("Location: manage_users.php?message=User deleted successfully");
        exit();
    } else {
        $error = "Error deleting user: " . mysqli_error($conn);
    }
    $stmt->close();
}

// Fetch all users
$sql = "SELECT user_id, userName, email, userType FROM tbl_user ORDER BY user_id DESC";
$result = mysqli_query($conn, $sql);
$users = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Manage Users</title>
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

                    <a href="manage_users.php" class="group hover:bg-blue-500 p-3 rounded-xl flex items-center w-full transition bg-blue-500">
                        <svg class="text-blue-500 group-hover:text-white transition text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.657-.671-3.157-1.76-4.233m2.76 4.233l.812 2.582m-4.572-8.725a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-9 6.75c1.657 0 3.157.671 4.233 1.76.985.99 1.644 2.338 1.821 3.721H3.75a4.125 4.125 0 0 1 4.275-5.481Zm0 0s3.063-.669 4.275-1.481" />
                        </svg>
                        <h1 class="text-2xl ms-2 text-white transition">Manage User</h1>
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
                    <span>Manage Users</span>
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

            <!-- Users Table -->
            <div class="w-full p-6">
                <?php if (isset($_GET['message'])): ?>
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        ✅ <?php echo htmlspecialchars($_GET['message']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        ❌ <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold">User ID</th>
                                <th class="px-6 py-4 text-left font-semibold">Username</th>
                                <th class="px-6 py-4 text-left font-semibold">Email</th>
                                <th class="px-6 py-4 text-left font-semibold">User Type</th>
                                <th class="px-6 py-4 text-center font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($users) > 0): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="px-6 py-4"><?php echo $user['user_id']; ?></td>
                                        <td class="px-6 py-4 font-semibold"><?php echo htmlspecialchars($user['userName']); ?></td>
                                        <td class="px-6 py-4"><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 rounded text-white text-sm <?php echo strtolower($user['userType']) === 'admin' ? 'bg-blue-500' : 'bg-gray-500'; ?>">
                                                <?php echo htmlspecialchars($user['userType']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex gap-2 justify-center">
                                                <a href="edit_user.php?id=<?php echo $user['user_id']; ?>" class="text-blue-500 hover:text-blue-700 font-semibold">
                                                    Edit
                                                </a>
                                                <?php if ($user['user_id'] !== $_SESSION['user_id']): ?>
                                                    <a href="manage_users.php?delete_id=<?php echo $user['user_id']; ?>" class="text-red-500 hover:text-red-700 font-semibold" onclick="return confirm('Are you sure you want to delete this user?');">
                                                        Delete
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No users found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
