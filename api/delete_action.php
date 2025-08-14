<?php
include '../db.php';
include '../includes/auth.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = intval($_POST['post_id']);
    $user_id = intval($_SESSION['user_id']);
    
    $sql = "SELECT image FROM  posts WHERE id = $post_id AND user_id = $user_id";
    
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);
    
    if (!$post) {
        echo json_encode([
            "success" => false,
            "message" => "Post not found or you don't have permission"
        ]);
        exit;
    }
    
    $current_image = $post['image'];
    $deletesql = "DELETE FROM posts WHERE id = $post_id AND user_id = $user_id";
    $delres = mysqli_query($conn,$deletesql);

    if ($current_image && file_exists("../" . $current_image)) {
        unlink("../" . $current_image);
    }

    if ($delres) {
        echo json_encode([
            "success" => true,
            "deleted_post" => $post
        ]);
    }else {
        echo json_encode([
            "success" => true,
            "message" => "failed to delete the post"
        ]);
    }
    
}


?>