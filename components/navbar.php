<?php

$isLoggedIn = isset($_SESSION['user_id']);
?>

<nav class="navbar navbar-expand-lg navbar-dark glass-navbar py-3 shadow-sm animated-navbar">
  <div class="container">

  <a class="navbar-brand d-flex align-items-center fw-bold fs-3" href="index.php">
      <img src="./assets/logo.png" alt="Logo" width="35" height="35" class="me-2 rounded-circle">
      Col-Net
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item">
          <a class="nav-link cool-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link cool-link" href="#">Members</a>
        </li>
        <li class="nav-item">
          <a class="nav-link cool-link" href="#">Events</a>
        </li>
        <?php if ($isLoggedIn): ?>
          <li class="nav-item">
            <a class="nav-link cool-link" href="profile.php">Profile</a>
          </li>
          <li class="nav-item ms-lg-3">
            <a class="btn btn-warning px-3 py-1 rounded-pill fw-bold" href="api/logout_action.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item ms-lg-3">
            <a class="btn btn-outline-warning px-3 py-1 rounded-pill fw-bold me-2" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-warning px-3 py-1 rounded-pill fw-bold" href="signup.php">Sign Up</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- CSS -->
<style>
/* Glassmorphism Navbar */
.glass-navbar {
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

/* Navbar Load Animation */
.animated-navbar {
    animation: slideDown 0.6s ease-out;
}
@keyframes slideDown {
    from { transform: translateY(-100%); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* Link Hover Underline Animation */
.cool-link {
    position: relative;
    color: white !important;
    transition: color 0.3s ease;
}
.cool-link::after {
    content: '';
    position: absolute;
    width: 0%;
    height: 2px;
    display: block;
    margin-top: 5px;
    right: 0;
    background: #ffc107;
    transition: width 0.3s ease;
    -webkit-transition: width 0.3s ease;
}
.cool-link:hover::after {
    width: 100%;
    left: 0;
    background: #ffc107;
}

/* Button Hover Effects */
.btn-warning:hover {
    background-color: #ffcd39;
    transform: scale(1.05);
    transition: all 0.3s ease;
}
.btn-outline-warning:hover {
    color: #000 !important;
    background-color: #ffc107;
    transform: scale(1.05);
    transition: all 0.3s ease;
}
</style>
