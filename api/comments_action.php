<?php
include '../db.php';
include '../includes/auth.php';

header("Content-Type: application/json");




if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (!$data || !isset($data['post_id'], $data['content'])) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid JSON data or missing fields"
        ]);
        exit;
    }

    $post_id = intval($data['post_id']);
    $user_id = $_SESSION['user_id'];
    $content = trim($data['content']);

    if (empty($content)) {
        echo json_encode([
            "success" => false,
            "message" => "Comment content cannot be empty"
        ]);
        exit;
    }

    $content_escaped = mysqli_real_escape_string($conn, $content);

    $sql = "INSERT INTO comments (post_id, user_id, content, created_at) VALUES ($post_id, $user_id, '$content_escaped', NOW());";
    $sql_photo = "SELECT photo FROM users WHERE id = $user_id LIMIT 1";
    $userPhoto = null;

    $result = mysqli_query($conn, $sql);
    $id = mysqli_insert_id($conn);
    $photo_res = mysqli_query($conn, $sql_photo);

    if ($photo_res && mysqli_num_rows($photo_res) > 0) {
        $rowPhoto = mysqli_fetch_assoc($photo_res);
        $userPhoto = $rowPhoto['photo'];
    }

    if (!$result) {
        echo json_encode([
            "success" => false,
            "message" => "Database query failed: " . mysqli_error($conn)
        ]);
        exit;
    }

    $comment = [
        "id" => $id,
        "post_id" => $post_id,
        "user_id" => $user_id,
        "content" => $content,
        "photo"   => $userPhoto,
        "created_at" => date('Y-m-d H:i:s')
    ];

    echo json_encode([
        "success" => true,
        "comment" => $comment
    ]);

    exit;
}




if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $post_id = intval($_GET['post_id']);

    $sql = "SELECT c.id, c.content, c.created_at, u.name, u.photo FROM comments c
        JOIN users u on c.user_id = u.id
        WHERE c.post_id = $post_id
        ORDER BY c.created_at ASC;";


    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo json_encode([
            "success" => false,
            "message" => "Database query failed: " . mysqli_error($conn)
        ]);
        exit;
    }

    $comments = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $comments[] = [
            "id" => $row['id'],
            "content" => $row['content'],
            "created_at" => $row['created_at'],
            "name" => $row['name'],
            "photo" => $row['photo']
        ];
    }

    echo json_encode([
        "success" => true,
        "comments" => $comments
    ]);

    exit;
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method"
    ]);


    exit;
}
