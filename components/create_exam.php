<?php

session_start();

header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "bassetdb";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'errors' => ['general' => 'Failed to connect to the database.']]);
    exit();
}

// Initialize response array
$response = [
    'success' => false,
    'errors' => []
];

// Validate inputs
$title = isset($_POST['exam_title']) ? trim($_POST['exam_title']) : '';
$description = isset($_POST['exam_description']) ? trim($_POST['exam_description']) : '';
$duedate = isset($_POST['exam_due_date']) ? trim($_POST['exam_due_date']) : '';
$course_id = isset($_POST['exam_course_id']) ? intval($_POST['exam_course_id']) : 0;

if (empty($title)) {
    $response['errors']['exam_title'] = 'عنوان الامتحان مطلوب.';
}
if (empty($description)) {
    $response['errors']['exam_description'] = 'وصف الامتحان مطلوب.';
}
if (empty($duedate)) {
    $response['errors']['exam_due_date'] = 'تاريخ انتهاء الامتحان مطلوب.';
}
if ($course_id <= 0) {
    $response['errors']['exam_course_id'] = 'يرجى اختيار الدورة.';
}
if (!isset($_FILES['exam_file']) || $_FILES['exam_file']['error'] != 0) {
    $response['errors']['exam_file'] = 'ملف الامتحان مطلوب.';
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

// Process exam file upload
$examFilePath = '';
if (isset($_FILES['exam_file']) && $_FILES['exam_file']['error'] === 0) {
    $examFileTmpPath = $_FILES['exam_file']['tmp_name'];
    $examFileName = uniqid() . "_" . $_FILES['exam_file']['name']; // Unique filename
    $examFilePath = $uploadDir . $examFileName;

    if (!move_uploaded_file($examFileTmpPath, $examFilePath)) {
        $response['errors']['exam_file'] = 'Failed to upload the exam file.';
        echo json_encode($response);
        exit();
    }
}

// Process solution file upload (if provided)
$examSolutionFilePath = '';
if (isset($_FILES['exam_solution']) && $_FILES['exam_solution']['error'] === 0) {
    $solutionFileTmpPath = $_FILES['exam_solution']['tmp_name'];
    $solutionFileName = uniqid() . "_" . $_FILES['exam_solution']['name'];
    $examSolutionFilePath = $uploadDir . $solutionFileName;

    if (!move_uploaded_file($solutionFileTmpPath, $examSolutionFilePath)) {
        $response['errors']['exam_solution'] = 'Failed to upload the solution file.';
        echo json_encode($response);
        exit();
    }
}

// Insert into the database
$userID = $_SESSION['user']['UserID']; // Ensure this is set correctly
$type = 'exam';

$sql = "INSERT INTO Tasks (UserID, Task_title, Task_description, Task_file, Task_solution, DueDate, Type, course_ID)
        VALUES ('$userID', '$title', '$description', '$examFilePath', '$examSolutionFilePath', '$duedate', '$type', '$course_id')";

if ($conn->query($sql) === TRUE) {
    $response['success'] = true;
    echo json_encode($response);
    exit();
} else {
    $response['errors']['general'] = 'Failed to save the exam. Please try again.';
    echo json_encode($response);
    exit();
}

// Close connection
$conn->close();

?>
