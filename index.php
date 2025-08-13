<?php
include './includes/auth.php';
?>
<?php include './includes/header.php'; ?>
<?php include './components/navbar.php'; ?>

<div class="container mt-4">
    <?php include './components/create_post.php'; ?>

    <div class="d-flex justify-content-between align-items-center mt-5">
        <h2 class="text-dark">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h2>
    </div>
    <hr>


    <?php
    $show_user_profile = false;
    include './components/post_feed.php';
    ?>
</div>

<?php include './includes/footer.php'; ?>