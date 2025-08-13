<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?msg=Please login first");
    exit;
}

include "includes/header.php";
include "db.php";

$user_id = (int) $_SESSION['user_id'];
$sql = "SELECT name, email, house_no, photo, role, about_me FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching user: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);
?>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="./assets/css/profile.css">

<?php include 'components/navbar.php'; ?>

<div class="container py-5">

    <!-- Modern Profile Card -->
    <div class="profile-card">
        <div class="profile-header">
            <!-- Role Badge -->
            <span class="badge badge-role <?= strtolower($user['role']) === 'admin' ? 'bg-success' : 'bg-primary' ?>">
                <i class="<?= strtolower($user['role']) === 'admin' ? 'bi-shield-check' : 'bi-person' ?>"></i>
                <?= htmlspecialchars($user['role']) ?>
            </span>

            <!-- Profile Image -->
            <img src="<?= !empty($user['photo']) ? htmlspecialchars($user['photo']) : 'https://via.placeholder.com/150' ?>"
                alt="Profile Picture" class="profile-image">
        </div>

        <div class="profile-body">
            <h4><?= htmlspecialchars($user['name']) ?></h4>
            <p class="text-muted mb-1"><i class="bi bi-envelope"></i> <?= htmlspecialchars($user['email']) ?></p>
            <p class="text-muted"><i class="bi bi-house-door"></i>
                <?= !empty($user['house_no']) ? htmlspecialchars($user['house_no']) : "No house number added" ?>
            </p>
            <hr>
            <h6 class="fw-semibold text-start">About Me</h6>
            <p class="text-muted text-start">
                <?= !empty($user['about_me']) ? htmlspecialchars($user['about_me']) : "No about me info added yet." ?>
            </p>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="friends-count">120</span>
                <span class="text-muted">Friends</span>
            </div>
            <div class="d-grid mt-3">
                <a href="profile_update.php" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Edit Profile</a>
            </div>
        </div>
    </div>

    <!-- Posts Section -->
    <div class="mt-5">
        <?php
        $show_user_profile = true;
        include './components/post_feed.php';
        ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>