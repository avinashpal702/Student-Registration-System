<?php
$currentPage = basename($_SERVER['SCRIPT_NAME'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#111827">
    <title>StudentSpace | Learn, grow, go further</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body data-page="<?= htmlspecialchars($currentPage, ENT_QUOTES, 'UTF-8') ?>"
      data-authenticated="<?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>">
<nav class="navbar navbar-expand-lg navbar-dark site-navbar sticky-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <span class="brand-mark" aria-hidden="true">S</span>
      <span>Student<span class="brand-light">Space</span></span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item"><a class="nav-link<?= $currentPage === 'dashboard' ? ' active' : '' ?>" href="dashboard.php">Dashboard</a></li>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <li class="nav-item"><a class="nav-link<?= $currentPage === 'manage_courses' ? ' active' : '' ?>" href="manage_courses.php">Manage courses</a></li>
            <?php endif; ?>
            <li class="nav-item"><a class="nav-link" href="enroll.php">Courses</a></li>
            <li class="nav-item"><a class="nav-link nav-link-quiet" href="logout.php">Log out</a></li>
        <?php else: ?>
            <li class="nav-item"><a class="nav-link<?= $currentPage === 'login' ? ' active' : '' ?>" href="login.php">Log in</a></li>
            <li class="nav-item"><a class="nav-link nav-link-cta<?= $currentPage === 'register' ? ' active' : '' ?>" href="register.php">Create account <span aria-hidden="true">→</span></a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<main class="container page-container">