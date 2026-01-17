<?php
session_start();

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'bassetdb';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['user']['UserID'])) {
    $query = 'SELECT * FROM User WHERE UserID = ?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $_SESSION['user']['UserID']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $firstName = $row['User_FirstName'];
        $lastName = $row['User_LastName'];
        $phone = $row['User_Phone'];
        $branch = $row['User_Branch'];
        $level = $row['User_Level'];
        $email = $row['User_Email'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $lastName = trim($_POST['lastName']);
    $firstName = trim($_POST['firstName']);
    $email = trim($_POST['email']);
    $phoneNum = trim($_POST['phoneNum']);
    $studyLevel = trim($_POST['level']);
    $branch = trim($_POST['branch']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $newPassword = trim($_POST['newPassword']);

    if (strlen($lastName) < 3 || strlen($lastName) > 40 || preg_match('/[!@$%*#]/', $lastName)) {
        $errors['lastName'] = "يجب أن يكون اسم العائلة بين 3 و 40 حرفًا ولا يحتوي على أحرف خاصة";
    }

    if (strlen($firstName) < 3 || strlen($firstName) > 40 || preg_match('/[!@$%*#]/', $firstName)) {
        $errors['firstName'] = "يجب أن يكون الاسم الأول بين 3 و 40 حرفًا ولا يحتوي على أحرف خاصة";
    }

    if (!preg_match('/^(\+213|0)(5|6|7)[0-9]{8}$/', $phoneNum)) {
        $errors['phoneNum'] = "يرجى إدخال رقم هاتف جزائري صحيح";
    }

    if (empty($email)) {
        $errors['email'] = "لا يمكن أن يكون البريد الإلكتروني فارغًا";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "يرجى إدخال بريد إلكتروني صالح";
    }

    if (strlen($newPassword) < 8 || 
        !preg_match('/\d/', $newPassword) || 
        !preg_match('/[A-Z]/', $newPassword) || 
        !preg_match('/[!@$%*#]/', $newPassword)) {
        $errors['password'] = "يجب أن تكون كلمة المرور مكونة من أكثر من 8 أحرف، وتحتوي على حرف كبير واحد على الأقل، ورقم واحد على الأقل، ورمز خاص واحد على الأقل";
    }

    if ($newPassword !== $confirmPassword) {
        $errors['confirmPassword'] = "كلمة المرور غير مطابقة";
    }

    if (empty($errors)) {
        $hashedPassword = !empty($newPassword) ? password_hash($newPassword, PASSWORD_DEFAULT) : $row['User_Password'];

        $query = 'UPDATE `user` SET 
                  `User_FirstName` = ?, `User_LastName` = ?, `User_Phone` = ?, 
                  `User_Branch` = ?, `User_Level` = ?, `User_Email` = ?, `User_Password` = ?
                  WHERE `UserID` = ?';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssssssi', $firstName, $lastName, $phoneNum, $branch, $studyLevel, $email, $hashedPassword, $_SESSION['user']['UserID']);

        if ($stmt->execute()) {
            $_SESSION['user']['User_FirstName'] = $firstName;  
            $_SESSION['user']['User_LastName'] = $lastName;
            $_SESSION['user']['User_Phone'] = $phoneNum;
            $_SESSION['user']['User_Branch'] = $branch;
            $_SESSION['user']['User_Level'] = $studyLevel;
            $_SESSION['user']['User_Email'] = $email;

            header('Location: Student-dashboard.php');
            exit();
        } else {
            $_SESSION["update_errors"] = ["general" => "حدث خطأ أثناء تحديث المعلومات. حاول مرة أخرى."];
        }

        $stmt->close();
    } else {
        $_SESSION["update_errors"] = $errors;
    }
}

if(isset($_SESSION['user'])){
    $query = 'SELECT User_Points FROM user WHERE UserID = ? ';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i',$_SESSION['user']['UserID']);
    $stmt->execute();
    $stmt->bind_result($UserPoints);
    $stmt->fetch();
    $stmt->close();
}


$conn->close();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/SignUP.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="../js/components/SignUP.js"></script>
    <link rel="stylesheet" href="../css/nav-stud.css">
    <script defer src="../js/components/nav.js"></script>
    <link rel="stylesheet" href="../css/footer.css">
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
    <script>
        function redirectToHome() {
            window.location.href = "../guest.php";
        }
    </script>
    <script defer src="../js/components/nav.js"></script>

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
                    <a href="Student-Dashboard.php" class="Navbtn" id="points"></i> نقاطي : <?php if(isset($UserPoints)){echo $UserPoints;} ?> </a>
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
            <a href="Student-Dashboard.php" class="on-media-btns" dir="rtl">&nbsp;&nbsp; نقاطي : <?php if(isset($UserPoints)){echo $UserPoints;} ?> <i class="fa-solid fa-user"></i></a>
            <a href="../student.php #courses " class="on-media-btns">دوراتنا</a>
            <a href="pages/about-us-stud.php" class="on-media-btns">من نحن ؟</a>
            <a href="pages/Montada-stud.php" class="on-media-btns">المنتدى</a>
        </div>
        </div>
    </nav>

    <div class="SU-container">
        <!--Sign Up Form-->
        <div class="SU-left-side">
            <form action="" method="post" id="SU-form">
                <div class="SU-FormText">
                    <span id="SU-HeaderFormText">تحديث معلومات الحساب</span>
                </div>
                <div class="SU-Inputs">

                    <!-- Last Name -->
                    <div class="lastname-input">
                        <input class="SU-input-field" type="text" id="SU-LastName" placeholder="اسم العائلة"
                            name="lastName"
                            value="<?php if (isset($lastName) ){echo $lastName;}?>">
                        <p class="Su-error SU-LastName-error">
                            <?= $_SESSION["update_errors"]['lastName'] ?? ''; ?>
                        </p>
                    </div>

                    <!-- First Name -->
                    <div class="firstname-input">
                        <input class="SU-input-field" type="text" id="SU-FirstName" placeholder="الاسم الأول"
                            name="firstName"
                            value="<?php if (isset($firstName) ){echo $firstName;}?>">
                        <p class="Su-error SU-Firstname-error">
                            <?= $_SESSION["update_errors"]['firstName'] ?? ''; ?>
                        </p>
                    </div>

                    <!-- Email -->
                    <div class="email-input">
                        <input class="SU-input-field" type="text" id="SU-Email" placeholder="البريد الإلكتروني"
                            name="email"
                            value="<?php if (isset($email) ){echo $email;}?>">
                        <p class="Su-error SU-email-error">
                            <?= $_SESSION["update_errors"]['email'] ?? ''; ?>
                        </p>
                    </div>

                    <!-- Phone Number -->
                    <div class="phone-input">
                        <input class="SU-input-field" type="text" id="SU-PhoneNumber" placeholder="رقم الهاتف"
                            name="phoneNum"
                            value="<?php if (isset($phone) ){echo $phone;}?>">
                        <p class="Su-error SU-phone-error">
                            <?= $_SESSION["update_errors"]['phoneNum'] ?? ''; ?>
                        </p>
                    </div>


                    <!-- Study Level -->
                    <div class="SU-SL">
                        <label for="StudyLevel" id="SU-SLT">المستوى الدراسي</label>
                        <br>
                        <select id="SU-StudyLevel" name="level">
                            <option value="1AS" <?=(isset($level) && $level==='1AS' ) ? 'selected'
                                : '' ; ?>>1AS</option>
                            <option value="2AS" <?=(isset($level) && $level==='2AS' ) ? 'selected'
                                : '' ; ?>>2AS</option>
                            <option value="3AS" <?=(isset($level) && $level) ? 'selected'
                                : '' ; ?>>3AS</option>
                        </select>
                    </div>

                    <!-- Branch -->
                    <div class="SU-BR">
                        <label for="Branch" id="SU-BRT">الشعبة</label>
                        <br>
                        <select id="SU-Branch" name="branch">
                            <option value="ST" <?=(isset($branch) && $branch==='ST' ) ? 'selected'
                                : '' ; ?>>علوم تجريبية</option>
                            <option value="MT" <?=(isset($branch) && $branch==='MT' ) ? 'selected'
                                : '' ; ?>>رياضيات</option>
                            <option value="ML" <?=(isset($branch) && $branch==='ML' ) ? 'selected'
                                : '' ; ?>>تقني رياضي</option>
                        </select>
                    </div>

                    <!-- New Password -->
                    <div class="password-input">
                        <input class="SU-input-field" type="password" id="SU-Password" placeholder=" كلمة المرور الجديدة"
                            name="newPassword">
                        <p class="Su-error SU-pass-error">
                            <?= $_SESSION["update_errors"]['password'] ?? ''; ?>
                        </p>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="confirm-password-input">
                        <input class="SU-input-field" type="password" id="SU-ConfirmPassword"
                            placeholder="تأكيد كلمة المرور" name="confirmPassword">
                        <p class="Su-error SU-confirmPass-error">
                            <?= $_SESSION["update_errors"]['confirmPassword'] ?? ''; ?>
                        </p>
                    </div>

                    <!-- Submit and Reset -->
                    <div class="submit-reset-input">
                        <input type="reset" id="SU-ResetForm" value="الإعادة من جديد">
                        <input type="submit" id="SU-SubmitForm" value="تحديث الحساب">
                    </div>
                </div>
            </form>
            <?php unset($_SESSION["update_errors"]); ?>
        </div>

        <!--Sign Up right side Image-->
        <div class="SU-right-side"></div>
    </div>

    <footer>
        <div>
            <div class="footer">
                <div class="footer-left-side">
                    <div class="motivation-text">
                        <h3> ! مفتاح المستقبل &lrm;</h3>
                        <p> العلم هو الأساس الذي تبنى عليه الإنجازات، فلا تستخف بجهودك اليوم. كل ساعة تقضيها في الدراسة
                            تقربك من تحقيق أحلامك. التحديات التي تواجهها هي مجرد خطوات على طريق النجاح. اجعل شغفك
                            بالمعرفة دافعًا، وكن واثقًا أن مستقبلك المشرق ينتظرك &lrm;</p>
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
    </footer>
</body>

</html>