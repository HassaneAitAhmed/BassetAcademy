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


<?php
require_once 'db_connection.php';

$searchQuery = isset($_POST['search']) ? $_POST['search'] : '';
$searchParam = "%" . $searchQuery . "%";

$sql = "SELECT UserID, CONCAT(User_FirstName, ' ', User_LastName) AS FullName, User_Email, User_Phone, User_Points
        FROM User WHERE Role = 'Student' AND 
        (User_FirstName LIKE ? OR User_LastName LIKE ? OR User_Email LIKE ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error in SQL query: " . $conn->error);
}

$students = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
} else {
    echo "No students found.";
}

if (isset($_POST['delete_user'])) {
    $userID = $_POST['delete_user'];
    $deleteSql = "DELETE FROM User WHERE UserID = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $userID);
    if ($stmt->execute()) {
        echo "<script>alert('تم حذف الطالب بنجاح');</script>";
    } else {
        echo "<script>alert('خطأ في حذف الطالب');</script>";
    }
}

if (isset($_POST['update_user'])) {
    $userID = $_POST['user_id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $points = $_POST['points'];

    $updateSql = "UPDATE User SET User_FirstName = ?, User_LastName = ?, User_Email = ?, User_Phone = ?, User_Points = ? WHERE UserID = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ssssii", $firstName, $lastName, $email, $phone, $points, $userID);

    if ($stmt->execute()) {
        echo "<script>alert('تم تعديل بيانات الطالب بنجاح');</script>";
    } else {
        echo "<script>alert('خطأ في تعديل بيانات الطالب');</script>";
    }
}


?>


