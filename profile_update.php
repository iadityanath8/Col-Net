

<?php
    include './includes/auth.php';
    include './db.php';

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

?>


<?php     include './includes/header.php'; ?>
<?php     include './components/navbar.php' ?>
<style>
    body {
        background-color: #f0f2f5;
    }

    .edit-card {
        max-width: 600px;
        width: 100%;
        border-radius: 15px;
        background: white;
        padding: 20px;
    }

    .profile-preview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #ddd;
    }
</style>


<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="edit-card shadow-lg">
        <h3 class="text-center mb-4"><i class="bi bi-pencil-square"></i> Edit Profile</h3>

        <form action = './api/profile_update_action.php' method="POST" enctype="multipart/form-data">
            <div class="text-center mb-3">
                <img src="<?= !empty($user['photo']) ? htmlspecialchars($user['photo']) : 'https://via.placeholder.com/150' ?>"
                    id="preview" class="profile-preview mb-2" alt="Profile Preview">
                <input type="file" class="form-control mt-2" name="photo" accept="image/*" onchange="previewImage(event)">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">House No</label>
                <input type="text" name="house_no" value="<?= htmlspecialchars($user['house_no']) ?>" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Role</label>
                <select name="role" class="form-select">
                    <option value="User" <?= $user['role'] == 'User' ? 'selected' : '' ?>>User</option>
                    <option value="Admin" <?= $user['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>

            <div class="d-grid">
                <button type="submit" name="update" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        document.getElementById('preview').src = URL.createObjectURL(event.target.files[0]);
    }
</script>