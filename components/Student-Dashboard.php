<?php
session_start();

if (!isset($_SESSION['user']['UserID'])) {
    header('Location: login.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "bassetdb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../css/payements1.css">
    <link rel="stylesheet" href="../css/mycourses1.css">
    <link rel="stylesheet" href="../css/Student-Dashboard3.css">
    <link rel="stylesheet" href="../css/Feedback-sections.css">
    <link rel="stylesheet" href="../css/exam-reviews.css">
    <link rel="stylesheet" href="../css/assignment-managements.css">
    <link rel="stylesheet" href="../css/User-info.css">
    <link rel="stylesheet" href="../css/sessions-tracking.css">
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
    <script defer src="../js/components/Student-Dashboard.js"></script>
    <script defer src="../js/components/Feedback-section.js"></script>
    <link rel="stylesheet" href="../css/nav-stud.css">
    <link rel="stylesheet" href="../css/footer.css">
    <script defer src="../js/components/nav.js"></script>
    <script src="../js/components/opinion.js"></script>
    <style>
        #updateProfileBtn:hover {
            background-color: orange;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <nav>
        <div class="container">
            <!--Navigation Bar left side-->
            <div class="left-side">
                <div class="NavLogo"><img src="../assets/images/Academy.png" alt="Logo" height="150px" width="150px" onclick="redirectToHome()" style="cursor: pointer;"></div>

            </div>
            <!--Navigation Bar middle part-->
            <div class="middle-part">
                <a href="pages/about-us-stud.php" class="Navbtn" id="about-us-btn">من نحن ؟</a>
                <a href="../student.php #courses " class="Navbtn" id="courses-btn">دوراتنا</a>
                <a href="pages/Montada-stud.php" class="Navbtn" id="contact-us-btn">المنتدى</a>
            </div>
            <!--Navigation Bar right side-->
            <div class="right-side">
                <div class="LOG">
                    <a href="Student-Dashboard.php" class="Navbtn" id="Acc"></i>حسابي </a>
                    <a href="Student-Dashboard.php" class="Navbtn" id="points"></i> نقاطي : <?php if (isset($UserPoints)) {
                                                                                                echo $UserPoints;
                                                                                            } ?> </a>
                </div>
                <!-- On media right side-->
                <div class="drop-down">
                    <input type="checkbox" id="drop-down-menu">
                    <label for="drop-down-menu" id="DDM-label"><img src="../assets/images/DDM.png" alt=""></label>
                </div>
            </div>


        </div>
        <br>
        <!--On media drop-menu-->
        <div class="media-drop-down-btns">
            <a href="../components/Student-Dashboard.php" class="on-media-btns" dir="rtl">&nbsp;&nbsp;حسابي <i class="fas fa-sign-in-alt"></i></a>
            <a href="Student-Dashboard.php" class="on-media-btns" dir="rtl">&nbsp;&nbsp; نقاطي : <?php if (isset($UserPoints)) {
                                                                                                        echo $UserPoints;
                                                                                                    } ?> <i class="fa-solid fa-user"></i></a>
            <a href="../student.php #courses " class="on-media-btns">دوراتنا</a>
            <a href="pages/about-us-stud.php" class="on-media-btns">من نحن ؟</a>
            <a href="pages/Montada-stud.php" class="on-media-btns">المنتدى</a>
        </div>
        </div>
    </nav>

    <div class="student-dashboard-container">
        <!--Dashboard Left Side-->
        <div class="dashboard-left-side">
            <!-- User Exams management-->
            <form method="POST" enctype="multipart/form-data">
                <div class="user-exams">
                    <div class="stud-assignment-container" style="margin-top: 5%;">
                        <div class="assignment-instruction">
                            <span>قواعد يجب احترامها</span>
                            <p dir="rtl"> بإمكانكم العثور على الواجب في جدول الواجبات أدناه. عند الضغط عليه، سيتم تنزيل
                                الملف، وسيبدأ العدّاد التنازلي للوقت في الجدول. بعد انتهاء الوقت، إذا لم يتم رفع الحلّ في
                                الحقل المخصص له، فلن يتم قبول الواجب .</p>
                        </div>
                        <div>
                            <table class="assignments-table">
                                <tr>
                                    <th>حقل الإجابة</th>
                                    <th>الدورة</th>
                                    <th>الامتحان</th>
                                    <th>رقم الامتحان</th>
                                    <th>إرسال الواجب</th>
                                </tr>
                                <?php if ($tasks->num_rows > 0): ?>
                                    <?php while ($task = $tasks->fetch_assoc()): ?>
                                        <form method="POST" enctype="multipart/form-data">
                                            <tr>
                                                <td>
                                                    <label for="answer<?php echo $task['TaskID']; ?>"><i class="fa-solid fa-file-pen"></i></label>
                                                    <input type="file" name="answer" id="answer<?php echo $task['TaskID']; ?>" required>
                                                </td>
                                                <td><?php echo $task['Task_title']; ?></td>
                                                <td>
                                                    <?php if (!empty($task['Task_file'])): ?>
                                                        <a href="<?php echo $task['Task_file']; ?>" target="_blank">
                                                            <i class="fa-solid fa-file"></i> تحميل الامتحان
                                                        </a>
                                                    <?php else: ?>
                                                        <span>لا يوجد ملف</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo $task['TaskID']; ?></td>
                                                <td>
                                                    <button style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; font-size: 16px;" type="submit" name="submit_task" value="<?php echo $task['TaskID']; ?>">إرسال الواجب</button>
                                                </td>
                                            </tr>
                                        </form>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" style="text-align: center;">لا توجد مهام للطالب حالياً.</td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </form>

            <?php if (isset($_SESSION['success'])): ?>
                <div id="success-popup" class="popup success-popup open">
                    <p><?php echo htmlspecialchars($_SESSION['success']); ?></p>
                    <button class="close-btn" data-popup-id="success-popup">Close</button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div id="error-popup" class="popup error-popup open">
                    <p><?php echo htmlspecialchars($_SESSION['error']); ?></p>
                    <button class="close-btn" data-popup-id="error-popup">Close</button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>





            <!-- User Exams Results -->
            <div class="user-exams-result">
                <div class="review-container" style="margin-top: 7%;">
                    <h1 style="text-align: right; margin-right: 10%;" dir="rtl">نتائج الإمتحانات :</h1>
                    <table class="exam-result-stats">
                        <tr>
                            <th>العلامة</th>
                            <th>التصحيح</th>
                            <th>الامتحان</th>
                            <th>حالة الامتحان</th>
                            <th>تاريخ الامتحان</th>
                            <th>رقم الامتحان</th>
                        </tr>
                        <?php if ($tasksresult->num_rows > 0): ?>
                            <?php while ($row = $tasksresult->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <?= is_null($row['AssessmentScore']) ? 'لم يتم التصحيح' : htmlspecialchars($row['AssessmentScore']) ?>
                                    </td>
                                    <td>
                                        <a href="<?= htmlspecialchars($row['Task_solution']) ?>"><i class="fa-regular fa-file-code"></i></a>
                                    </td>
                                    <td>
                                        <a href="<?= htmlspecialchars($row['Task_file']) ?>"><i class="fa-solid fa-file"></i></a>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($row['AssessmentStatus']) === 'Pending' ? 'قيد التصحيح' : 'تم التصحيح' ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['AssessmentDate']) ?></td>
                                    <td><?= htmlspecialchars($row['TaskID']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center;">لا توجد مهام للطالب حالياً.</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
            <!--User Feedback Form-->
            <div class="user-feedback">
                <div class="feedback-container" style="margin-top: 5%;">
                    <div class="feedback-user-info">
                        <div class="user-img"> <img src="../assets/images/user.png" alt="" width="150px"
                                height="100px"></div>
                        <div class="user-name-phone_number">
                            <p><span style="font-size: 4ch;">User name :</span><span style="font-size: 3ch; color: darkblue;"><?php echo '   ' . $userLastName . ' ' . $userFirstName; ?></span></p>
                            <p><span style="font-size: 4ch;">Phone Number:</span><span style="font-size: 3ch; color: darkblue;"><?php echo '   ' . $userPhone ?></span> </p>
                        </div>
                    </div>
                    <div class="feedback-form">
                        <form action="actionFeedback.php" method="POST">
                            <div style="text-align: right; font-size: 3ch; font-weight: bold;">
                                <label for="feedback-text;"> : (أبدنا رأيك في محتوى المنصة) Feedback</label>
                            </div>

                            <br>
                            <textarea name="feedbackText" id="feedback-text" dir="rtl"></textarea>
                            <?php if (isset($_SESSION["feedback_errors"]['feedbackText'])): ?>
                                <p id="text-error"><?php echo $_SESSION["feedback_errors"]['feedbackText']; ?></p>
                            <?php endif; ?>

                            <br>
                            <div class="stars-rating">
                                <p dir="rtl">تقيمك للمنصة :</p>
                                <div id="stars-rate">
                                    <label for="star1" id="star1-label"><i class="fa-solid fa-star star1"></i></label>
                                    <input id="star1" type="radio" name="rating" value="1">
                                    <label for="star2" id="star2-label"><i class="fa-solid fa-star star2"></i></label>
                                    <input id="star2" type="radio" name="rating" value="2">
                                    <label for="star3" id="star3-label"><i class="fa-solid fa-star star3"></i></label>
                                    <input id="star3" type="radio" name="rating" value="3">
                                    <label for="star4" id="star4-label"><i class="fa-solid fa-star star4"></i></label>
                                    <input id="star4" type="radio" name="rating" value="4">
                                    <label for="star5" id="star5-label"><i class="fa-solid fa-star star5"></i></label>
                                    <input id="star5" type="radio" name="rating" value="5">

                                </div>
                                <?php if (isset($_SESSION["feedback_errors"]['rating'])): ?>
                                    <p id="rating-error"><?php echo $_SESSION["feedback_errors"]['rating']; ?></p>
                                <?php endif; ?>
                                <div>
                                    <input type="submit" value="send" id="submit-feedback">
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <?php
            unset($_SESSION["feedback_errors"]);
            ?>

            <!--User Payment Form-->
            <div class="user-payment">
                <div class="payment-container">
                    <h1>شحن المحفظة</h1>

                    <div class="instructions">
                        <h2>التعليمات</h2>
                        <ul>
                            <li>اختر طريقة دفع مناسبة وحول المبلغ المراد شحنه.</li>
                            <li>أدخل رقم الرصيد وارفق صورة واضحة للإيصال.</li>
                            <li>ستتم المراجعة خلال 24 ساعة وشحن المحفظة تلقائياً.</li>
                        </ul>
                    </div>

                    <div class="payment-methods">
                        <div class="payment-method">
                            <div class="pay-img">
                                <img src="../assets/images/AlgeriePoste.png" alt="AlgeriePoste">
                            </div>
                            <div class="pay-des">
                                <h3>حساب البريد</h3>
                                <p>18520078 clé 20</p>
                            </div>
                        </div>

                        <div class="payment-method">
                            <div class="pay-img">
                                <img src="../assets/images/Baridimob.png" alt="Baridimob">
                            </div>
                            <div class="pay-des">
                                <h3>حساب Baridimob</h3>
                                <p>00799999001852007820</p>
                            </div>
                        </div>
                    </div>

                    <?php
                    $amountError = isset($_SESSION['amountError']) ? $_SESSION['amountError'] : '';
                    $receiptError = isset($_SESSION['receiptError']) ? $_SESSION['receiptError'] : '';
                    $amount = isset($_SESSION['amount']) ? $_SESSION['amount'] : '';
                    ?>

                    <form id="payment-form" method="POST" action="actionpayementt.php" enctype="multipart/form-data">
                        <div class="amount-input">
                            <label for="amount">المبلغ المراد شحنه</label>
                            <input type="text" id="amount" name="amount" placeholder="أدخل المبلغ" value="<?= htmlspecialchars($amount) ?>">
                            <br>
                            <?php if ($amountError): ?>
                                <span style="color: red;"><?= $amountError ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="file-upload">
                            <label for="receipt">اختر ملف الإيصال</label>
                            <br>
                            <input type="file" id="receipt" name="receipt" accept="image/*">
                            <?php if ($receiptError): ?>
                                <span style="color: red;"><?= $receiptError ?></span>
                            <?php endif; ?>
                        </div>

                        <button type="submit" name="submit">تأكيد العملية</button>
                    </form>

                    <?php
                    unset($_SESSION['amountError']);
                    unset($_SESSION['receiptError']);
                    unset($_SESSION['amount']);
                    ?>

                    <div class="transaction-history">
                        <h2>العمليات السابقة</h2>
                        <?php if ($result->num_rows > 0): ?>
                            <ul>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <li>
                                        <p>رقم العملية: <?= htmlspecialchars($row['PayementID']) ?></p>
                                        <p>القيمة: <?= htmlspecialchars($row['Payementvalue']) ?> دينار جزائري</p>
                                        <p>الحالة: <?= htmlspecialchars($row['PaymentStatus']) ?></p>
                                        <?php if (!empty($row['Payementphoto'])): ?>
                                            <p>الإيصال: <a href="uploads/<?= htmlspecialchars($row['Payementphoto']) ?>" target="_blank">عرض الإيصال</a></p>
                                        <?php endif; ?>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php else: ?>
                            <p>لا توجد بيانات</p>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
            <div class="popup" id="popup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); z-index: 1000;">
                <p id="popup-message"></p>
                <button onclick="closePopup()">إغلاق</button>
            </div>


            <!--User Informations-->
            <div class="userI">
                <div class="user-profile-container">
                    <div class="user-header">
                        <div class="user-icon">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png"
                                alt="User Icon">
                        </div>
                        <h2>
                            ملف المستخدم
                            📂
                        </h2>
                    </div>

                    <div class="user-info">
                        <div class="user-info-icons">
                            <img src="../assets/images/user-info.png" alt="user info icon">
                        </div>

                        <div class="user-info-content">
                            <h3><?php echo htmlspecialchars($_SESSION['user']['User_FirstName'] . ' ' . $_SESSION['user']['User_LastName']); ?></h3>
                            <hr>
                            <p>☎️ <?php echo htmlspecialchars($user['User_Phone']); ?></p>
                            <p>✔️ <?php echo htmlspecialchars($user['User_Email']); ?></p>
                        </div>
                    </div>

                    <div class="stats-section">
                        <h3>📊 احصائيات دوراتك 📊</h3>
                        <div class="stats-grid">
                            <div class="stat-item">
                                <div class="stat-circle" id="videos-circle">
                                    <span><?php echo $videos_watched_percentage; ?>%</span>
                                </div>
                                <p>🎬 عدد الفيديوهات شوفتها</p>
                            </div>
                            <div class="stat-item">
                                <div class="stat-circle" id="tests-circle">
                                    <span><?php echo $tests_completed_percentage; ?>%</span>
                                </div>
                                <p>📝 عدد الاختبارات خلصتها</p>
                            </div>
                            <div class="stat-item">
                                <div class="stat-circle" id="results-circle">
                                    <span><?php echo $average_score; ?>%</span>
                                </div>
                                <p>📈 متوسط النتائج اللي جبتها</p>
                            </div>

                        </div>
                    </div>
                    <div style="display:flex; justify-self:center; margin-top:5%;">
                        <button id="updateProfileBtn" style="font-size:3ch; padding: 10px; border-radius:20%;">
                            تحديث معلومات الحساب
                        </button>
                    </div>
                </div>
            </div>

            <!--User Tracking informations-->
            <div class="user-tracking">
                <div class="session-tracking-container">
                    <div class="stats" style="text-align: center;">
                        <h3>🔐 معلمومات و تفاصيل حول امن الحساب</h3>
                    </div>
                    <div class="activity-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>🗓️ تاريخ تسجيل الدخول</th>
                                    <th>🌐 المتصفح</th>
                                    <th>💻 نظام التشغيل</th>
                                    <th>🔍 اسم الجهاز</th>
                                    <th>📱 نوع الجهاز</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($activity = $security_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo date('l, j F Y H:i', strtotime($activity['logtime'])); ?></td>
                                        <td><?php echo $activity['browser']; ?></td>
                                        <td><?php echo $activity['deviceoperator']; ?></td>
                                        <td><?php echo $activity['devicename']; ?></td>
                                        <td><?php echo $activity['devicetype']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--User Courses-->
            <div class="user-courses">
                <h1>دوراتي</h1>
                <main class="courses-list">
                    <?php
                    if ($courses->num_rows > 0) {
                        while ($course = $courses->fetch_assoc()) {
                            $courseID = htmlspecialchars($course['CourseID']);
                    ?>
                            <div class="course-card">
                                <div class="course-header">
                                    <?php echo htmlspecialchars($course['Course_title']); ?>
                                </div>
                                <div class="course-content">
                                    <img src="<?php echo htmlspecialchars($course['Course_image']); ?>"
                                        alt="دورة <?php echo htmlspecialchars($course['Course_title']); ?>"
                                        class="course-image">
                                    <div class="course-details">
                                        <p class="course-description">
                                            <?php echo htmlspecialchars($course['Course_description']); ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="course-action">
                                    <!-- Pass the course ID dynamically to the redirect function -->
                                    <button class="btn-continue" onclick="redirectToCourse(<?php echo $courseID; ?>)">متابعة الدورة</button>
                                </div>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <h2 style="text-align: center; color:blue ">لا توجد دورات متاحة.</h2>
                    <?php
                    }
                    ?>
                </main>
            </div>

        </div>

        <!--Dashboard Right Side-->
        <div class="dashboard-right-side">
            <ul class="student-dashboard-ul">
                <li id="user-info-btn">معلومات المستخدم <i class="fa-regular fa-user"
                        style="margin-left: 10px; color: black; font-weight: bold;"></i> </li>
                <li id="user-courses-btn">دوراتي <i class="fa-brands fa-discourse"
                        style="margin-left: 10px; color: red;"></i>
                </li>
                <li id="user-paiment-btn">محفظتي <i class="fa-solid fa-cart-shopping"
                        style="margin-left: 10px; color: cornflowerblue;"></i></li>
                <li id="user-feedback-btn">Feedback <i class="fa-solid fa-comment"
                        style="margin-left: 10px; color: rgb(237, 100, 232);"></i></li>
                <li id="user-security-btn" dir="rtl"> <i class="fa-solid fa-shield-halved"></i> الآمان و تاريخ تسجيل
                    الدخول
                </li>
                <li id="user-exam-btn" dir="rtl"> <i class="fa-solid fa-square-poll-vertical"
                        style="margin-left: 10px; color: rgb(255, 0, 0);"></i>الامتحانات</li>
                <li id="user-exam-results-btn" dir="rtl"> <i class="fa-solid fa-square-poll-vertical"
                        style="margin-left: 10px; color: rgb(255, 0, 0);"></i>نتائج الواجب/الامتحانات</li>
                <li id="logoutBtn" dir="rtl"> <i class="fa-solid fa-square-poll-vertical"
                        style="margin-left: 10px; color: rgb(255, 0, 0);"></i>تسجيل الخروج</li>
            </ul>
        </div>
    </div>
    <footer>
        <div>
            <div class="footer">
                <div class="footer-left-side">
                    <div class="motivation-text">
                        <h3> ! مفتاح المستقبل &lrm;</h3>
                        <p> العلم هو الأساس الذي تبنى عليه الإنجازات، فلا تستخف بجهودك اليوم. كل ساعة تقضيها في الدراسة تقربك من تحقيق أحلامك. التحديات التي تواجهها هي مجرد خطوات على طريق النجاح. اجعل شغفك بالمعرفة دافعًا، وكن واثقًا أن مستقبلك المشرق ينتظرك &lrm;</p>
                    </div>
                    <br>
                    <div class="footer-contacts">
                        <div class="phone"><i class="fa-brands fa-whatsapp"></i>
                            <p>Phone Number : 0712345678</p>
                        </div>
                        <div class="mail"><i class="fa-regular fa-envelope"></i>
                            <p>Gmail : adeladel@gmail.com</p>
                        </div>
                    </div>
                </div>

                <div class="footer-right-side">
                    <div class="footer-logo"><img src="assets/images/Math.png" alt=""></div>
                    <p id=""> ★ منصة الاستاذ عبد الباسط للرياضيات </p>
                    <div class="footer-socials">
                        <a href="https://web.facebook.com/"><i class="fa-brands fa-facebook"></i></a>
                        <a href="https://www.instagram.com/abdelbassetprof/"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.youtube.com/@%D8%A7%D9%84%D8%A3%D8%B3%D8%AA%D8%A7%D8%B0%D8%B9%D8%A8%D8%AF%D8%A7%D9%84%D8%A8%D8%A7%D8%B3%D8%B7-%D8%B31%D9%88"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>

                <div class="footer-lower-part">
                    <p>
                        © 2024 جميع الحقوق محفوظة. Developed by - Adel Hassen Mahdi -
                    </p>
                </div>

            </div>
        </div>
    </footer>

    <script defer>
        document.querySelector("#logoutBtn").addEventListener("click", () => {
            const xhttp = new XMLHttpRequest();
            xhttp.open("POST", "logout.php", true);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhttp.onload = function() {
                if (xhttp.status === 200) {
                    window.location.href = "SignIn.php";
                } else {
                    console.error("Logout failed.");
                }
            };

            xhttp.onerror = function() {
                console.error("Request error.");
            };

            xhttp.send("logout=true");
        });

        document.querySelector("#updateProfileBtn").addEventListener("click", function() {
            window.location.href = "updateProfile.php";
        });


        document.addEventListener('DOMContentLoaded', function() {
            var closeButtons = document.querySelectorAll('.close-btn');
            closeButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var popupId = button.getAttribute('data-popup-id');
                    var popup = document.getElementById(popupId);
                    if (popup) {
                        popup.style.display = 'none';
                    } else {
                        console.error("Popup element not found with ID:", popupId);
                    }
                });
            });
        });
    </script>


</body>

</html>