<?php
session_start();
$user = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>eSports Arena</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #181a1b; color: #fff; font-family: 'Poppins', sans-serif; }
        .navbar { background: #222; }
        .hero { background: linear-gradient(120deg, #ff0057 0%, #2b2bff 100%); color: #fff; padding: 80px 0 60px 0; }
        .hero h1 { font-size: 3rem; font-weight: 700; }
        .card { background: #23272b; color: #fff; }
        .section-title { color: #ff0057; font-weight: 700; }
        .footer { background: #222; color: #fff; }
        .btn-main { background: #ff0057; color: #fff; border: none; }
        .btn-main:hover { background: #d9004c; }
        .profile-pic { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; }
        .modal-content {
    color: #212529 !important;
}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#"><i class="bi bi-controller"></i> eSports Arena</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#tournaments">Tournaments</a></li>
                <li class="nav-item"><a class="nav-link" href="#news">News</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                <?php if($user): ?>
                    <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="bi bi-person-circle"></i> <?=htmlspecialchars($user['name'])?></a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="#loginModal" data-bs-toggle="modal"><i class="bi bi-box-arrow-in-right"></i> Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="#signupModal" data-bs-toggle="modal"><i class="bi bi-person-plus"></i> Signup</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<section class="hero text-center">
    <div class="container">
        <h1>Welcome to eSports Arena</h1>
        <p class="lead mb-4">Join, compete, and rise to the top in the ultimate online gaming tournaments.</p>
        <?php if(!$user): ?>
            <a href="#signupModal" class="btn btn-main btn-lg" data-bs-toggle="modal">Get Started</a>
        <?php else: ?>
            <a href="dashboard.php" class="btn btn-main btn-lg">Go to Dashboard</a>
        <?php endif; ?>
    </div>
</section>

<section class="py-5" id="tournaments">
    <div class="container">
        <h2 class="section-title mb-4">Upcoming Tournaments</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card p-3 h-100">
                    <h5 class="card-title">DOTA 2: Battle Royale</h5>
                    <p class="card-text">Starts: 2025-06-10<br>Prize: $5,000</p>
                    <a href="#" class="btn btn-main btn-sm">View Details</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 h-100">
                    <h5 class="card-title">VALORANT: Champions Cup</h5>
                    <p class="card-text">Starts: 2025-06-15<br>Prize: $3,000</p>
                    <a href="#" class="btn btn-main btn-sm">View Details</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 h-100">
                    <h5 class="card-title">CODM: Mobile Masters</h5>
                    <p class="card-text">Starts: 2025-06-20<br>Prize: $2,000</p>
                    <a href="#" class="btn btn-main btn-sm">View Details</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-dark" id="news">
    <div class="container">
        <h2 class="section-title mb-4">Latest News</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card p-3 h-100">
                    <h5 class="card-title">Arena Update: New Games Added!</h5>
                    <p class="card-text">We’re excited to announce the addition of Fortnite and League of Legends to our tournament lineup.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 h-100">
                    <h5 class="card-title">Congratulations to Last Month’s Winners!</h5>
                    <p class="card-text">See the highlights and replays from our May tournaments.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" id="about">
    <div class="container">
        <h2 class="section-title mb-4">About eSports Arena</h2>
        <div class="row align-items-center">
            <div class="col-md-8">
                <p class="lead">eSports Arena is the hub for competitive gamers. We host regular tournaments, provide fair play, and foster a vibrant gaming community. Whether you’re a pro or just starting, you belong here!</p>
                <ul>
                    <li>Weekly and monthly tournaments</li>
                    <li>Secure, fair, and fun environment</li>
                    <li>Community events and leaderboards</li>
                </ul>
            </div>
            <div class="col-md-4 text-center">
                <img src="assets/img/hero.png" alt="About" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-dark" id="contact">
    <div class="container">
        <h2 class="section-title mb-4">Contact Us</h2>
        <div class="row g-4">
            <div class="col-md-4 d-flex align-items-center">
                <i class="bi bi-envelope-fill fs-2 me-3 text-danger"></i>
                <a href="mailto:arena@esports.com" class="text-white text-decoration-none">arena@esports.com</a>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <i class="bi bi-telephone-fill fs-2 me-3 text-danger"></i>
                <a href="tel:+1234567890" class="text-white text-decoration-none">+1 234 567 890</a>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-share-fill fs-2 me-3 text-danger"></i>
                    <span>Follow us:</span>
                </div>
                <div>
                    <a href="#" class="text-white me-2"><i class="bi bi-twitter fs-4"></i></a>
                    <a href="#" class="text-white me-2"><i class="bi bi-facebook fs-4"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-instagram fs-4"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content text-dark needs-validation" method="post" action="login.php" autocomplete="off" novalidate>
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="loginEmail" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="loginEmail" required autocomplete="username">
                    <div class="invalid-feedback">Please enter your email.</div>
                </div>
                <div class="mb-3">
                    <label for="loginPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="loginPassword" required autocomplete="current-password">
                    <div class="invalid-feedback">Please enter your password.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-main">Login</button>
            </div>
        </form>
    </div>
</div>

<!-- Signup Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content text-dark needs-validation" method="post" action="signup.php" autocomplete="off" novalidate>
            <div class="modal-header">
                <h5 class="modal-title" id="signupModalLabel">Signup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="signupName" class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="name" id="signupName" required autocomplete="name">
                    <div class="invalid-feedback">Please enter your name.</div>
                </div>
                <div class="mb-3">
                    <label for="signupEmail" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="signupEmail" required autocomplete="email">
                    <div class="invalid-feedback">Please enter a valid email.</div>
                </div>
                <div class="mb-3">
                    <label for="signupPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="signupPassword" required autocomplete="new-password">
                    <div class="invalid-feedback">Please enter a password.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-main">Signup</button>
            </div>
        </form>
    </div>
</div>

<footer class="footer py-4 mt-5 text-center">
    <div class="container">
        <div class="mb-2">
            <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i></a>
            <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
            <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
        </div>
        <p class="mb-0">&copy; <?=date('Y')?> eSports Arena. All rights reserved.</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>