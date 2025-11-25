<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and trim username and password from form
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        echo 'Palihug pun-a ang username ug password.';
        exit;
    }
    
    $sql = "SELECT user_id AS id, userName, userPassword,userType FROM tbl_user WHERE userName = ? LIMIT 1";
    if ($stmt = $conn->prepare($sql)) {
       
        $stmt->bind_param("s", $username);
        
        if (!$stmt->execute()) {
            error_log("Stmt execute error: " . $stmt->error);
            echo "Internal error, check error log.";
            exit;
        }
        
        $res = $stmt->get_result();
        if ($res) {
            $row = $res->fetch_assoc();
        } else {
            $stmt->store_result();
            if ($stmt->num_rows === 0) {
                $row = null;
            } else {
                $stmt->bind_result($id, $dbUserName, $dbPasswordHash,$userType);
                $stmt->fetch();
                $row = [
                    'id' => $id,
                    'userName' => $dbUserName,
                    'userPassword' => $dbPasswordHash,
                    'userType' => $userType
                ];
            }
        }
        
        // Check if user account was found
        if ($row) {
            // Verify password matches database hash using bcrypt
            if (password_verify($password, $row['userPassword'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['userName'];
                $_SESSION['userType'] = $row['userType'];
                
                header('Location: dashboard.php');
                exit();
            } else {
                echo '❌ Username or Password does not match.';
            }
        } else {
            echo '❌ No account found with that username.';
        }
        $stmt->close();
    } else {
        error_log("Prepare failed: " . $conn->error);
        echo "❌ Internal error, please try later.";
    }
}
?>
