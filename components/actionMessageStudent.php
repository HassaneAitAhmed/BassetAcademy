<?php
$My_Connection = new mysqli('localhost', 'root', '', 'bassetdb');

if ($My_Connection->connect_error) {
    die("Database connection failed: " . $My_Connection->connect_error);
}

if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message'])) {
    die("Required fields are missing.");
}

$Name = trim($_POST['name']);
$Email = trim($_POST['email']);
$Message = trim($_POST['message']);
$Status = 'NOTREAD';

if (empty($Name) || empty($Email) || empty($Message)) {
    die("All fields are required.");
}

if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}

$query = 'INSERT INTO `message` (`UserName`, `UserEmail`, `MessageContent`, `MessageStatus`) VALUES (?, ?, ?, ?)';
$stmt = $My_Connection->prepare($query);

if (!$stmt) {
    die("Failed to prepare the statement: " . $My_Connection->error);
}

$stmt->bind_param('ssss', $Name, $Email, $Message, $Status);

if ($stmt->execute()) {
    echo "Message submitted successfully.";
} else {
    echo "Error submitting message: " . $stmt->error;
}


$stmt->close();
$My_Connection->close();
header("Location: ../student.php");
?>
