<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$pdo = getDBConnection();

// Get statistics
$stmt = $pdo->query("SELECT COUNT(*) as total_users FROM users WHERE role = 'user'");
$total_users = $stmt->fetch()['total_users'];

$stmt = $pdo->query("SELECT COUNT(*) as total_questions FROM questions");
$total_questions = $stmt->fetch()['total_questions'];

$stmt = $pdo->query("SELECT COUNT(*) as total_quizzes FROM quiz_sessions WHERE completed = 1");
$total_quizzes = $stmt->fetch()['total_quizzes'];

$stmt = $pdo->query("SELECT COUNT(*) as total_categories FROM categories");
$total_categories = $stmt->fetch()['total_categories'];

// Get recent quiz sessions (excluding admin users)
$stmt = $pdo->query("
    SELECT qs.*, u.username, c.name as category_name
    FROM quiz_sessions qs
    JOIN users u ON qs.user_id = u.id
    LEFT JOIN categories c ON qs.category_id = c.id
    WHERE qs.completed = 1 AND u.role = 'user'
    ORDER BY qs.completed_at DESC
    LIMIT 10
");
$recent_quizzes = $stmt->fetchAll();

// Get questions by category
$stmt = $pdo->query("
    SELECT c.name, COUNT(q.id) as question_count
    FROM categories c
    LEFT JOIN questions q ON c.id = q.category_id
    GROUP BY c.id, c.name
    ORDER BY question_count DESC
");
$questions_by_category = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SQA Quiz Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .admin-container {
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
        
        .admin-nav-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        
        .admin-nav-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            color: inherit;
            text-decoration: none;
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
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
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
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-graduation-cap me-2"></i>SQA Quiz Academy
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Admin Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <h2><i class="fas fa-user-shield me-2"></i>Admin Dashboard</h2>
            <p class="mb-0">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! Manage your SQA Quiz Academy.</p>
        </div>

        <div class="admin-container">
            <!-- Statistics -->
            <h3 class="mb-4"><i class="fas fa-chart-bar me-2"></i>Overview Statistics</h3>
            <div class="row">
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <h4><?php echo $total_users; ?></h4>
                        <p class="mb-0">Total Users</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-question-circle fa-2x mb-2"></i>
                        <h4><?php echo $total_questions; ?></h4>
                        <p class="mb-0">Total Questions</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-trophy fa-2x mb-2"></i>
                        <h4><?php echo $total_quizzes; ?></h4>
                        <p class="mb-0">Completed Quizzes</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-folder fa-2x mb-2"></i>
                        <h4><?php echo $total_categories; ?></h4>
                        <p class="mb-0">Categories</p>
                    </div>
                </div>
            </div>

            <!-- Admin Navigation -->
            <h3 class="mb-4 mt-5"><i class="fas fa-cogs me-2"></i>Admin Functions</h3>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <a href="questions.php" class="admin-nav-card">
                        <div class="text-center">
                            <i class="fas fa-question-circle fa-3x text-primary mb-3"></i>
                            <h5>Manage Questions</h5>
                            <p class="text-muted">Add, edit, and delete quiz questions</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="categories.php" class="admin-nav-card">
                        <div class="text-center">
                            <i class="fas fa-folder fa-3x text-success mb-3"></i>
                            <h5>Manage Categories</h5>
                            <p class="text-muted">Organize questions by categories</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="import_questions.php" class="admin-nav-card">
                        <div class="text-center">
                            <i class="fas fa-upload fa-3x text-warning mb-3"></i>
                            <h5>Import Questions</h5>
                            <p class="text-muted">Bulk import questions via JSON</p>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6">
                    <a href="reports.php" class="admin-nav-card">
                        <div class="text-center">
                            <i class="fas fa-chart-line fa-3x text-danger mb-3"></i>
                            <h5>Reports & Analytics</h5>
                            <p class="text-muted">View detailed quiz statistics</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="settings.php" class="admin-nav-card">
                        <div class="text-center">
                            <i class="fas fa-cog fa-3x text-secondary mb-3"></i>
                            <h5>System Settings</h5>
                            <p class="text-muted">Configure quiz timer and other settings</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Questions by Category -->
            <h3 class="mb-4 mt-5"><i class="fas fa-chart-pie me-2"></i>Questions by Category</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Question Distribution</h5>
                            <?php foreach($questions_by_category as $cat): ?>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span><?php echo htmlspecialchars($cat['name']); ?></span>
                                    <span class="badge bg-primary"><?php echo $cat['question_count']; ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Quiz Activity -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Recent Quiz Activity</h5>
                            <?php if (!empty($recent_quizzes)): ?>
                                <?php foreach($recent_quizzes as $quiz): ?>
                                    <div class="recent-quiz-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong><?php echo htmlspecialchars($quiz['username']); ?></strong><br>
                                                <small class="text-muted"><?php echo htmlspecialchars($quiz['category_name']); ?></small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-success"><?php echo $quiz['score']; ?>%</span><br>
                                                <small class="text-muted"><?php echo date('M j, g:i A', strtotime($quiz['completed_at'])); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted">No recent quiz activity</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
