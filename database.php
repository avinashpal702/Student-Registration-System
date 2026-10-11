<?php
// config/database.php – PDO connection helper

$host = 'localhost';
$db   = 'student_registration';
$user = 'root';           // change if you use another MySQL user
$pass = '702@Avinash';               // set your MySQL password here
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // throw exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // In production you’d log this instead of displaying raw error
    exit('Database connection failed: ' . $e->getMessage());
}