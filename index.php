<?php
session_start();
require_once 'includes/header.php';
?>

<section class="hero-section">
    <div class="hero-copy">
        <span class="eyebrow"><span class="eyebrow-dot"></span> YOUR NEXT CHAPTER STARTS HERE</span>
        <h1>Learn something<br><span>that moves you.</span></h1>
        <p>Find a course that sparks your curiosity, build practical skills, and take your next step with confidence.</p>
        <div class="hero-actions">
            <a class="btn btn-brand btn-lg" href="<?= isset($_SESSION['user_id']) ? 'enroll.php' : 'register.php' ?>">
                Explore courses <span aria-hidden="true">↗</span>
            </a>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a class="hero-secondary-link" href="login.php">Already have an account? Log in</a>
            <?php endif; ?>
        </div>
        <div class="hero-note"><span class="note-check" aria-hidden="true">✓</span> Flexible learning. Real-world skills.</div>
    </div>
    <div class="hero-art" aria-hidden="true">
        <div class="art-orbit orbit-one"></div>
        <div class="art-orbit orbit-two"></div>
        <div class="art-card art-card-back">
            <span class="art-card-icon icon-purple">⌘</span>
            <span class="art-card-label">CREATE</span>
            <span class="art-card-title">Build your<br>next idea</span>
            <span class="art-card-line"></span>
        </div>
        <div class="art-card art-card-front">
            <span class="art-card-icon icon-lime">✳</span>
            <span class="art-card-label">GROW</span>
            <span class="art-card-title">Skills for<br>what’s next</span>
            <span class="art-card-line"></span>
        </div>
        <div class="art-spark spark-one">✦</div>
        <div class="art-spark spark-two">✳</div>
    </div>
</section>

<section class="course-section">
    <div class="section-heading">
        <div>
            <span class="eyebrow">A GOOD PLACE TO BEGIN</span>
            <h2>Find your next course</h2>
        </div>
        <a class="text-link" href="<?= isset($_SESSION['user_id']) ? 'enroll.php' : 'register.php' ?>">View all courses <span aria-hidden="true">→</span></a>
    </div>
    <div id="course-list" class="row course-grid" aria-live="polite">
        <div class="col-12"><p class="course-loading">Finding courses for you…</p></div>
    </div>
</section>
<?php
require_once 'includes/footer.php';
?>