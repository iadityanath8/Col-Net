<?php
header('Content-Type: application/json');

include "../db.php";
include "../includes/auth.php";

$response = ["success" => false, "message" => ""];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = intval($_POST['post_id']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $user_id = $_SESSION['user_id'];
    $result = mysqli_query($conn, "SELECT image FROM posts WHERE id = $post_id AND user_id = $user_id");
    if (!$result || mysqli_num_rows($result) === 0) {
        $response["message"] = "Post not found or unauthorized";
        echo json_encode($response);
        exit;
    }

    $row = mysqli_fetch_assoc($result);
    $current_image = $row['image'];
    $imagePath = null;

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $uploadDir = "../assets/uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $targetPath = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $imagePath = "assets/uploads/" . $imageName;

            if ($current_image && file_exists("../" . $current_image)) {
                unlink("../" . $current_image);
            }
        }
    }

    $updatesql = "UPDATE posts 
        SET 
            content = '" . mysqli_real_escape_string($conn, $content) . "', 
            image = " . ($imagePath ? "'" . mysqli_real_escape_string($conn, $imagePath) . "'" : "image") . " 
        WHERE id = '$post_id' AND user_id = '$user_id'";

    if (mysqli_query($conn, $updatesql)) {
        $response["success"] = true;
        $response["message"] = "Post updated successfully";
        $response["updated_post"] = [
            "id" => $post_id,
            "content" => $content,
            "image" => $imagePath ? $imagePath : $current_image
        ];
    } else {
        $response["message"] = "Error updating post: " . mysqli_error($conn);
    }
}

echo json_encode($response);


exit;
