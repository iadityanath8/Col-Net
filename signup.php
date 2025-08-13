<?php include "includes/header.php"; ?>

<link rel="stylesheet" href="./assets/css/signup.css"> </link>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
        <?php echo htmlspecialchars($_GET['msg']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Centered Signup Card -->
<div class="d-flex justify-content-center align-items-center flex-grow-1 position-relative">
    <div class="signup-card text-white">
        <h3 class="text-center mb-4 fw-bold">Create Account ✨</h3>

        <form method="POST" action="api/signup_action.php">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-warning w-100">Signup</button>
        </form>

        <div class="text-center mt-3">
            <a href="login.php">Already have an account? Login</a>
        </div>
    </div>

    <!-- Background Wave -->
    <svg class="bg-wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" style="position:absolute; bottom:0; width:100%; height:auto; z-index:0;">
        <path fill="#fff" fill-opacity="0.2" d="M0,288L48,272C96,256,192,224,288,224C384,224,480,256,576,245.3C672,235,768,181,864,149.3C960,117,1056,107,1152,106.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
</div>

<?php include "includes/footer.php"; ?>