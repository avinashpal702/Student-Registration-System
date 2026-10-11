<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'config/database.php';

$stmt = $pdo->prepare('SELECT name FROM users WHERE id = :id');
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    $_SESSION = [];
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
<?php require 'includes/header.php'; ?>

<section class="dashboard-welcome">
    <span class="eyebrow"><span class="eyebrow-dot"></span> YOUR LEARNING SPACE</span>
    <h1>Welcome, <?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?><span class="welcome-period">!</span></h1>
    <p>Make today a little more interesting. Your next good idea could start with a course.</p>
</section>
<section class="dashboard-grid">
    <a class="dashboard-card dashboard-card-primary" href="enroll.php">
        <span class="dashboard-icon" aria-hidden="true">↗</span>
        <span class="dashboard-card-label">KEEP EXPLORING</span>
        <h2>Find a course</h2>
        <p>Browse what’s available and take your next step.</p>
        <span class="dashboard-card-link">Explore courses <span aria-hidden="true">→</span></span>
    </a>
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <a class="dashboard-card dashboard-card-secondary" href="manage_courses.php">
            <span class="dashboard-icon" aria-hidden="true">✳</span>
            <span class="dashboard-card-label">ADMIN TOOLS</span>
            <h2>Manage courses</h2>
            <p>Add courses, update details, and manage places.</p>
            <span class="dashboard-card-link">Open course manager <span aria-hidden="true">→</span></span>
        </a>
    <?php endif; ?>
</section>

<?php require 'includes/footer.php'; ?>