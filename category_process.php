<?php
include 'connection.php';

// --- KINI PARA SA EDIT/UPDATE ---
if (isset($_POST['update_category'])) {
    
    $id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $cat_name = mysqli_real_escape_string($conn, $_POST['name']);
    $cat_desc = mysqli_real_escape_string($conn, $_POST['description']);

    // Kinahanglan UPDATE ang gamiton, ug naay WHERE clause
    $sql = "UPDATE tbl_categories SET 
            categoryName = '$cat_name', 
            categoryDesc = '$cat_desc' 
            WHERE category_id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Category Updated Successfully!'); window.location.href='dashboard.php?content=manage_categories';</script>";
    } else {
        echo "Error Updating: " . mysqli_error($conn);
    }

// --- KINI PARA SA ADD NEW (Karaan nimo nga code) ---
} elseif (isset($_POST['name'])) {
    
    $cat_name = mysqli_real_escape_string($conn, $_POST['name']);
    $cat_desc = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "INSERT INTO tbl_categories (categoryName, categoryDesc) VALUES ('$cat_name', '$cat_desc')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('New Category Added!'); window.location.href='dashboard.php?content=manage_categories';</script>";
    } else {
        echo "Error Adding: " . mysqli_error($conn);
    }
}
?>