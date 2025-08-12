<?php
include '../db.php';
include '../includes/auth.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $post_id = intval($_POST['post_id']);

    $check_sql = "SELECT id FROM likes WHERE post_id = $post_id AND user_id = $user_id";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        mysqli_query($conn, "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id");
        $liked = false;
    } else {
        mysqli_query($conn, "INSERT INTO likes (post_id, user_id, created_at) VALUES ($post_id, $user_id, NOW())");
        $liked = true;
    }

    $count_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM likes WHERE post_id = $post_id");
    $count_row = mysqli_fetch_assoc($count_result);
    $like_count = (int)$count_row['total'];

    echo json_encode([
        "success" => true,
        "liked" => $liked,
        "like_count" => $like_count
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid Request Method"
    ]);
}
