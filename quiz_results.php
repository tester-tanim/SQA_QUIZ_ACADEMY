<?php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$pdo = getDBConnection();

// Get session ID
$session_id = isset($_GET['session_id']) ? (int)$_GET['session_id'] : 0;

if (!$session_id) {
    header('Location: dashboard.php');
    exit();
}

// Get quiz session details
$stmt = $pdo->prepare("
    SELECT qs.*, c.name as category_name, c.description as category_description
    FROM quiz_sessions qs
    LEFT JOIN categories c ON qs.category_id = c.id
    WHERE qs.id = ? AND qs.user_id = ?
");
$stmt->execute([$session_id, $_SESSION['user_id']]);
$session = $stmt->fetch();

if (!$session) {
    header('Location: dashboard.php');
    exit();
}

// Get quiz answers with questions
$stmt = $pdo->prepare("
    SELECT qa.*, q.question_text, q.option_a, q.option_b, q.option_c, q.option_d, q.correct_answer, q.explanation
    FROM quiz_answers qa
    JOIN questions q ON qa.question_id = q.id
    WHERE qa.session_id = ?
    ORDER BY qa.id
");
$stmt->execute([$session_id]);
$answers = $stmt->fetchAll();

// Calculate statistics
$total_questions = count($answers);
$correct_answers = 0;
$incorrect_answers = 0;

foreach ($answers as $answer) {
    if ($answer['is_correct']) {
        $correct_answers++;
    } else {
        $incorrect_answers++;
    }
}

$percentage = round(($correct_answers / $total_questions) * 100);
$time_taken_minutes = round($session['time_taken'] / 60, 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results - SQA Quiz Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .results-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        
        .score-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 2px solid #e9ecef;
        }
        
        .question-review {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 2px solid #e9ecef;
        }
        
        .correct-answer {
            background: #d4edda;
            border: 2px solid #c3e6cb;
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1rem;
        }
        
        .incorrect-answer {
            background: #f8d7da;
            border: 2px solid #f5c6cb;
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1rem;
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
        
        .score-circle {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: conic-gradient(#27ae60 0deg <?php echo $percentage * 3.6; ?>deg, #e9ecef <?php echo $percentage * 3.6; ?>deg 360deg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            position: relative;
        }
        
        .score-circle::before {
            content: '';
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 50%;
            position: absolute;
        }
        
        .score-text {
            position: relative;
            z-index: 1;
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
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
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="results-container">
            <!-- Score Display -->
            <div class="score-card">
                <h2><i class="fas fa-trophy me-2"></i>Quiz Results</h2>
                <div class="score-circle">
                    <div class="score-text"><?php echo $percentage; ?>%</div>
                </div>
                <h4><?php echo htmlspecialchars($session['category_name']); ?></h4>
                <p class="mb-0"><?php echo htmlspecialchars($session['category_description']); ?></p>
            </div>

            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h4><?php echo $correct_answers; ?></h4>
                    <p class="mb-0">Correct Answers</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                    <h4><?php echo $incorrect_answers; ?></h4>
                    <p class="mb-0">Incorrect Answers</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-clock fa-2x text-primary mb-2"></i>
                    <h4><?php echo $time_taken_minutes; ?>m</h4>
                    <p class="mb-0">Time Taken</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-calendar fa-2x text-info mb-2"></i>
                    <h4><?php echo date('M j, Y', strtotime($session['completed_at'])); ?></h4>
                    <p class="mb-0">Completed Date</p>
                </div>
            </div>

            <!-- Performance Message -->
            <div class="text-center mb-4">
                <?php if ($percentage >= 90): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-star me-2"></i><strong>Excellent!</strong> Outstanding performance! You have mastered this topic.
                    </div>
                <?php elseif ($percentage >= 80): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-thumbs-up me-2"></i><strong>Great job!</strong> Very good understanding of the material.
                    </div>
                <?php elseif ($percentage >= 70): ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-check me-2"></i><strong>Good work!</strong> You have a solid understanding with room for improvement.
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i><strong>Keep practicing!</strong> Review the material and try again.
                    </div>
                <?php endif; ?>
            </div>

            <!-- Question Review -->
            <h3 class="mb-4"><i class="fas fa-list-alt me-2"></i>Question Review</h3>
            <?php foreach($answers as $index => $answer): ?>
                <div class="question-review">
                    <h5>
                        <span class="badge bg-primary me-2"><?php echo $index + 1; ?></span>
                        <?php echo htmlspecialchars($answer['question_text']); ?>
                    </h5>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>A.</strong> <?php echo htmlspecialchars($answer['option_a']); ?></p>
                            <p><strong>B.</strong> <?php echo htmlspecialchars($answer['option_b']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>C.</strong> <?php echo htmlspecialchars($answer['option_c']); ?></p>
                            <p><strong>D.</strong> <?php echo htmlspecialchars($answer['option_d']); ?></p>
                        </div>
                    </div>
                    
                    <?php if ($answer['is_correct']): ?>
                        <div class="correct-answer">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Correct!</strong> Your answer: <?php echo $answer['user_answer']; ?>
                        </div>
                    <?php else: ?>
                        <div class="incorrect-answer">
                            <i class="fas fa-times-circle text-danger me-2"></i>
                            <strong>Incorrect.</strong> Your answer: <?php echo $answer['user_answer']; ?><br>
                            <strong>Correct answer:</strong> <?php echo $answer['correct_answer']; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($answer['explanation'])): ?>
                        <div class="mt-3 p-3 bg-light rounded">
                            <strong><i class="fas fa-lightbulb me-2"></i>Explanation:</strong><br>
                            <?php echo htmlspecialchars($answer['explanation']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <!-- Action Buttons -->
            <div class="text-center mt-4">
                <a href="quiz.php?category=<?php echo $session['category_id']; ?>" class="btn btn-primary me-3">
                    <i class="fas fa-redo me-2"></i>Retake Quiz
                </a>
                <a href="dashboard.php" class="btn btn-outline-primary me-3">
                    <i class="fas fa-home me-2"></i>Back to Dashboard
                </a>
                <a href="index.php" class="btn btn-outline-secondary">
                    <i class="fas fa-list me-2"></i>All Categories
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
