<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$pdo = getDBConnection();
$message = '';
$error = '';

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_settings'])) {
    $quiz_timer = (int)$_POST['quiz_timer_minutes'];
    $questions_per_quiz = (int)$_POST['questions_per_quiz'];
    $passing_score = (int)$_POST['passing_score'];
    
    // Validate inputs
    if ($quiz_timer < 1 || $quiz_timer > 180) {
        $error = 'Quiz timer must be between 1 and 180 minutes';
    } elseif ($questions_per_quiz < 1 || $questions_per_quiz > 50) {
        $error = 'Questions per quiz must be between 1 and 50';
    } elseif ($passing_score < 0 || $passing_score > 100) {
        $error = 'Passing score must be between 0 and 100';
    } else {
        // Update settings
        updateSetting('quiz_timer_minutes', $quiz_timer);
        updateSetting('questions_per_quiz', $questions_per_quiz);
        updateSetting('passing_score', $passing_score);
        
        $message = 'Settings updated successfully!';
    }
}

// Get current settings
$quiz_timer = (int)getSetting('quiz_timer_minutes', 30);
$questions_per_quiz = (int)getSetting('questions_per_quiz', 10);
$passing_score = (int)getSetting('passing_score', 70);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Settings - SQA Quiz Academy</title>
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
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .settings-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #3498db;
        }
        
        .form-label {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .help-text {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 0.25rem;
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
                        <a class="nav-link" href="dashboard.php">Admin Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="questions.php">Questions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="import_questions.php">Import</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="settings.php">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="admin-container">
            <h2><i class="fas fa-cog me-2"></i>System Settings</h2>
            
            <?php if ($message): ?>
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <!-- Settings Form -->
            <form method="POST">
                <div class="settings-card">
                    <h5><i class="fas fa-clock me-2"></i>Quiz Timer Settings</h5>
                    <div class="mb-3">
                        <label for="quiz_timer_minutes" class="form-label">Quiz Timer Duration (minutes)</label>
                        <input type="number" class="form-control" id="quiz_timer_minutes" name="quiz_timer_minutes" 
                               value="<?php echo $quiz_timer; ?>" min="1" max="180" required>
                        <div class="help-text">Set the default time limit for quizzes (1-180 minutes)</div>
                    </div>
                </div>

                <div class="settings-card">
                    <h5><i class="fas fa-question-circle me-2"></i>Quiz Configuration</h5>
                    <div class="mb-3">
                        <label for="questions_per_quiz" class="form-label">Questions per Quiz</label>
                        <input type="number" class="form-control" id="questions_per_quiz" name="questions_per_quiz" 
                               value="<?php echo $questions_per_quiz; ?>" min="1" max="50" required>
                        <div class="help-text">Number of questions displayed in each quiz (1-50 questions)</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="passing_score" class="form-label">Passing Score (%)</label>
                        <input type="number" class="form-control" id="passing_score" name="passing_score" 
                               value="<?php echo $passing_score; ?>" min="0" max="100" required>
                        <div class="help-text">Minimum score required to pass a quiz (0-100%)</div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" name="update_settings" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Settings
                    </button>
                    <a href="dashboard.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </form>

            <!-- Current Settings Summary -->
            <div class="mt-4">
                <h5><i class="fas fa-info-circle me-2"></i>Current Settings Summary</h5>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Quiz Timer:</strong> <?php echo $quiz_timer; ?> minutes
                            </div>
                            <div class="col-md-4">
                                <strong>Questions per Quiz:</strong> <?php echo $questions_per_quiz; ?> questions
                            </div>
                            <div class="col-md-4">
                                <strong>Passing Score:</strong> <?php echo $passing_score; ?>%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
