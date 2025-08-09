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

// Handle JSON import
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['import_json'])) {
    $json_data = trim($_POST['json_data']);
    
    if (empty($json_data)) {
        $error = 'Please enter JSON data';
    } else {
        $data = json_decode($json_data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $error = 'Invalid JSON format: ' . json_last_error_msg();
        } else {
            $imported = 0;
            $errors = [];
            
            foreach ($data as $index => $question) {
                // Validate required fields
                $required_fields = ['category_id', 'question_text', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer'];
                $missing_fields = [];
                
                foreach ($required_fields as $field) {
                    if (!isset($question[$field]) || empty($question[$field])) {
                        $missing_fields[] = $field;
                    }
                }
                
                if (!empty($missing_fields)) {
                    $errors[] = "Question " . ($index + 1) . ": Missing fields: " . implode(', ', $missing_fields);
                    continue;
                }
                
                // Validate correct answer
                if (!in_array($question['correct_answer'], ['A', 'B', 'C', 'D'])) {
                    $errors[] = "Question " . ($index + 1) . ": Invalid correct answer. Must be A, B, C, or D";
                    continue;
                }
                
                // Validate category exists
                $stmt = $pdo->prepare("SELECT id FROM categories WHERE id = ?");
                $stmt->execute([$question['category_id']]);
                if (!$stmt->fetch()) {
                    $errors[] = "Question " . ($index + 1) . ": Category ID " . $question['category_id'] . " does not exist";
                    continue;
                }
                
                // Insert question
                try {
                    $stmt = $pdo->prepare("INSERT INTO questions (category_id, question_text, option_a, option_b, option_c, option_d, correct_answer, explanation, difficulty_level) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $question['category_id'],
                        $question['question_text'],
                        $question['option_a'],
                        $question['option_b'],
                        $question['option_c'],
                        $question['option_d'],
                        $question['correct_answer'],
                        $question['explanation'] ?? '',
                        $question['difficulty_level'] ?? 'medium'
                    ]);
                    $imported++;
                } catch (Exception $e) {
                    $errors[] = "Question " . ($index + 1) . ": Database error - " . $e->getMessage();
                }
            }
            
            if ($imported > 0) {
                $message = "Successfully imported $imported questions!";
                if (!empty($errors)) {
                    $message .= " However, there were some errors: " . implode('; ', $errors);
                }
                // Add a flag to indicate successful import for JavaScript
                $success_import = true;
            } else {
                $error = "No questions were imported. Errors: " . implode('; ', $errors);
            }
        }
    }
}

// Get categories for reference
$stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
$categories = $stmt->fetchAll();

// Sample JSON structure
$sample_json = [
    [
        "category_id" => 1,
        "question_text" => "What is the primary goal of software testing?",
        "option_a" => "To find bugs",
        "option_b" => "To ensure software meets requirements",
        "option_c" => "To make software faster",
        "option_d" => "To reduce development time",
        "correct_answer" => "B",
        "explanation" => "The primary goal is to ensure software meets specified requirements and works as expected.",
        "difficulty_level" => "easy"
    ],
    [
        "category_id" => 1,
        "question_text" => "Which testing type focuses on testing individual components?",
        "option_a" => "Integration testing",
        "option_b" => "System testing",
        "option_c" => "Unit testing",
        "option_d" => "Acceptance testing",
        "correct_answer" => "C",
        "explanation" => "Unit testing focuses on testing individual components or units of code in isolation.",
        "difficulty_level" => "medium"
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Questions - SQA Quiz Academy</title>
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
        
        .json-textarea {
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            min-height: 300px;
        }
        
        .info-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #3498db;
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
                        <a class="nav-link active" href="import_questions.php">Import</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="settings.php">Settings</a>
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
            <h2><i class="fas fa-upload me-2"></i>Import Questions via JSON</h2>
            
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

            <!-- Information Card -->
            <div class="info-card">
                <h5><i class="fas fa-info-circle me-2"></i>JSON Import Guidelines</h5>
                <ul class="mb-0">
                    <li>JSON should be an array of question objects</li>
                    <li>Each question must have: category_id, question_text, option_a, option_b, option_c, option_d, correct_answer</li>
                    <li>correct_answer must be A, B, C, or D</li>
                    <li>explanation and difficulty_level are optional</li>
                    <li>difficulty_level can be: easy, medium, or hard</li>
                </ul>
            </div>

            <!-- Category Reference -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Category Reference</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach($categories as $category): ?>
                            <div class="col-md-6">
                                <strong>ID <?php echo $category['id']; ?>:</strong> <?php echo htmlspecialchars($category['name']); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Import Form -->
            <form method="POST">
                <div class="mb-3">
                    <label for="json_data" class="form-label">
                        <i class="fas fa-code me-2"></i>JSON Data
                    </label>
                    <textarea class="form-control json-textarea" id="json_data" name="json_data" rows="15" placeholder="Paste your JSON data here..."><?php echo (isset($_POST['json_data']) && !isset($success_import)) ? htmlspecialchars($_POST['json_data']) : ''; ?></textarea>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" name="import_json" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i>Import Questions
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="loadSample()">
                        <i class="fas fa-eye me-2"></i>Load Sample
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="clearForm()">
                        <i class="fas fa-eraser me-2"></i>Clear
                    </button>
                </div>
            </form>

            <!-- Sample JSON -->
            <div class="mt-4">
                <h5><i class="fas fa-file-code me-2"></i>Sample JSON Format</h5>
                <div class="card">
                    <div class="card-body">
                        <pre class="mb-0"><code><?php echo json_encode($sample_json, JSON_PRETTY_PRINT); ?></code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loadSample() {
            const sample = <?php echo json_encode($sample_json); ?>;
            document.getElementById('json_data').value = JSON.stringify(sample, null, 2);
        }
        
        function clearForm() {
            document.getElementById('json_data').value = '';
        }
        
        // Clear textarea if import was successful
        <?php if (isset($success_import) && $success_import): ?>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('json_data').value = '';
        });
        <?php endif; ?>
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
