<?php
session_start();
include 'connection.php';

// echeck kung ang request kay POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kuhaonm ang username ug password gikan sa POST request ug tanggalan ang white spaces
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // validation kung ang username o password kay empty
    if ($username === '' || $password === '') {
        echo 'Palihug pun-a ang username ug password.';
        exit;
    }
    
    // nag ready ug SQL query para makakita ng user sa database
    $sql = "SELECT user_id AS id, userName, userPassword, userType FROM tbl_user WHERE userName = ? LIMIT 1";
    
    // nag gamit prepared statement para pag preven sa SQL Injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        
        // e check kung sakto ba ng password gikn sa datbase ug input sa user na pasword
        if ($row && password_verify($password, $row['userPassword'])) {
            // i store ang user information sa session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['userName'];
            $_SESSION['userType'] = $row['userType'];

            // insert for user log ang login activity sa database
            $log_sql = "INSERT INTO tbl_user_logs (user_id, username, userType, status) VALUES (?, ?, ?, 'Logged In')";
            if ($log_stmt = $conn->prepare($log_sql)) {
                
                $log_stmt->bind_param("iss", $row['id'], $row['userName'], $row['userType']);
                
                if ($log_stmt->execute()) {
                   
                    $_SESSION['current_log_id'] = $conn->insert_id; 
                }
                $log_stmt->close();
            }
            
            // I-redirect ang user sa dashboard page
            header('Location: dashboard.php');
            exit();
        } else {
            // Ipakita ang error message kung wala ang match
            echo 'Username or Password does not match.';
        }
        // i close ang prepared statement
        $stmt->close();
    } else {
        // I-log ang error kung dili success ang prepare
        error_log("Prepare failed: " . $conn->error);
        echo "Internal error, please try later.";
    }
} 
?>