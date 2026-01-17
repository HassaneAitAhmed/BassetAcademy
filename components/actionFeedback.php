<?php
session_start();
unset($_SESSION["feedback_errors"]);

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'bassetdb';

@$My_connection = new mysqli($servername, $username, $password, $dbname);

if ($My_connection->connect_error) {
    die("Connection failed: " . $My_connection->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    $FeedbackText = isset($_POST['feedbackText']) ? trim($_POST['feedbackText']) : '';
    $Rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $UserID = isset($_SESSION['user']['UserID']) ? $_SESSION['user']['UserID'] : NULL;  
    $FeedbackDate = date('Y-m-d H:i:s');

    if (strlen($FeedbackText) <= 5) {
        $errors['feedbackText'] = "الرجاء إدخال تعليق يحتوي على 6 أحرف على الأقل.";
    } elseif (preg_match("/^[0-9]*$/", $FeedbackText)) {
        $errors['feedbackText'] = "الرجاء إدخال تعليق لا يحتوي على أرقام فقط.";
    } elseif (preg_match("/[^a-zA-Z0-9\s[\u0621-\u064A\s]+$/", $FeedbackText)) {
        $errors['feedbackText'] = "الرجاء إدخال تعليق بدون رموز خاصة.";
    }

    if ($Rating == 0) {
        $errors['rating'] = "الرجاء تحديد التقييم باستخدام النجوم";
    }

    if (!empty($errors)) {
        $_SESSION["feedback_errors"] = $errors;
        header('Location: ../components/Student-Dashboard.php');  
        exit();
    }

    $query = 'INSERT INTO feedback (UserID, FeedbackContent, Rating, FeedbackSendDate) VALUES (?, ?, ?, ?)';
    $stmt = $My_connection->prepare($query);
    $stmt->bind_param('isis', $UserID, $FeedbackText, $Rating, $FeedbackDate);

    if ($stmt->execute()) {
        $_SESSION["feedback_success"] = "تم إرسال التعليق بنجاح.";
        header('Location: Student-Dashboard.php');
        $Success = 'FeedBackSent';
        echo json_encode($Success);
        exit();
    } else {
        $_SESSION["feedback_errors"] = ["general" => "حدث خطأ أثناء إرسال التعليق. حاول مرة أخرى."];
        header('Location: Student-Dashboard.php');
        exit();
    }

    $stmt->close();
    $My_connection->close();
}
?>
