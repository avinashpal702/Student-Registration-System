-- -------------------------------------------------
-- MySQL schema for Student Registration system
-- -------------------------------------------------
CREATE DATABASE IF NOT EXISTS student_registration;
USE student_registration;

-- Users table (students + admins)
CREATE TABLE users (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(100) NOT NULL,
    email         VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role          ENUM('student','admin') NOT NULL DEFAULT 'student',
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Courses table
CREATE TABLE courses (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    name             VARCHAR(150) NOT NULL,
    description      TEXT,
    available_places INT NOT NULL CHECK (available_places >= 0),
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Enrollments table (many‑to‑many)
CREATE TABLE enrollments (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    user_id          INT NOT NULL,
    course_id        INT NOT NULL,
    registration_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_user   FOREIGN KEY (user_id)   REFERENCES users(id)   ON DELETE CASCADE,
    CONSTRAINT fk_course FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    UNIQUE KEY uniq_user_course (user_id, course_id)
) ENGINE=InnoDB;

-- -------------------------------------------------
-- Demo data (optional)
-- -------------------------------------------------
INSERT INTO users (name, email, password_hash, role) VALUES
('Admin User', 'admin@example.com',   /* password: admin123 */   '$2y$10$Zx7FJ/4cK2vZ/L0N2R1E6e/HV3sUokFv1KiyXD.hU1LxIY3Iq6Kfe', 'admin'),
('Student One', 'student1@example.com', /* password: student1 */ '$2y$10$kgkeL6xzZgwEgy6ELJiWjuvT6R3iEzVIRwgPjMfRpawF2dwM14I2a', 'student');

INSERT INTO courses (name, description, available_places) VALUES
('Intro to Programming', 'Learn the basics of programming using Python.', 30),
('Web Development', 'Build modern web applications with HTML, CSS, JS, and PHP.', 25),
('Database Systems', 'Fundamentals of relational databases and SQL.', 20),
('Artificial Intelligence and Machine Learning', 'Explore AI concepts, machine learning models, and practical applications.', 24),
('Data Science', 'Discover how to prepare, explore, and model data to find useful insights.', 24),
('Data Analytics', 'Learn to analyze data, build clear visualizations, and communicate findings.', 24),
('Data Structures', 'Study essential data structures and algorithms for writing efficient programs.', 24),
('Python Programming', 'Learn Python syntax, problem solving, and how to build useful applications.', 24),
('Java Programming', 'Build a strong foundation in Java, object-oriented programming, and application development.', 24),
('C Programming', 'Learn the fundamentals of C, memory concepts, and efficient systems programming.', 24),
('C++ Programming', 'Explore C++ programming, object-oriented design, and performance-focused applications.', 24),
('JavaScript Programming', 'Create interactive web experiences and learn the language of modern web development.', 24),
('MERN Stack Development', 'Build full-stack web applications with MongoDB, Express, React, and Node.js.', 24);