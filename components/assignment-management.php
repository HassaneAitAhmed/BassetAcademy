<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Check if the user has the role of Admin
if ($_SESSION['user']['Role'] !== 'Admin') {
    echo "Access denied. You do not have permission to access this page.";
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>assignment management</title>
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/components/assignment-management.css">
</head>
<body>
    <div class="stud-assignment-container">
        <div class="assignment-instruction">
            <span>قواعد يجب احترامها</span>
            <p dir="rtl"> بإمكانكم العثور على الواجب في جدول الواجبات أدناه. عند الضغط عليه، سيتم تنزيل الملف، وسيبدأ العدّاد التنازلي للوقت في الجدول. بعد انتهاء الوقت، إذا لم يتم رفع الحلّ في الحقل المخصص له، فلن يتم قبول الواجب .</p>
        </div>
        <div class="assignments-table">
            <table class="assignments-table-container">
                <tr>
                    <th>الوقت المتبقي</th>
                    <th>حقل الإجابة</th>
                    <th>الواجب</th>
                    <th>رقم الواجب</th>
                </tr>
                <tr>
                    <td>2:00:00</td>
                    <td><label for="answer1"><i class="fa-solid fa-file-pen"></i></label><input type="file" id="answer1"></i></td>
                    <td><a href=""><i class="fa-solid fa-file"></i></a></td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>2:00:00</td>
                    <td><label for="answer2"><i class="fa-solid fa-file-pen"></i></label><input type="file" id="answer2"></i></td>
                    <td><a href=""><i class="fa-solid fa-file"></i></a></td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>2:00:00</td>
                    <td><label for="answer3"><i class="fa-solid fa-file-pen"></i></label><input type="file" id="answer3"></i></td>
                    <td><a href=""><i class="fa-solid fa-file"></i></a></td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>2:00:00</td>
                    <td><label for="answer3"><i class="fa-solid fa-file-pen"></i></label><input type="file" id="answer3"></i></td>
                    <td><a href=""><i class="fa-solid fa-file"></i></a></td>
                    <td>4</td>
                </tr>
                
            </table>
        </div>
    </div>
</body>
</html>