<?php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$pdo = getDBConnection();

// Get category ID
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;

if (!$category_id) {
    header('Location: dashboard.php');
    exit();
}

// Get category info
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$category_id]);
$category = $stmt->fetch();

if (!$category) {
    header('Location: dashboard.php');
    exit();
}

// Handle quiz submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_quiz'])) {
    $session_id = $_POST['session_id'];
    $time_taken = $_POST['time_taken'];
    $answers = $_POST['answers'] ?? [];
    
    // Calculate score using the questions that were shown to the user
    if (!isset($_SESSION['quiz_questions']) || empty($_SESSION['quiz_questions'])) {
        header('Location: dashboard.php');
        exit();
    }
    
    $question_ids = $_SESSION['quiz_questions'];
    $placeholders = str_repeat('?,', count($question_ids) - 1) . '?';
    $stmt = $pdo->prepare("SELECT id, correct_answer FROM questions WHERE id IN ($placeholders)");
    $stmt->execute($question_ids);
    $questions = $stmt->fetchAll();
    
    $correct_answers = 0;
    $total_questions = count($questions);
    
    foreach ($questions as $question) {
        $user_answer = $answers[$question['id']] ?? '';
        $is_correct = ($user_answer === $question['correct_answer']);
        
        if ($is_correct) {
            $correct_answers++;
        }
        
        // Save answer
        $stmt = $pdo->prepare("INSERT INTO quiz_answers (session_id, question_id, user_answer, is_correct) VALUES (?, ?, ?, ?)");
        $stmt->execute([$session_id, $question['id'], $user_answer, $is_correct]);
    }
    
    $score = round(($correct_answers / $total_questions) * 100);
    
    // Update session
    $stmt = $pdo->prepare("UPDATE quiz_sessions SET score = ?, total_questions = ?, time_taken = ?, completed = 1, completed_at = NOW() WHERE id = ?");
    $stmt->execute([$score, $total_questions, $time_taken, $session_id]);
    
    // Clear quiz questions from session
    unset($_SESSION['quiz_questions']);
    
    // Redirect to results
    header("Location: quiz_results.php?session_id=" . $session_id);
    exit();
}

// Create new quiz session
$stmt = $pdo->prepare("INSERT INTO quiz_sessions (user_id, category_id) VALUES (?, ?)");
$stmt->execute([$_SESSION['user_id'], $category_id]);
$session_id = $pdo->lastInsertId();

// Get questions for this category
$questions_per_quiz = (int)getSetting('questions_per_quiz', 10);
$stmt = $pdo->prepare("SELECT * FROM questions WHERE category_id = ? ORDER BY RAND() LIMIT " . $questions_per_quiz);
$stmt->execute([$category_id]);
$questions = $stmt->fetchAll();

if (empty($questions)) {
    echo "<script>alert('No questions available for this category. Please contact admin.'); window.location.href='dashboard.php';</script>";
    exit();
}

