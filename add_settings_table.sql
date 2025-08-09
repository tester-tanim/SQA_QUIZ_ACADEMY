-- Add Settings Table to Existing SQA Quiz Academy Database
-- Run this script if you have an existing database without the settings table

USE sqa_quiz_academy;

-- Create settings table
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default settings (only if they don't exist)
INSERT IGNORE INTO settings (setting_key, setting_value, description) VALUES 
('quiz_timer_minutes', '30', 'Default quiz timer duration in minutes'),
('questions_per_quiz', '10', 'Number of questions per quiz'),
('passing_score', '70', 'Minimum passing score percentage');

-- Verify the settings were added
SELECT * FROM settings;
