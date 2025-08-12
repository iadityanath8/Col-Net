<?php

session_start();
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $pass  = trim($_POST['password']);

    if (empty($email) || empty($pass)) {
        header("Location: ../login.php?msg=All fields are required");
        exit;
    }

    $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($pass, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];

            header("Location: ../index.php?msg=Welcome back, " . urlencode($user['username']));
        } else {
            header("Location: ../login.php?msg=Invalid password");
            exit;
        }
    } else {
        header("Location: ../login.php?msg=No account found with this email");
        exit;
    }
}
    