// Store question IDs in session for scoring
$_SESSION['quiz_questions'] = array_column($questions, 'id');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - <?php echo htmlspecialchars($category['name']); ?> - SQA Quiz Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .quiz-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        
        .timer {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            border-radius: 15px;
            padding: 1rem;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .question-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 2px solid #e9ecef;
        }
        
        .option {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .option:hover {
            background: #e9ecef;
            border-color: #3498db;
        }
        
        .option.selected {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }
        
        .progress-bar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 10px;
            border-radius: 5px;
            transition: width 0.3s ease;
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
        
        .btn-danger {
            background: #e74c3c;
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
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
                <span class="navbar-text">
                    <i class="fas fa-user me-2"></i><?php echo htmlspecialchars($_SESSION['username']); ?>
                </span>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="quiz-container">
            <!-- Quiz Header -->
            <div class="row align-items-center mb-4">
                <div class="col-md-6">
                    <h2><i class="fas fa-question-circle me-2"></i><?php echo htmlspecialchars($category['name']); ?></h2>
                    <p class="text-muted mb-0"><?php echo htmlspecialchars($category['description']); ?></p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="progress mb-2" style="height: 10px;">
                        <div class="progress-bar" id="progressBar" style="width: 0%"></div>
                    </div>
                    <small class="text-muted">Question <span id="currentQuestion">1</span> of <?php echo count($questions); ?></small>
                </div>
            </div>

            <!-- Timer -->
            <div class="timer">
                <i class="fas fa-clock me-2"></i>Time Remaining: <span id="timer">30:00</span>
            </div>

            <form id="quizForm" method="POST">
                <input type="hidden" name="session_id" value="<?php echo $session_id; ?>">
                <input type="hidden" name="time_taken" id="timeTaken" value="0">
                <input type="hidden" name="submit_quiz" value="1">
                
                <?php foreach($questions as $index => $question): ?>
                    <div class="question-card" id="question-<?php echo $index + 1; ?>" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>;">
                        <h4 class="mb-4">
                            <span class="badge bg-primary me-2"><?php echo $index + 1; ?></span>
                            <?php echo htmlspecialchars($question['question_text']); ?>
                        </h4>
                        
                        <div class="options">
                            <div class="option" onclick="selectOption(this, '<?php echo $question['id']; ?>', 'A')">
                                <strong>A.</strong> <?php echo htmlspecialchars($question['option_a']); ?>
                            </div>
                            <div class="option" onclick="selectOption(this, '<?php echo $question['id']; ?>', 'B')">
                                <strong>B.</strong> <?php echo htmlspecialchars($question['option_b']); ?>
                            </div>
                            <div class="option" onclick="selectOption(this, '<?php echo $question['id']; ?>', 'C')">
                                <strong>C.</strong> <?php echo htmlspecialchars($question['option_c']); ?>
                            </div>
                            <div class="option" onclick="selectOption(this, '<?php echo $question['id']; ?>', 'D')">
                                <strong>D.</strong> <?php echo htmlspecialchars($question['option_d']); ?>
                            </div>
                        </div>
                        
                        <input type="hidden" name="answers[<?php echo $question['id']; ?>]" id="answer-<?php echo $question['id']; ?>" value="">
                    </div>
                <?php endforeach; ?>

                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary" id="prevBtn" onclick="previousQuestion()" style="display: none;">
                        <i class="fas fa-arrow-left me-2"></i>Previous
                    </button>
                    
                    <div>
                        <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextQuestion()">
                            Next<i class="fas fa-arrow-right ms-2"></i>
                        </button>
                        <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">
                            <i class="fas fa-check me-2"></i>Submit Quiz
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentQuestionIndex = 0;
        let totalQuestions = <?php echo count($questions); ?>;
        let timeLeft = <?php echo (int)getSetting('quiz_timer_minutes', 30) * 60; ?>; // Configurable timer in seconds
        let timerInterval;
        let answers = {};

        // Initialize timer
        function startTimer() {
            const totalTime = <?php echo (int)getSetting('quiz_timer_minutes', 30) * 60; ?>;
            timerInterval = setInterval(function() {
                timeLeft--;
                document.getElementById('timeTaken').value = totalTime - timeLeft;
                
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                document.getElementById('timer').textContent = 
                    (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
                
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    alert('Time is up! Submitting quiz...');
                    document.getElementById('quizForm').submit();
                }
            }, 1000);
        }

        // Select option
        function selectOption(element, questionId, answer) {
            // Remove selection from other options in this question
            const options = element.parentElement.querySelectorAll('.option');
            options.forEach(opt => opt.classList.remove('selected'));
            
            // Select this option
            element.classList.add('selected');
            
            // Store answer
            answers[questionId] = answer;
            document.getElementById('answer-' + questionId).value = answer;
        }

        // Show question
        function showQuestion(index) {
            // Hide all questions
            for (let i = 0; i < totalQuestions; i++) {
                document.getElementById('question-' + (i + 1)).style.display = 'none';
            }
            
            // Show current question
            document.getElementById('question-' + (index + 1)).style.display = 'block';
            
            // Update progress
            const progress = ((index + 1) / totalQuestions) * 100;
            document.getElementById('progressBar').style.width = progress + '%';
            document.getElementById('currentQuestion').textContent = index + 1;
            
            // Update navigation buttons
            document.getElementById('prevBtn').style.display = index === 0 ? 'none' : 'inline-block';
            document.getElementById('nextBtn').style.display = index === totalQuestions - 1 ? 'none' : 'inline-block';
            document.getElementById('submitBtn').style.display = index === totalQuestions - 1 ? 'inline-block' : 'none';
        }

        // Next question
        function nextQuestion() {
            if (currentQuestionIndex < totalQuestions - 1) {
                currentQuestionIndex++;
                showQuestion(currentQuestionIndex);
            }
        }

        // Previous question
        function previousQuestion() {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                showQuestion(currentQuestionIndex);
            }
        }

        // Start timer when page loads
        window.onload = function() {
            startTimer();
            showQuestion(0);
        };

        // Warn before leaving page
        window.onbeforeunload = function() {
            return "Are you sure you want to leave? Your quiz progress will be lost.";
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
