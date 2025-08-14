<?php
$isLoggedIn = isset($_SESSION['user_id']);
?>

<link rel="stylesheet" href="./assets/css/navbar.css">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3 py-2 shadow-sm">
  <div class="container-fluid d-flex align-items-center justify-content-between">

    <a class="navbar-brand d-flex align-items-center me-3" href="index.php">
      <img src="./assets/logo.png" alt="Logo" class="rounded-circle shadow-sm" width="40" height="40">
      <span class="ms-2">Col-Net</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarNav">

      <ul class="navbar-nav mb-2 mb-lg-0 d-flex flex-row align-items-center gap-2 me-lg-3">
        <li class="nav-item">
          <a class="nav-link" href="index.php" title="Home"><i class="bi bi-house-door-fill fs-5"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="friends.php" title="Friends"><i class="bi bi-people-fill fs-5"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="messages.php" title="Messages"><i class="bi bi-chat-dots-fill fs-5"></i></a>
        </li>
        <li class="nav-item position-relative">
          <a class="nav-link" href="notifications.php" title="Notifications">
            <i class="bi bi-bell-fill fs-5"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
          </a>
        </li>
      </ul>

      <form class="d-flex mx-lg-3 my-2 my-lg-0 flex-grow-1" action="search.php" method="GET" style="max-width: 250px;">
        <div class="input-group">
          <span class="input-group-text bg-dark border-0 text-white"><i class="bi bi-search"></i></span>
          <input class="form-control rounded-pill bg-light text-white border-0" type="search" name="q" placeholder="Search" aria-label="Search">
        </div>
      </form>

      <ul class="navbar-nav ms-lg-3 d-flex flex-row align-items-center gap-2">
        <?php if ($isLoggedIn): ?>
          <li class="nav-item">
            <a class="nav-link" href="profile.php" title="Profile"><i class="bi bi-person-circle fs-5"></i></a>
          </li>
          <li class="nav-item">
            <a class="btn btn-danger rounded-pill px-3" href="api/logout_action.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="btn btn-outline-warning rounded-pill px-3" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-warning rounded-pill px-3" href="signup.php">Sign Up</a>
          </li>
        <?php endif; ?>
      </ul>

    </div>
  </div>
</nav>