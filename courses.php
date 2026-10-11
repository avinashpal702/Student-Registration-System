<?php
header('Content-Type: application/json');

require_once 'config/database.php';
$stmt = $pdo->query('SELECT id, name, description, available_places FROM courses');
$courses = $stmt->fetchAll();

echo json_encode($courses);