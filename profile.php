<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?msg=Please login first");
    exit;
}

include "includes/header.php";
include "db.php";

$user_id = (int) $_SESSION['user_id'];
$sql = "SELECT name, email, house_no, photo, role FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching user: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);
?>


<?php include 'components/navbar.php'; ?>

<style>
    body {
        background-color: #f0f2f5;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .profile-card {
        max-width: 700px;
        width: 100%;
        border-radius: 15px;
        overflow: hidden;
        background-color: white;
        transition: transform 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-5px);
    }

    .cover-photo {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }

    .profile-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid white;
        position: absolute;
        top: 150px;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    }

    .card-body {
        padding-top: 80px;
    }

    @media (max-width: 576px) {
        .cover-photo {
            height: 180px;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            top: 130px;
        }

        .card-body {
            padding-top: 70px;
        }
    }
</style>

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg profile-card border-0">
        <img src="https://images.unsplash.com/photo-1503264116251-35a269479413?w=1200" class="cover-photo" alt="Cover Photo">

        <img src="<?= !empty($user['photo']) ? htmlspecialchars($user['photo']) : 'https://via.placeholder.com/150' ?>"
            alt="Profile Picture"
            class="profile-img">

        <div class="card-body text-center">
            <h3 class="fw-bold mb-0"><?= htmlspecialchars($user['name']) ?></h3>
            <p class="text-muted"><?= htmlspecialchars($user['email']) ?></p>
            <p class="text-secondary">
                <i class="bi bi-house-door-fill"></i>
                <?= !empty($user['house_no']) ? htmlspecialchars($user['house_no']) : "No house number added" ?>
            </p>
            <span class="badge bg-info text-dark px-3 py-2"><?= htmlspecialchars($user['role']) ?></span>

            <div class="mt-4">
                <a href="profile_update.php" class="btn btn-primary me-2">
                    <i class="bi bi-pencil-square"></i> Edit Profile
                </a>
                <a href="logout.php" class="btn btn-outline-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </div>
</div>




<?php include "includes/footer.php"; ?>