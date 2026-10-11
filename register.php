<?php
session_start();
require_once 'config/database.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pwd   = $_POST['password'] ?? '';
    $role  = 'student'; // default role

    if (!$name || !$email || !$pwd) {
        $errors[] = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    } else {
        // check for duplicate email
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            $errors[] = 'Email already registered.';
        }
    }

    if (empty($errors)) {
        $hash = password_hash($pwd, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare(
            'INSERT INTO users (name, email, password_hash, role) 
             VALUES (:name, :email, :hash, :role)'
        );
        $stmt->execute([
            ':name'  => $name,
            ':email' => $email,
            ':hash'  => $hash,
            ':role'  => $role,
        ]);
        // auto‑login after registration
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['role']    = $role;
        header('Location: dashboard.php');
        exit;
    }
}
?>
<?php require 'includes/header.php'; ?>

<section class="auth-layout">
    <div class="auth-aside register-aside">
        <span class="eyebrow"><span class="eyebrow-dot"></span> MAKE YOURSELF AT HOME</span>
        <h1>Big things<br>start <span>somewhere.</span></h1>
        <p>Create your account and find the course that takes you one step further.</p>
        <div class="aside-decoration" aria-hidden="true"><span>✳</span><span>YOUR IDEAS BELONG HERE</span></div>
    </div>
    <div class="auth-panel">
        <span class="form-kicker">START HERE</span>
        <h2>Create your account</h2>
        <p class="form-intro">A few details, and you’re on your way.</p>

        <?php if ($errors): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" id="registration-form" class="auth-form">
            <div class="mb-3">
                <label class="form-label" for="register-name">Full name</label>
                <input id="register-name" type="text" name="name" class="form-control" autocomplete="name" required value="<?= htmlspecialchars($name ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="register-email">Email address</label>
                <input id="register-email" type="email" name="email" class="form-control" autocomplete="email" required value="<?= htmlspecialchars($email ?? '') ?>">
            </div>
            <div class="mb-4">
                <label class="form-label" for="register-password">Password</label>
                <input id="register-password" type="password" name="password" class="form-control" autocomplete="new-password" required minlength="6">
                <div class="form-hint">Use at least 6 characters.</div>
            </div>
            <button type="submit" class="btn btn-brand w-100">Create account <span aria-hidden="true">→</span></button>
        </form>
        <p class="auth-switch">Already have an account? <a href="login.php">Log in</a></p>
    </div>
</section>

<?php require 'includes/footer.php'; ?>