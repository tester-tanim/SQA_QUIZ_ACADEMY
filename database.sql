-- SQA Quiz Academy Database Schema

-- Create database
CREATE DATABASE IF NOT EXISTS sqa_quiz_academy;
USE sqa_quiz_academy;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Categories table for SQA topics
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Questions table
CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    question_text TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    correct_answer ENUM('A', 'B', 'C', 'D') NOT NULL,
    explanation TEXT,
    difficulty_level ENUM('easy', 'medium', 'hard') DEFAULT 'medium',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Quiz sessions table
CREATE TABLE quiz_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    category_id INT,
    score INT DEFAULT 0,
    total_questions INT DEFAULT 0,
    time_taken INT DEFAULT 0, -- in seconds
    completed BOOLEAN DEFAULT FALSE,
    started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Quiz answers table
CREATE TABLE quiz_answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id INT,
    question_id INT,
    user_answer ENUM('A', 'B', 'C', 'D'),
    is_correct BOOLEAN DEFAULT FALSE,
    answered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (session_id) REFERENCES quiz_sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
);

-- Settings table for system configuration
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Note: Admin users should be created manually by registering a regular user and then updating their role to 'admin' in the database

-- Insert SQA categories
INSERT INTO categories (name, description) VALUES 
('Software Testing Fundamentals', 'Basic concepts and principles of software testing'),
('Test Planning & Strategy', 'Test planning, strategy development, and test case design'),
('Test Execution & Management', 'Test execution, defect management, and test reporting'),
('Automation Testing', 'Test automation frameworks, tools, and best practices'),
('Performance Testing', 'Load testing, stress testing, and performance monitoring'),
('Security Testing', 'Security testing methodologies and vulnerability assessment'),
('API Testing', 'REST API testing, web services testing, and integration testing'),
('Mobile Testing', 'Mobile application testing strategies and tools'),
('Database Testing', 'Database testing, data validation, and SQL testing'),
('Agile Testing', 'Testing in agile environments, continuous testing, and DevOps');

-- Insert default settings
INSERT INTO settings (setting_key, setting_value, description) VALUES 
('quiz_timer_minutes', '30', 'Default quiz timer duration in minutes'),
('questions_per_quiz', '10', 'Number of questions per quiz'),
('passing_score', '70', 'Minimum passing score percentage');
