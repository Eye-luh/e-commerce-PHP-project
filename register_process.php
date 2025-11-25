<?php
    include 'connection.php';


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $usertype = $_POST['usertype'];


        $sql = "INSERT INTO tbl_user (userName, email, userPassword, userType)
                VALUES ('$username', '$email', '$password', '$usertype')";


        if ($conn->query($sql)) {

            header("Location: login.html");
            exit();
        } else {

            echo "Error: " . mysqli_error($conn);
        }

        $conn->close();
    } else {
       
        echo "Invalid request method.";
    }

?>
