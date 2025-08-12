<?php
include '../includes/auth.php';

include '../db.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $house_no = mysqli_real_escape_string($conn, $_POST['house_no']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $photo_sql = "";
    if (!empty($_FILES['photo']['name'])) {
        $photo_name = time() . "_" . basename($_FILES['photo']['name']);
        
        // Folder path (relative to this PHP file)
        $upload_dir = "../assets/uploads/";
        $target = $upload_dir . $photo_name;
    
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
            // Save relative path to database (no ../)
            $relative_path = "assets/uploads/" . $photo_name;
            $photo_sql = ", photo='" . mysqli_real_escape_string($conn, $relative_path) . "'";
        }else {
            exit("erroe");
        }
    }
    

    $update_sql = "
        UPDATE users 
        SET name='$name', email='$email', house_no='$house_no', role='$role' $photo_sql
        WHERE id='$user_id'
    ";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: ../profile.php?success=1");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
