<?php include "includes/header.php"; ?>

<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <h3 class="card-title text-center">Signup</h3>
            
            <?php 
            if (isset($_GET['msg'])) {
                echo "<div class='alert alert-info'>" . htmlspecialchars($_GET['msg']) . "</div>";
            }
            ?>

            <form method="POST" action="api/signup_action.php">
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Signup</button>
            </form>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>
