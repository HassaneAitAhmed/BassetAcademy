<?php

include dirname(__FILE__).'/../db_connection.php';


$query = "SELECT CourseID, Course_title FROM Course";
$result = $conn->query($query);

$courses = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courseID = $row['CourseID'];
        $courseTitle = $row['Course_title'];
        $courses .= "<option value='$courseID'>$courseTitle</option>";
    }
} else {
    $courses = "<option value='' disabled>No courses available</option>";
}

$conn->close();
?>