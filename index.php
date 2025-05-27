<?php
session_start();
require_once 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FJWU Complaint Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1B4D3E;
            --secondary-color: #2E7D32;
            --accent-color: #4CAF50;
            --light-bg: #F5F5F5;
            --dark-bg: #1B4D3E;
            --text-light: #FFFFFF;
            --text-dark: #333333;
            --card-shadow: 0 0.15rem 1.75rem 0 rgba(27, 77, 62, 0.1);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
        }

        /* Navbar Styles */
        .navbar {
            background-color: var(--primary-color);
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            color: var(--text-light) !important;
            font-weight: 600;
        }

        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }

        .nav-link {
            color: var(--text-light) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--accent-color) !important;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(27, 77, 62, 0.9), rgba(27, 77, 62, 0.9)),
                        url('assets/images/fjwu.jpg') center/cover;
            color: var(--text-light);
            padding: 100px 0;
            text-align: center;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        /* Features Section */
        .features-section {
            padding: 80px 0;
            background-color: var(--light-bg);
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--dark-bg);
        }

        .feature-text {
            color: var(--text-dark);
            opacity: 0.8;
        }

        /* CTA Section */
        .cta-section {
            background-color: var(--primary-color);
            color: var(--text-light);
            padding: 80px 0;
            text-align: center;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .cta-text {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .btn-cta {
            background-color: var(--accent-color);
            color: var(--text-light);
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-cta:hover {
            background-color: #43A047;
            transform: translateY(-2px);
            color: var(--text-light);
        }

        /* Footer */
        .footer {
            background-color: var(--dark-bg);
            color: var(--text-light);
            padding: 40px 0;
        }

        .footer-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .footer-text {
            opacity: 0.8;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: var(--text-light);
            text-decoration: none;
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            opacity: 1;
            color: var(--accent-color);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="https://th.bing.com/th/id/OIP.80_ByCfld7QYhQWVYgm_ggAAAA?cb=iwc2&rs=1&pid=ImgDetMain" alt="FJWU Logo">
                FJWU Complaint System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard/">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="auth/logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="auth/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="auth/register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Welcome to FJWU Complaint Management System</h1>
            <p class="hero-subtitle">Your voice matters. Submit, track, and resolve complaints efficiently.</p>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="auth/register.php" class="btn btn-cta">Get Started</a>
            <?php else: ?>
                <a href="dashboard/" class="btn btn-cta">Go to Dashboard</a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-comment-alt"></i>
                        </div>
                        <h3 class="feature-title">Easy Complaint Submission</h3>
                        <p class="feature-text">Submit your complaints easily through our user-friendly interface. Choose from various categories and provide detailed information.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h3 class="feature-title">Track Progress</h3>
                        <p class="feature-text">Monitor the status of your complaints in real-time. Get updates on the progress and resolution of your issues.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">Secure Platform</h3>
                        <p class="feature-text">Your data is protected with advanced security measures. We ensure confidentiality and privacy of all submissions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" id="about">
        <div class="container">
            <h2 class="cta-title">Ready to Make a Difference?</h2>
            <p class="cta-text">Join our community and help us improve the university experience for everyone.</p>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="auth/register.php" class="btn btn-cta">Register Now</a>
            <?php else: ?>
                <a href="dashboard/" class="btn btn-cta">Go to Dashboard</a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="footer-title">About FJWU</h3>
                    <p class="footer-text">Fatima Jinnah Women University is committed to providing quality education and maintaining a conducive learning environment for all students.</p>
                </div>
                <div class="col-md-3">
                    <h3 class="footer-title">Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h3 class="footer-title">Contact Us</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-phone me-2"></i> +92 51 1234567</li>
                        <li><i class="fas fa-envelope me-2"></i> info@fjwu.edu.pk</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i> Rawalpindi, Pakistan</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