<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة الطلاب</title>
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/nav-teacher.css">

    <style>
        /* Add your styles here */
        .popUpStudentinfo {
            display: none;
        }

        .TableStudent table {
            width: 100%;
        }

        .TableStudent table,
        th,
        td {
            border: 1px solid black;
        }



        .StudentL {
            direction: rtl;
            font-family: 'Segoe UI', sans-serif;
        }

        .StudentL h1 {
            border: 3px solid #333;
            border-radius: 5px;
            padding: 1% 0 1.2% 0;
            margin-bottom: 5%;
            color: #333;
            font-weight: bold;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .SearchStudent {
            display: flex;
            align-items: baseline;
            justify-content: space-evenly;
        }

        .SearchStudent input {
            width: 50%;
            padding: 10px;
            margin-bottom: 10px;
            margin-right: 30px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .StudentL button {
            padding: 10px 20px;
            margin-left: 10px;
            background-color: rgb(47, 144, 228);
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            color: #fff;
        }

        .SearchStudent button:hover {
            background-color: rgb(15, 105, 184);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }

        .TableStudent {
            margin-top: 5%;
            border: 1px solid #ccc;
            padding: 10px 15px;
            text-align: center;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            transition: all 0.6s ease;
            overflow-x: auto;
        }

        .TableStudent:hover {
            background-color: #f5f5f5;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
        }

        .TableStudent table {
            width: 100%;
        }

        .TableStudent td,
        th {
            padding: 8px;
        }

        .TableStudent th {
            padding-bottom: 10px;
        }

        .TableStudent td {
            cursor: pointer;
        }

        .popUpStudentinfo {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            direction: rtl;
        }

        .popUpStudentinfo-content {
            background-color: #fff;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            text-align: center;
            border-radius: 8px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .popUpStudentinfo-field {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .popUpStudentinfo-field p {
            font-weight: bold;
            margin-bottom: 5px;
            direction: rtl;
            text-align: right;
        }

        .popUpStudentinfo-field input,
        .popUpStudentinfo-field select {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <nav>
        <div class="container">
            <!--Navigation Bar left side-->
            <div class="left-side">
                <div class="NavLogo"><img src="../assets/images/Academy.png" alt="Logo" height="150px" width="150px"
                        onclick="redirectToHome()" style="cursor: pointer;"></div>

            </div>
            <!--Navigation Bar middle part-->
            <div class="middle-part">
                <a href="pages/about-us-teacher.php" class="Navbtn" id="about-us-btn">من نحن ؟</a>
                <a href="pages/Montada-teacher.php" class="Navbtn" id="contact-us-btn">المنتدى</a>
            </div>
            <!--Navigation Bar right side-->
            <div class="right-side">
                <div class="LOG">
                    <a href="Admin-Dashboard.php" class="Navbtn" id="Acc"></i>ادارة الموقع </a>
                </div>
                <div class="drop-down">
                    <input type="checkbox" id="drop-down-menu">
                    <label for="drop-down-menu" id="DDM-label"><img src="../assets/images/DDM.png" alt=""></label>
                </div>
            </div>


        </div>
        <br>
        <div class="media-drop-down-btns">
            <a href="Admin-Dashboard.php" class="on-media-btns" dir="rtl">&nbsp;&nbsp;ادارة الموقع
                <i class="fas fa-sign-in-alt"></i></a>
            <a href="pages/about-us-teacher.php" class="on-media-btns">من نحن ؟</a>
            <a href="pages/Montada-teacher.php" class="on-media-btns">المنتدى</a>
        </div>
        </div>
    </nav>

    <div class="content-section scrollable-section" id="students">
    <h3>👨‍🎓 قائمة الطلاب</h3>
    <div class="messages-content">
        <div class="StudentL">
            <h1>قائمة التلاميذ</h1>
            <div class="SearchStudent">
                <form method="POST">
                    <input type="text" name="search" placeholder="ابحث عن التلاميذ..." style="text-align: right;" value="<?php echo htmlspecialchars($searchQuery); ?>">
                    <button type="submit">ابحث</button>
                </form>
            </div>
            <div class="TableStudent">
                <table>
                    <tr>
                        <th>الاسم الكامل</th>
                        <th>البريد الإلكتروني</th>
                        <th>رقم الهاتف</th>
                        <th>قيمة المحفظة</th>
                        <th>الإجراءات</th>
                    </tr>
                    <?php foreach ($students as $student): ?>
                        <tr onclick="showStudentInfo(<?php echo $student['UserID']; ?>, '<?php echo $student['FullName']; ?>', '<?php echo $student['User_Email']; ?>', '<?php echo $student['User_Phone']; ?>', <?php echo $student['User_Points']; ?>)">
                            <td><?php echo htmlspecialchars($student['FullName']); ?></td>
                            <td><?php echo htmlspecialchars($student['User_Email']); ?></td>
                            <td><?php echo htmlspecialchars($student['User_Phone']); ?></td>
                            <td><?php echo htmlspecialchars($student['User_Points']); ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_user" value="<?php echo $student['UserID']; ?>">
                                    <button type="submit">حذف</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <div id="studentpopUpStudentinfo" class="popUpStudentinfo">
                <div class="popUpStudentinfo-content">
                    <span class="close" onclick="closepopUpStudentinfo()">&times;</span>
                    <h2>معلومات الطالب</h2>
                    <form method="POST">
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="popUpStudentinfo-field">
                            <p>الاسم الكامل:</p>
                            <input type="text" id="studentName" name="first_name" style="text-align: right;">
                            <input type="text" id="studentLastName" name="last_name" style="text-align: right;">
                        </div>
                        <div class="popUpStudentinfo-field">
                            <p>البريد الإلكتروني:</p>
                            <input type="email" id="studentEmail" name="email" style="text-align: right;">
                        </div>
                        <div class="popUpStudentinfo-field">
                            <p>رقم الهاتف:</p>
                            <input type="text" id="studentPhone" name="phone" style="text-align: right;">
                        </div>
                        <div class="popUpStudentinfo-field">
                            <p>قيمة المحفظة:</p>
                            <input type="text" id="studentWallet" name="points" style="text-align: right;">
                        </div>
                        <button type="submit" name="update_user">حفظ التعديلات</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <div>
        <div class="footer">
            <div class="footer-left-side">
                <div class="motivation-text">
                    <h3> ! مفتاح المستقبل &lrm;</h3>
                    <p> العلم هو الأساس الذي تبنى عليه الإنجازات، فلا تستخف بجهودك اليوم. كل ساعة تقضيها في الدراسة
                        تقربك من تحقيق أحلامك. التحديات التي تواجهها هي مجرد خطوات على طريق النجاح. اجعل شغفك بالمعرفة
                        دافعًا، وكن واثقًا أن مستقبلك المشرق ينتظرك &lrm;</p>
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
                    <a
                        href="https://www.youtube.com/@%D8%A7%D9%84%D8%A3%D8%B3%D8%AA%D8%A7%D8%B0%D8%B9%D8%A8%D8%AF%D8%A7%D9%84%D8%A8%D8%A7%D8%B3%D8%B7-%D8%B31%D9%88"><i
                            class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-lower-part">
                <p>
                    © 2024 جميع الحقوق محفوظة. Developed by - Adel Hassen Mahdi -
                </p>
            </div>

        </div>
    </div>


    <script>
function showStudentInfo(userID, fullName, email, phone, points) {
    document.getElementById("studentpopUpStudentinfo").style.display = "block";
    document.getElementById("user_id").value = userID;
    document.getElementById("studentName").value = fullName.split(' ')[0];
    document.getElementById("studentLastName").value = fullName.split(' ')[1];
    document.getElementById("studentEmail").value = email;
    document.getElementById("studentPhone").value = phone;
    document.getElementById("studentWallet").value = points;
}

function closepopUpStudentinfo() {
    document.getElementById("studentpopUpStudentinfo").style.display = "none";
}
</script>

</body>

</html>