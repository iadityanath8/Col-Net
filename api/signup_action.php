<?php
include "../db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $username = mysqli_real_escape_string($conn, trim($_POST["name"]));
    $email    = mysqli_real_escape_string($conn, trim($_POST["email"]));
    $password = trim($_POST["password"]);

    if (empty($username) || empty($email) || empty($password)) {
        header("Location: ../signup.php?msg=All fields are required");
        exit;
    }

    $checkEmail = "SELECT id FROM users WHERE email = '$email' LIMIT 1";
    $resultCheck = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($resultCheck) > 0) {
        header("Location: ../signup.php?msg=Email already exists. Please log in.");
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (name, email, password) VALUES ('$username', '$email', '$hashedPassword')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: ../login.php?msg=Registration successful! Please log in.");
        exit;
    } else {
        header("Location: ../signup.php?msg=Registration failed: " . urlencode(mysqli_error($conn)));
        exit;
    }
}
?>
