<?php

    session_start();

    include 'connection.php';

    if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

    if(isset($_GET['id'])){
        $product_id = $_GET['id'];

        $sql = "DELETE FROM tbl_products WHERE product_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$product_id);

        if ($stmt->execute()) {
           
            header('Location: dashboard.php');
            exit();
        } 

        $stmt->close();

    }

    $conn->close();



?>