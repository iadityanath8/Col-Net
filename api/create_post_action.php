<?php
include '../includes/auth.php';
include '../db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $imagePath = NULL;

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $uploadDir = "../assets/uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $targetPath = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $imagePath = "assets/uploads/" . $imageName;
        }
    }

    $sql = "INSERT INTO posts (user_id, content, image, created_at) 
            VALUES ('$user_id', '$content', " .
        ($imagePath ? "'" . mysqli_real_escape_string($conn, $imagePath) . "'" : "NULL") .
        ", NOW())";

    if (mysqli_query($conn, $sql)) {
        $post_id = mysqli_insert_id($conn);

        $result = mysqli_query($conn, "
                    SELECT p.id, p.content, p.image, p.created_at,
                           u.name, u.photo
                    FROM posts p
                    JOIN users u ON p.user_id = u.id
                    WHERE p.id = $post_id
                ");

        $post = mysqli_fetch_assoc($result);

        echo json_encode([
            "success" => true,
            "post" => $post
        ]);
        exit;
    } else {
        echo json_encode(["success" => false, "message" => mysqli_error($conn)]);
        exit;
    }
}

echo json_encode(["success" => false, "message" => "Invalid request"]);
