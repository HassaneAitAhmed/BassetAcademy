<?php
// Fetch courses (fetch_courses.php)
$servername = "localhost";
$username = "root";
$password = "";
$database = "bassetdb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT CourseID, Course_title FROM Course";
$result = $conn->query($sql);

$courses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($courses);

$conn->close();
?>
