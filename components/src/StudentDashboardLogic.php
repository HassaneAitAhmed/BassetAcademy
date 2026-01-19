<?php
session_start();

if (!isset($_SESSION['user']['UserID'])) {
    header('Location: login.php');
    exit();
}

require_once dirname(__FILE__).'/../db_connection.php';

$currentUserID = $_SESSION['user']['UserID'];

$query1 = "SELECT PayementID, Payementphoto, Payementvalue, PaymentStatus 
          FROM Payement 
          WHERE StudentID = ?";
$stmt = $conn->prepare($query1);
$stmt->bind_param('i', $currentUserID);
$stmt->execute();
$result = $stmt->get_result();

$query2 = "SELECT * FROM `User` WHERE `UserID` = ?";
$stmt = $conn->prepare($query2);
$stmt->bind_param('i', $currentUserID);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$userFirstName = $user['User_FirstName'] ?? 'N/A';
$userLastName = $user['User_LastName'] ?? 'N/A';
$userPhone = $user['User_Phone'] ?? 'N/A';
$userEmail = $user['User_Email'] ?? 'N/A';

$query3 = "SELECT COUNT(*) AS total_courses FROM `StudentCourse` WHERE `UserID` = ? AND `Status` = 'Completed'";
$stmt = $conn->prepare($query3);
$stmt->bind_param('i', $currentUserID);
$stmt->execute();
$completed_courses = $stmt->get_result()->fetch_assoc()['total_courses'];

$query4 = "SELECT COUNT(*) AS total_courses FROM `StudentCourse` WHERE `UserID` = ?";
$stmt = $conn->prepare($query4);
$stmt->bind_param('i', $currentUserID);
$stmt->execute();
$total_courses = $stmt->get_result()->fetch_assoc()['total_courses'];

$videos_watched_percentage = $total_courses ? round(($completed_courses / $total_courses) * 100) : 0;

$query5 = "SELECT COUNT(*) AS completed_tests FROM `StudentTasks` WHERE `StudentID` = ? AND `AssessmentStatus` = 'Completed'";
$stmt = $conn->prepare($query5);
$stmt->bind_param('i', $currentUserID);
$stmt->execute();
$completed_tests = $stmt->get_result()->fetch_assoc()['completed_tests'];

$query6 = "SELECT COUNT(*) AS total_tests FROM `studenttasks` WHERE `StudentID` = ?";
$stmt = $conn->prepare($query6);
$stmt->bind_param('i', $currentUserID);
$stmt->execute();
$total_tests = $stmt->get_result()->fetch_assoc()['total_tests'];

$tests_completed_percentage = $total_tests ? round(($completed_tests / $total_tests) * 100) : 0;

$query7 = "SELECT AVG(`AssessmentScore`) AS avg_score FROM `StudentTasks` WHERE `StudentID` = ?";
$stmt = $conn->prepare($query7);
$stmt->bind_param('i', $currentUserID);
$stmt->execute();
$average_score = $stmt->get_result()->fetch_assoc()['avg_score'];
$average_score = $average_score ? round($average_score) : 0;

$query8 = "
    SELECT course.CourseID, course.Course_title, course.Course_description, course.Course_image
    FROM course
    JOIN studentcourse ON studentcourse.CourseID = course.CourseID
    WHERE studentcourse.UserID = ?";

$stmt = $conn->prepare($query8);
$stmt->bind_param('i', $currentUserID);
$stmt->execute();
$courses = $stmt->get_result();


$query9 = "SELECT * FROM StudentSecurity ORDER BY logtime DESC LIMIT 10";
$stmt = $conn->prepare($query9);
$stmt->execute();
$security_result = $stmt->get_result();



$query10 = "
    SELECT t.TaskID, t.Task_title, t.Task_file, sc.CourseID
    FROM Tasks t
    JOIN studentcourse sc ON t.Course_ID = sc.CourseID
    WHERE sc.UserID = ?";
$stmt = $conn->prepare($query10);
$stmt->bind_param("i", $currentUserID);
$stmt->execute();
$tasks = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_task'])) {
        $taskID = $_POST['submit_task'];

        if (isset($_FILES['answer']) && $_FILES['answer']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['answer'];

            $query = "SELECT course_ID FROM Tasks WHERE TaskID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $taskID);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $task = $result->fetch_assoc();
                $courseID = $task['course_ID'];
            } else {
                echo "Invalid TaskID or CourseID.";
                exit();
            }

            $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowedTypes)) {
                echo "Only PDF and image files (JPEG, PNG, GIF) are allowed.";
                exit();
            }

            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . basename($file['name']);

            if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                $query = "
                    INSERT INTO StudentTasks (TaskID, StudentID, CourseID, AssessmentStatus, AssessmentDate, stud_solution) 
                    VALUES (?, ?, ?, 'Pending', NOW(), ?) 
                    ON DUPLICATE KEY UPDATE stud_solution = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('iiiss', $taskID, $currentUserID, $courseID, $uploadFile, $uploadFile);
                if ($stmt->execute()) {
                    $_SESSION['success'] = 'تم رفع الواجب بنجاح';
                } else {
                    $_SESSION['error'] = "حدث خطا اعد لاحقا " . $stmt->error;
                }
            } else {
                $_SESSION['error'] = "حدث خطا اعد لاحقا " . $stmt->error;
            }
        } else {
            $_SESSION['error'] = "حدث خطا اعد لاحقا " . $stmt->error;
        }
    }
}



$query = "
    SELECT t.TaskID, st.AssessmentStatus, t.Task_file , st.AssessmentDate, st.AssessmentScore, t.Task_solution 
    FROM StudentTasks st
    JOIN Tasks t ON st.TaskID = t.TaskID
    WHERE st.StudentID = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $currentUserID);
$stmt->execute();
$tasksresult = $stmt->get_result();

if (isset($_SESSION['user'])) {
    $query = 'SELECT User_Points FROM user WHERE UserID = ? ';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $_SESSION['user']['UserID']);
    $stmt->execute();
    $stmt->bind_result($UserPoints);
    $stmt->fetch();
    $stmt->close();
}

?>