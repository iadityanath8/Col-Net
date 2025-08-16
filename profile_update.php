<?php
include './includes/auth.php';
include './db.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<?php include './includes/header.php'; ?>
<?php include './components/navbar.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<script src="https://unpkg.com/feather-icons"></script>
<link rel="stylesheet" href="./assets/css/profile_update.css">

<div class="container py-5">
    <div class="profile-card mx-auto">
        <form action="./api/profile_update_action.php" method="POST" enctype="multipart/form-data">
            <div class="row g-5">
                <!-- Left Side -->
                <div class="col-md-4 text-center">
                    <div class="profile-pic-wrapper">
                        <img src="<?= !empty($user['photo']) ? htmlspecialchars($user['photo']) : 'https://via.placeholder.com/150' ?>"
                            id="preview" class="profile-pic" alt="Profile Picture">
                        <div class="edit-icon" onclick="document.getElementById('photoInput').click()">
                            <i data-feather="camera" style="color: white;"></i>
                        </div>
                        <input type="file" id="photoInput" name="photo" accept="image/*" style="display:none" onchange="previewImage(event)">
                    </div>
                </div>

                <!-- Right Side -->
                <div class="col-md-8">
                    <h4 class="fw-bold mb-4">Edit Profile</h4>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">House No</label>
                        <input type="text" name="house_no" value="<?= htmlspecialchars($user['house_no']) ?>" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role</label>
                        <select name="role" class="form-select">
                            <option value="User" <?= $user['role'] == 'User' ? 'selected' : '' ?>>User</option>
                            <option value="Admin" <?= $user['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">About Me</label>
                        <textarea name="about_me" rows="3" class="form-control" placeholder="Write something about yourself..."><?= htmlspecialchars($user['about_me']) ?></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" name="update" class="btn btn-primary btn-save">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    feather.replace();

    function previewImage(event) {
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(event.target.files[0]);
    }
</script>