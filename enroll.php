<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'config/database.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_id'])) {
    $courseId = (int)$_POST['course_id'];
    // check availability
    $stmt = $pdo->prepare('SELECT available_places FROM courses WHERE id = :id');
    $stmt->execute([':id' => $courseId]);
    $course = $stmt->fetch();

    if ($course && $course['available_places'] > 0) {
        // prevent duplicate enrollment
        $stmt = $pdo->prepare('SELECT id FROM enrollments WHERE user_id = :uid AND course_id = :cid');
        $stmt->execute([':uid' => $_SESSION['user_id'], ':cid' => $courseId]);
        if (!$stmt->fetch()) {
            $pdo->beginTransaction();
            try {
                // insert enrollment
                $ins = $pdo->prepare(
                    'INSERT INTO enrollments (user_id, course_id, registration_date) 
                     VALUES (:uid, :cid, NOW())'
                );
                $ins->execute([':uid' => $_SESSION['user_id'], ':cid' => $courseId]);

                // decrement available places
                $dec = $pdo->prepare('UPDATE courses SET available_places = available_places - 1 WHERE id = :cid');
                $dec->execute([':cid' => $courseId]);

                $pdo->commit();
                $msg = 'Enrolled successfully!';
            } catch (Exception $e) {
                $pdo->rollBack();
                $msg = 'Enrollment failed.';
            }
        } else {
            $msg = 'You are already enrolled in this course.';
        }
    } else {
        $msg = 'Course is full or does not exist.';
    }
}
?>
<?php require 'includes/header.php'; ?>

<?php if ($msg): ?>
    <div class="alert alert-info enrollment-message"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<section class="course-section course-page-section">
    <div class="section-heading">
        <div>
            <span class="eyebrow">CHOOSE WHAT’S NEXT</span>
            <h1>Available courses</h1>
        </div>
        <span class="section-aside">Small steps. Big possibilities.</span>
    </div>
    <div id="course-list" class="row course-grid" aria-live="polite">
        <div class="col-12"><p class="course-loading">Finding courses for you…</p></div>
    </div>
</section>

<?php require 'includes/footer.php'; ?>