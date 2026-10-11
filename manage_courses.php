<?php
session_start();
if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
require_once 'config/database.php';
require_once 'classes/Course.php';

$courseObj = new Course($pdo);
$action = $_GET['action'] ?? '';
$errors = [];
$msg    = '';

// ----- CREATE -----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create') {
    $name   = trim($_POST['name'] ?? '');
    $desc   = trim($_POST['description'] ?? '');
    $places = (int)($_POST['available_places'] ?? 0);
    if (!$name || !$desc || $places <= 0) {
        $errors[] = 'All fields are required and places must be >0.';
    } else {
        $courseObj->create($name, $desc, $places);
        $msg = 'Course created.';
    }
}

// ----- UPDATE -----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'edit') {
    $id     = (int)$_POST['id'];
    $name   = trim($_POST['name'] ?? '');
    $desc   = trim($_POST['description'] ?? '');
    $places = (int)($_POST['available_places'] ?? 0);
    if (!$name || !$desc || $places < 0) {
        $errors[] = 'Invalid data.';
    } else {
        $courseObj->update($id, $name, $desc, $places);
        $msg = 'Course updated.';
    }
}

// ----- DELETE -----
if ($action === 'delete' && isset($_GET['id'])) {
    $courseObj->delete((int)$_GET['id']);
    $msg = 'Course deleted.';
}

// Load all courses for listing
$courses = $courseObj->getAll();
?>
<?php require 'includes/header.php'; ?>

<section class="course-section course-page-section">
<div class="section-heading">
    <div>
        <span class="eyebrow">ADMIN TOOLS</span>
        <h1>Manage courses</h1>
    </div>
</div>

<?php if ($msg): ?>
    <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>
<?php if ($errors): ?>
    <div class="alert alert-danger"><ul><?php foreach ($errors as $e) echo "<li>".htmlspecialchars($e)."</li>"; ?></ul></div>
<?php endif; ?>

<!-- CREATE FORM -->
<h4>Add New Course</h4>
<form method="post" class="row g-3 mb-4">
    <input type="hidden" name="action" value="create">
    <div class="col-md-4">
        <input type="text" name="name" class="form-control" placeholder="Course name" required>
    </div>
    <div class="col-md-5">
        <input type="text" name="description" class="form-control" placeholder="Description" required>
    </div>
    <div class="col-md-2">
        <input type="number" name="available_places" class="form-control" placeholder="Places" min="1" required>
    </div>
    <div class="col-md-1">
        <button type="submit" class="btn btn-success">Add</button>
    </div>
</form>

<!-- LIST + EDIT / DELETE -->
<div class="table-responsive">
<table class="table table-striped mb-0">
    <thead><tr><th>ID</th><th>Name</th><th>Description</th><th>Places</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach ($courses as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= htmlspecialchars($c['name']) ?></td>
            <td><?= htmlspecialchars($c['description']) ?></td>
            <td><?= $c['available_places'] ?></td>
            <td>
                <!-- Edit button triggers a modal (simplified inline form) -->
                <button class="btn btn-sm btn-primary" data-bs-toggle="collapse" data-bs-target="#edit<?= $c['id'] ?>">Edit</button>
                <a href="?action=delete&id=<?= $c['id'] ?>" class="btn btn-sm btn-danger"
                   onclick="return confirm('Delete this course?');">Delete</a>
            </td>
        </tr>
        <tr class="collapse" id="edit<?= $c['id'] ?>">
            <td colspan="5">
                <form method="post" class="row g-3">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="<?= $c['id'] ?>">
                    <div class="col-md-3"><input type="text" name="name" class="form-control" value="<?= htmlspecialchars($c['name']) ?>" required></div>
                    <div class="col-md-4"><input type="text" name="description" class="form-control" value="<?= htmlspecialchars($c['description']) ?>" required></div>
                    <div class="col-md-2"><input type="number" name="available_places" class="form-control" value="<?= $c['available_places'] ?>" min="0" required></div>
                    <div class="col-md-3"><button class="btn btn-sm btn-success">Save</button></div>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
</section>

<?php require 'includes/footer.php'; ?>