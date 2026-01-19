<?php

session_start();

header('Content-Type: application/json');

include 'db_connection.php';

// Initialize response array
$response = [
    'success' => false,
    'errors' => []
];

// Validate inputs
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$duedate = isset($_POST['duedate']) ? trim($_POST['duedate']) : '';
$course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;

if (empty($title)) {
    $response['errors']['AQ-title'] = 'عنوان الواجب مطلوب.';
}
if (empty($description)) {
    $response['errors']['AQ-description'] = 'وصف الواجب مطلوب.';
}
if (empty($duedate)) {
    $response['errors']['AQ-deadline'] = 'تاريخ التسليم مطلوب.';
}
if ($course_id <= 0) {
    $response['errors']['course_id'] = 'يرجى اختيار الدورة.';
}
if (!isset($_FILES['file']) || $_FILES['file']['error'] != 0) {
    $response['errors']['AQ-files'] = 'ملف الواجب مطلوب.';
}

// If there are validation errors, return them
if (!empty($response['errors'])) {
    echo json_encode($response);
    exit();
}

// File upload paths
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Process task file upload
$taskFilePath = '';
if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
    $taskFileTmpPath = $_FILES['file']['tmp_name'];
    $taskFileName = uniqid() . "_" . $_FILES['file']['name']; // Unique filename
    $taskFilePath = $uploadDir . $taskFileName;

    if (!move_uploaded_file($taskFileTmpPath, $taskFilePath)) {
        $response['errors']['AQ-files'] = 'Failed to upload the task file.';
        echo json_encode($response);
        exit();
    }
}

// Process solution file upload (if provided)
$taskSolutionFilePath = '';
if (isset($_FILES['Task_solution']) && $_FILES['Task_solution']['error'] === 0) {
    $solutionFileTmpPath = $_FILES['Task_solution']['tmp_name'];
    $solutionFileName = uniqid() . "_" . $_FILES['Task_solution']['name'];
    $taskSolutionFilePath = $uploadDir . $solutionFileName;

    if (!move_uploaded_file($solutionFileTmpPath, $taskSolutionFilePath)) {
        $response['errors']['AQ-files-solution'] = 'Failed to upload the solution file.';
        echo json_encode($response);
        exit();
    }
}

// Insert into the database
$userID = $_SESSION['user']['UserID']; // Ensure this is set correctly
$type = 'assignment';

$sql = "INSERT INTO Tasks (UserID, Task_title, Task_description, Task_file, Task_solution, DueDate, Type, course_ID)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issssssi", $userID, $title, $description, $taskFilePath, $taskSolutionFilePath, $duedate, $type, $course_id);


if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['errors']['general'] = 'Failed to save the assignment. Please try again.';
}

echo json_encode($response);

// Close connection
$stmt->close();
$conn->close();

?>
