<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['user']['Role'] !== 'Admin') {
    echo "Access denied. You do not have permission to access this page.";
    exit();
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bassetdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adminFName = $_POST['adminFName'];
    $adminLName = $_POST['adminLName'];
    $adminEmail = $_POST['adminEmail'];
    $adminPassword = password_hash($_POST['adminPassword'], PASSWORD_DEFAULT);
    $role = 'Admin';

    $stmt = $conn->prepare("INSERT INTO User (User_Email, User_Password, Role, User_FirstName, User_LastName) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $adminEmail, $adminPassword, $role, $adminFName, $adminLName);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle admin deletion
if (isset($_GET['delete'])) {
    $adminId = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM User WHERE UserID = ? AND Role = 'Admin'");
    $stmt->bind_param("i", $adminId);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch the list of admins
$admins = [];
$result = $conn->query("SELECT UserID, User_Email FROM User WHERE Role = 'Admin'");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $admins[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel</title>
    <link rel="stylesheet" href="../css/admin-control.css">
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/nav-teacher.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        function confirmDeletion(adminId) {
            if (confirm("Are you sure you want to delete this admin?")) {
                window.location.href = "?delete=" + adminId;
            }
        }
    </script>
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
            <a href="Admin-Dashboard.php" class="on-media-btns" dir="rtl">&nbsp;&nbsp;ادارة الموقع
                <i class="fas fa-sign-in-alt"></i></a>
            <a href="pages/about-us-teacher.php" class="on-media-btns">من نحن ؟</a>
            <a href="pages/Montada-teacher.php" class="on-media-btns">المنتدى</a>
        </div>
        </div>
    </nav>


    <div class="admin-management-container" dir="rtl">
        <header>
            <h1>إدارة المسؤولين</h1>
        </header>

        <!-- Form Section -->
        <section class="form-section">
            <h2>إضافة مسؤول جديد</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="adminFName"><i class="fa fa-user"></i> الاسم</label>
                    <input type="text" id="adminFName" name="adminFName" placeholder=" الاسم " required>
                </div>
                <div class="form-group">
                    <label for="adminLName"><i class="fa fa-user"></i> اللقب</label>
                    <input type="text" id="adminLName" name="adminLName" placeholder=" اللقب" required>
                </div>
                <div class="form-group">
                    <label for="adminEmail">البريد الإلكتروني</label>
                    <input type="email" id="adminEmail" name="adminEmail" placeholder="أدخل البريد الإلكتروني" required>
                </div>
                <div class="form-group">
                    <label for="adminPassword"><i class="fa fa-lock"></i> كلمة المرور</label>
                    <input type="password" id="adminPassword" name="adminPassword" placeholder="أدخل كلمة المرور"
                        required>
                </div>
                <button type="submit" class="add-btn"><i class="fa fa-plus"></i> إضافة مسؤول</button>
                <button type="reset" class="reset-btn"><i class="fa fa-rotate-left"></i> إعادة تعيين</button>
            </form>
        </section>

        <!-- Table Section -->
        <section class="table-section">
            <h2>قائمة المسؤولين</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>البريد الإلكتروني</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($admins) > 0): ?>
                        <?php foreach ($admins as $index => $admin): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($admin['User_Email']) ?></td>
                                <td>
                                    <button onclick="confirmDeletion(<?= $admin['UserID'] ?>)" class="delete-btn">حذف</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">لا يوجد مسؤولين.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
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
</body>

</html>