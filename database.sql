-- Learning Platform Database Schema
-- This file creates the necessary tables for the learning platform

-- Create database if it doesn't exist
-- If an older database exists, remove it so the schema below is applied cleanly.
-- This ensures the sample data and columns (like `full_name`) match the INSERTs.
DROP DATABASE IF EXISTS lernplattform;
CREATE DATABASE lernplattform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lernplattform;

-- Users table: stores student information
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Learning materials table: stores study content
CREATE TABLE IF NOT EXISTS learning_materials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    content TEXT NOT NULL,
    category VARCHAR(50),
    difficulty_level ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'beginner',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Quizzes table: stores quiz information
CREATE TABLE IF NOT EXISTS quizzes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    material_id INT,
    time_limit INT DEFAULT 30, -- in minutes
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (material_id) REFERENCES learning_materials(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Questions table: stores quiz questions
CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    question_text TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    correct_answer ENUM('A', 'B', 'C', 'D') NOT NULL,
    points INT DEFAULT 1,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Quiz attempts table: tracks student quiz attempts
CREATE TABLE IF NOT EXISTS quiz_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    quiz_id INT NOT NULL,
    score INT NOT NULL,
    max_score INT NOT NULL,
    completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Insert sample data for testing

-- Sample users (password is 'student123' hashed with password_hash())
INSERT INTO users (username, password, full_name, email) VALUES
('student1', '$2y$10$mAVlBVS/MdvoZMBo63E8POb9DLqvL4gcp6cF3298TCjNKRn969wYS', 'Max Mustermann', 'max@example.com'),
('student2', '$2y$10$mAVlBVS/MdvoZMBo63E8POb9DLqvL4gcp6cF3298TCjNKRn969wYS', 'Anna Schmidt', 'anna@example.com');

-- Sample learning materials
INSERT INTO learning_materials (title, description, content, category, difficulty_level) VALUES
('Introduction to Mathematics', 'Basic mathematical concepts for beginners', 
'<h2>Basic Mathematics</h2>
<p>Mathematics is the study of numbers, shapes, and patterns. Let''s start with basic operations:</p>
<h3>Addition</h3>
<p>Addition is putting numbers together. For example: 2 + 3 = 5</p>
<h3>Subtraction</h3>
<p>Subtraction is taking numbers away. For example: 5 - 2 = 3</p>
<h3>Multiplication</h3>
<p>Multiplication is repeated addition. For example: 3 × 4 = 12</p>
<h3>Division</h3>
<p>Division is splitting into equal parts. For example: 12 ÷ 3 = 4</p>', 
'Mathematics', 'beginner'),

('English Grammar Basics', 'Learn the fundamentals of English grammar', 
'<h2>English Grammar</h2>
<p>Grammar helps us communicate clearly. Here are some basics:</p>
<h3>Nouns</h3>
<p>Nouns are words for people, places, or things. Examples: cat, school, happiness</p>
<h3>Verbs</h3>
<p>Verbs are action words. Examples: run, eat, sleep</p>
<h3>Adjectives</h3>
<p>Adjectives describe nouns. Examples: big, happy, red</p>
<h3>Sentences</h3>
<p>A sentence has a subject and a verb. Example: "The cat sleeps."</p>', 
'English', 'beginner'),

('Introduction to Science', 'Discover the basics of scientific inquiry', 
'<h2>What is Science?</h2>
<p>Science is the study of the world around us through observation and experimentation.</p>
<h3>The Scientific Method</h3>
<ol>
<li>Ask a question</li>
<li>Do research</li>
<li>Form a hypothesis</li>
<li>Test with an experiment</li>
<li>Analyze results</li>
<li>Draw conclusions</li>
</ol>
<h3>Branches of Science</h3>
<ul>
<li><strong>Biology:</strong> Study of living things</li>
<li><strong>Chemistry:</strong> Study of matter and its changes</li>
<li><strong>Physics:</strong> Study of energy and motion</li>
</ul>', 
'Science', 'beginner');

-- Sample quizzes
INSERT INTO quizzes (title, description, material_id, time_limit) VALUES
('Basic Math Quiz', 'Test your understanding of basic mathematical operations', 1, 15),
('Grammar Fundamentals Quiz', 'Test your knowledge of basic English grammar', 2, 20),
('Science Basics Quiz', 'Check your understanding of scientific concepts', 3, 15);

-- Sample questions for Math Quiz
INSERT INTO questions (quiz_id, question_text, option_a, option_b, option_c, option_d, correct_answer, points) VALUES
(1, 'What is 5 + 3?', '6', '7', '8', '9', 'C', 1),
(1, 'What is 10 - 4?', '5', '6', '7', '8', 'B', 1),
(1, 'What is 3 × 4?', '7', '10', '12', '14', 'C', 1),
(1, 'What is 15 ÷ 3?', '3', '4', '5', '6', 'C', 1);

-- Sample questions for Grammar Quiz
INSERT INTO questions (quiz_id, question_text, option_a, option_b, option_c, option_d, correct_answer, points) VALUES
(2, 'Which word is a noun?', 'run', 'happy', 'dog', 'quickly', 'C', 1),
(2, 'Which word is a verb?', 'table', 'blue', 'jump', 'big', 'C', 1),
(2, 'Which word is an adjective?', 'run', 'beautiful', 'cat', 'slowly', 'B', 1),
(2, 'Which sentence is correct?', 'The cat run.', 'The cat runs.', 'Cat the runs.', 'Runs cat the.', 'B', 1);

-- Sample questions for Science Quiz
INSERT INTO questions (quiz_id, question_text, option_a, option_b, option_c, option_d, correct_answer, points) VALUES
(3, 'What is the first step of the scientific method?', 'Form a hypothesis', 'Ask a question', 'Do an experiment', 'Draw conclusions', 'B', 1),
(3, 'Which branch of science studies living things?', 'Physics', 'Chemistry', 'Biology', 'Geology', 'C', 1),
(3, 'What do we call a testable prediction?', 'Theory', 'Hypothesis', 'Law', 'Conclusion', 'B', 1),
(3, 'What is the study of energy and motion called?', 'Biology', 'Chemistry', 'Physics', 'Astronomy', 'C', 1);
