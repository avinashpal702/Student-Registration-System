<?php
session_start();
require_once 'config/database.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pwd   = $_POST['password'] ?? '';

    if (!$email || !$pwd) {
        $errors[] = 'Both fields are required.';
    } else {
        $stmt = $pdo->prepare('SELECT id, password_hash, role FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($pwd, $user['password_hash'])) {
            // Regenerate session ID to prevent fixation
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role']    = $user['role'];
            header('Location: dashboard.php');
            exit;
        } else {
            $errors[] = 'Invalid credentials.';
        }
    }
}
?>
<?php require 'includes/header.php'; ?>

<section class="auth-layout">
    <div class="auth-aside">
        <span class="eyebrow"><span class="eyebrow-dot"></span> GOOD TO HAVE YOU BACK</span>
        <h1>Your next step<br>is waiting.</h1>
        <p>Pick up where you left off and keep building the skills that move you forward.</p>
        <div class="aside-decoration" aria-hidden="true"><span>01</span><span>LEARN · MAKE · GROW</span></div>
    </div>
    <div class="auth-panel">
        <span class="form-kicker">WELCOME BACK</span>
        <h2>Log in to your account</h2>
        <p class="form-intro">Enter your details to continue.</p>

        <?php if ($errors): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" class="auth-form">
            <div class="mb-3">
                <label class="form-label" for="login-email">Email address</label>
                <input id="login-email" type="email" name="email" class="form-control" autocomplete="email" required value="<?= htmlspecialchars($email ?? '') ?>">
            </div>
            <div class="mb-4">
                <label class="form-label" for="login-password">Password</label>
                <input id="login-password" type="password" name="password" class="form-control" autocomplete="current-password" required>
            </div>
            <button type="submit" class="btn btn-brand w-100">Log in <span aria-hidden="true">→</span></button>
        </form>
        <p class="auth-switch">New to StudentSpace? <a href="register.php">Create an account</a></p>
    </div>
</section>

<?php require 'includes/footer.php'; ?>