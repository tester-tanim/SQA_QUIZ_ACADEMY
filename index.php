<?php
session_start();
require_once 'config/database.php';

// Initialize database
initializeDatabase();
$pdo = getDBConnection();

// Get categories
$stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQA Quiz Academy - Master Software Quality Assurance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --success-color: #27ae60;
            --warning-color: #f39c12;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .hero-section {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem;
            margin: 2rem 0;
            text-align: center;
            color: white;
        }
        
        .category-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .category-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--secondary-color);
        }
        
        .btn-primary {
            background: var(--secondary-color);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }
        
        .stats-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            margin: 1rem 0;
        }
        
        .footer {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: rgba(0,0,0,0.8);">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-graduation-cap me-2"></i>SQA Quiz Academy
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Hero Section -->
        <div class="hero-section">
            <h1 class="display-4 mb-4">
                <i class="fas fa-code me-3"></i>Welcome to SQA Quiz Academy
            </h1>
            <p class="lead mb-4">Master Software Quality Assurance through interactive quizzes and comprehensive learning</p>
            <p class="mb-4">Test your knowledge across 10 specialized SQA domains with timed quizzes and detailed explanations</p>
            <?php if(!isset($_SESSION['user_id'])): ?>
                <a href="register.php" class="btn btn-primary btn-lg me-3">
                    <i class="fas fa-user-plus me-2"></i>Get Started
                </a>
                <a href="login.php" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </a>
            <?php endif; ?>
        </div>

        <!-- Statistics -->
        <div class="row mb-5">
            <div class="col-md-4">
                <div class="stats-card">
                    <i class="fas fa-question-circle fa-3x text-primary mb-3"></i>
                    <h3>500+</h3>
                    <p class="text-muted">Questions Available</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <i class="fas fa-users fa-3x text-success mb-3"></i>
                    <h3>1000+</h3>
                    <p class="text-muted">Active Learners</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <i class="fas fa-trophy fa-3x text-warning mb-3"></i>
                    <h3>10</h3>
                    <p class="text-muted">SQA Categories</p>
                </div>
            </div>
        </div>

        <!-- Quiz Categories -->
        <h2 class="text-center text-white mb-4">
            <i class="fas fa-book-open me-2"></i>Choose Your Quiz Category
        </h2>
        
        <div class="row">
            <?php foreach($categories as $category): ?>
                <div class="col-lg-6 col-xl-4">
                    <div class="category-card">
                        <div class="text-center">
                            <div class="category-icon">
                                <?php
                                $icons = [
                                    'Software Testing Fundamentals' => 'fas fa-cogs',
                                    'Test Planning & Strategy' => 'fas fa-route',
                                    'Test Execution & Management' => 'fas fa-play-circle',
                                    'Automation Testing' => 'fas fa-robot',
                                    'Performance Testing' => 'fas fa-tachometer-alt',
                                    'Security Testing' => 'fas fa-shield-alt',
                                    'API Testing' => 'fas fa-plug',
                                    'Mobile Testing' => 'fas fa-mobile-alt',
                                    'Database Testing' => 'fas fa-database',
                                    'Agile Testing' => 'fas fa-sync-alt'
                                ];
                                $icon = $icons[$category['name']] ?? 'fas fa-question';
                                ?>
                                <i class="<?php echo $icon; ?>"></i>
                            </div>
                            <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                            <p class="card-text text-muted"><?php echo htmlspecialchars($category['description']); ?></p>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <a href="quiz.php?category=<?php echo $category['id']; ?>" class="btn btn-primary">
                                    <i class="fas fa-play me-2"></i>Start Quiz
                                </a>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Start
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-graduation-cap me-2"></i>SQA Quiz Academy</h5>
                    <p>Empowering software quality assurance professionals through interactive learning.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; 2024 SQA Quiz Academy. All rights reserved.</p>
                    <p>Built with <i class="fas fa-heart text-danger"></i> Made By Tanim</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
