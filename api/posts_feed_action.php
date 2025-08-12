<?php
include '../db.php';
include '../includes/auth.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT p.id, p.content, p.image, p.created_at, u.name, u.photo, 
            (SELECT COUNT(*) FROM likes WHERE post_id = p.id) AS like_count,
            EXISTS(SELECT 1 FROM likes WHERE post_id = p.id AND user_id = $user_id) AS liked_by_user
            FROM posts p 
            JOIN users u ON p.user_id = u.id
            ORDER BY p.created_at DESC;
        ";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo json_encode([
            "success" => false,
            "message" => "Database query failed" . mysqli_error($conn)
        ]);
        exit;
    }


    $posts = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = [
            "id" => $row['id'],
            "name" => $row['name'],
            "photo" => $row['photo'],
            "content" => $row['content'],
            "image" => $row['image'],
            "created_at" => $row['created_at'],
            "like_count" => (int)$row['like_count'],
            "liked_by_user" => (bool)$row['liked_by_user']
        ];
    }

    echo json_encode([
        "success" => true,
        "posts" => $posts
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method"
    ]);
}
