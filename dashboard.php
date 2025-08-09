<?php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$pdo = getDBConnection();

// Get user's quiz statistics
$stmt = $pdo->prepare("
    SELECT 
        COUNT(*) as total_quizzes,
        AVG(score) as avg_score,
        SUM(time_taken) as total_time,
        MAX(score) as best_score
    FROM quiz_sessions 
    WHERE user_id = ? AND completed = 1
");
$stmt->execute([$_SESSION['user_id']]);
$stats = $stmt->fetch();

// Get recent quiz sessions
$stmt = $pdo->prepare("
    SELECT qs.*, c.name as category_name
    FROM quiz_sessions qs
    LEFT JOIN categories c ON qs.category_id = c.id
    WHERE qs.user_id = ?
    ORDER BY qs.started_at DESC
    LIMIT 5
");
$stmt->execute([$_SESSION['user_id']]);
$recent_quizzes = $stmt->fetchAll();

// Get categories
$stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SQA Quiz Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .dashboard-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
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
        
        .btn-primary {
            background: #3498db;
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }
        
        .recent-quiz-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid #3498db;
        }
        
        .welcome-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            text-align: center;
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
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <h2><i class="fas fa-user-circle me-2"></i>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p class="mb-0">Ready to test your SQA knowledge? Choose a category below to start a new quiz.</p>
        </div>

        <div class="dashboard-container">
            <!-- Statistics -->
            <h3 class="mb-4"><i class="fas fa-chart-bar me-2"></i>Your Statistics</h3>
            <div class="row">
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-trophy fa-2x mb-2"></i>
                        <h4><?php echo $stats['total_quizzes'] ?? 0; ?></h4>
                        <p class="mb-0">Quizzes Taken</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-star fa-2x mb-2"></i>
                        <h4><?php echo round($stats['avg_score'] ?? 0, 1); ?>%</h4>
                        <p class="mb-0">Average Score</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-crown fa-2x mb-2"></i>
                        <h4><?php echo $stats['best_score'] ?? 0; ?>%</h4>
                        <p class="mb-0">Best Score</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-clock fa-2x mb-2"></i>
                        <h4><?php echo round(($stats['total_time'] ?? 0) / 60, 1); ?>m</h4>
                        <p class="mb-0">Total Time</p>
                    </div>
                </div>
            </div>

            <!-- Quiz Categories -->
            <h3 class="mb-4 mt-5"><i class="fas fa-book-open me-2"></i>Start a New Quiz</h3>
            <div class="row">
                <?php foreach($categories as $category): ?>
                    <div class="col-lg-6 col-xl-4">
                        <div class="category-card">
                            <div class="text-center">
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
                                <div class="mb-3">
                                    <i class="<?php echo $icon; ?> fa-3x text-primary"></i>
                                </div>
                                <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                                <p class="card-text text-muted"><?php echo htmlspecialchars($category['description']); ?></p>
                                <a href="quiz.php?category=<?php echo $category['id']; ?>" class="btn btn-primary">
                                    <i class="fas fa-play me-2"></i>Start Quiz
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Recent Quizzes -->
            <?php if (!empty($recent_quizzes)): ?>
                <h3 class="mb-4 mt-5"><i class="fas fa-history me-2"></i>Recent Quizzes</h3>
                <div class="row">
                    <div class="col-12">
                        <?php foreach($recent_quizzes as $quiz): ?>
                            <div class="recent-quiz-item">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($quiz['category_name']); ?></h6>
                                        <small class="text-muted">
                                            <?php echo date('M j, Y g:i A', strtotime($quiz['started_at'])); ?>
                                        </small>
                                    </div>
                                    <div class="col-md-3">
                                        <span class="badge bg-primary">Score: <?php echo $quiz['score']; ?>%</span>
                                    </div>
                                    <div class="col-md-3">
                                        <span class="text-muted">
                                            Time: <?php echo round($quiz['time_taken'] / 60, 1); ?> minutes
                                        </span>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <?php if ($quiz['completed']): ?>
                                            <span class="badge bg-success">Completed</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">In Progress</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
