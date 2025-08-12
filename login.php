<?php include 'includes/header.php' ?>

<?php if (isset($_GET['msg'])): ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <?php echo htmlspecialchars($_GET['msg']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="container mt-5" style="max-width: 500px;">
    <h2 class="text-center mb-4">Login</h2>
    <form action="api/login_action.php" method="POST">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email">
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <div class="text-center mt-3">
        <a href="signup.php">Don't have an account? Sign Up</a>
    </div>
</div>


<?php include 'includes/footer.php' ?>
