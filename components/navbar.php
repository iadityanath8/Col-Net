<?php
$isLoggedIn = isset($_SESSION['user_id']);
?>

<nav class="navbar navbar-expand-lg navbar-dark glass-navbar py-2 shadow-sm animated-navbar sticky-top">
  <div class="container">

    <!-- Brand -->
    <a class="navbar-brand d-flex align-items-center fw-bold fs-3" href="index.php">
      <img src="./assets/logo.png" alt="Logo" width="35" height="35" class="me-2 rounded-circle">
      Col-Net
    </a>

    <!-- Mobile Menu Toggle -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Items -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center gap-3">

        <!-- Feed -->
        <li class="nav-item">
          <a class="nav-link cool-link" href="index.php" title="Feed">
            <i class="bi bi-house-door-fill fs-5"></i>
          </a>
        </li>

        <!-- Friends -->
        <li class="nav-item">
          <a class="nav-link cool-link" href="friends.php" title="Friends">
            <i class="bi bi-people-fill fs-5"></i>
          </a>
        </li>

        <!-- Messages -->
        <li class="nav-item">
          <a class="nav-link cool-link" href="messages.php" title="Messages">
            <i class="bi bi-chat-dots-fill fs-5"></i>
          </a>
        </li>

        <!-- Notifications -->
        <li class="nav-item">
          <a class="nav-link cool-link position-relative" href="notifications.php" title="Notifications">
            <i class="bi bi-bell-fill fs-5"></i>
            <!-- Example Notification Badge -->
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
              3
            </span>
          </a>
        </li>

        <?php if ($isLoggedIn): ?>
          <!-- Profile -->
          <li class="nav-item">
            <a class="nav-link cool-link" href="profile.php" title="Profile">
              <i class="bi bi-person-circle fs-5"></i>
            </a>
          </li>

          <!-- Logout -->
          <li class="nav-item">
            <a class="btn btn-warning px-3 py-1 rounded-pill fw-bold" href="api/logout_action.php">
              Logout
            </a>
          </li>

        <?php else: ?>
          <!-- Login -->
          <li class="nav-item">
            <a class="btn btn-outline-warning px-3 py-1 rounded-pill fw-bold me-2" href="login.php">
              Login
            </a>
          </li>

          <!-- Signup -->
          <li class="nav-item">
            <a class="btn btn-warning px-3 py-1 rounded-pill fw-bold" href="signup.php">
              Sign Up
            </a>
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
    from {
      transform: translateY(-100%);
      opacity: 0;
    }

    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  /* Link Hover Underline Animation */
  .cool-link {
    position: relative;
    color: white !important;
    transition: color 0.3s ease;
  }

  .cool-link:hover {
    color: #ffc107 !important;
  }

  .cool-link::after {
    content: '';
    position: absolute;
    width: 0%;
    height: 2px;
    display: block;
    margin-top: 3px;
    right: 0;
    background: #ffc107;
    transition: width 0.3s ease;
  }

  .cool-link:hover::after {
    width: 100%;
    left: 0;
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