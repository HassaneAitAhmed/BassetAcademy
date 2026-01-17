<?php
require 'config.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? null; // Default to null if not provided

if (!$action) {
    echo json_encode(['error' => 'Action parameter is missing']);
    exit;
}

switch ($action) {
    case 'fetchCourses':
        fetchCourses($pdo);
        break;
    case 'deleteCourse':
        deleteCourse($pdo);
        break;
    default:
        echo json_encode(['error' => 'Invalid action: ' . $action]);
        break;
}
