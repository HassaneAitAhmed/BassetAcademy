<?php
session_start();
if (isset($_SESSION["sign_in_error"])) {
    unset($_SESSION["sign_in_error"]); 
}

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'bassetdb';

@$Connection = new mysqli($servername, $username, $password, $dbname);

if ($Connection->connect_error) {
    die("Connection failed: " . $Connection->connect_error);
}

if (isset($_POST['email']) && isset($_POST['password']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $emailQuery = "SELECT * FROM `user` WHERE User_Email = ?";
    $stmt = $Connection->prepare($emailQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($userRow = $result->fetch_assoc()) {
            if (password_verify($password, $userRow['User_Password'])) {
                $_SESSION['user'] = $userRow;
                $userID = $userRow['UserID'];

                trackUserLogin($Connection, $userID);

                if ($userRow['Role'] == 'Student') {
                    header("Location: ../student.php");
                } else if ($userRow['Role'] == 'Admin') {
                    header("Location: ../admin.php");
                }
                exit();
            }else{
                $_SESSION["sign_in_error"] = "تعذر تسجيل الدخول بسبب إدخال معلومات غير صحيحة";
            }
        }
    } else {
        $_SESSION["sign_in_error"] = "تعذر تسجيل الدخول بسبب إدخال معلومات غير صحيحة";
    }
    $stmt->close();
    $Connection->close();
}

function trackUserLogin($Connection, $userID) {
    $deviceType = $_SERVER['HTTP_USER_AGENT'];
    $deviceName = getDeviceName($deviceType);
    $deviceOperator = getDeviceOperator($deviceType);
    $browser = getBrowser($deviceType);

    $currentDateTime = date("Y-m-d H:i:s");

    $selectQuery = "SELECT studSecuID FROM StudentSecurity WHERE UserID = ? ORDER BY logtime DESC LIMIT 10";
    $selectStmt = $Connection->prepare($selectQuery);
    $selectStmt->bind_param('i', $userID);
    $selectStmt->execute();
    $result = $selectStmt->get_result();
    $existingIDs = [];

    while ($row = $result->fetch_assoc()) {
        $existingIDs[] = $row['studSecuID'];
    }
    $selectStmt->close();

    var_dump($existingIDs);

    $countQuery = "SELECT COUNT(*) FROM StudentSecurity WHERE UserID = ?";
    $countStmt = $Connection->prepare($countQuery);
    $countStmt->bind_param('i', $userID);
    $countStmt->execute();
    $countResult = $countStmt->get_result()->fetch_row();
    $totalRecords = $countResult[0];
    $countStmt->close();

    if ($totalRecords > 10) {
        $deleteQuery = "DELETE FROM StudentSecurity WHERE UserID = ? AND studSecuID NOT IN (" . implode(',', array_fill(0, count($existingIDs), '?')) . ")";
        

        if (!empty($existingIDs)) {
            $deleteStmt = $Connection->prepare($deleteQuery);
            $params = array_merge([$userID], $existingIDs);
            $types = str_repeat('i', count($params));
            $deleteStmt->bind_param($types, ...$params);
            $deleteStmt->execute();
            $deleteStmt->close();
        }
    }

    $stmt = $Connection->prepare("INSERT INTO StudentSecurity (UserID, devicetype, devicename, deviceoperator, browser, logtime)
                                  VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('isssss', $userID, $deviceType, $deviceName, $deviceOperator, $browser, $currentDateTime);

    if ($stmt->execute()) {
    } else {
        echo "Error saving tracking information: " . $stmt->error;
    }

    $stmt->close();
}


function getDeviceName($userAgent) {
    if (preg_match('/mobile/i', $userAgent)) {
        return "Mobile Device";
    } elseif (preg_match('/tablet/i', $userAgent)) {
        return "Tablet";
    } else {
        return "Desktop";
    }
}

function getDeviceOperator($userAgent) {
    if (preg_match('/windows/i', $userAgent)) {
        return "Windows";
    } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
        return "Mac OS";
    } elseif (preg_match('/linux/i', $userAgent)) {
        return "Linux";
    } elseif (preg_match('/android/i', $userAgent)) {
        return "Android";
    } elseif (preg_match('/iphone|ipad/i', $userAgent)) {
        return "iOS";
    } else {
        return "Unknown OS";
    }
}

function getBrowser($userAgent) {
    if (preg_match('/firefox/i', $userAgent)) {
        return "Firefox";
    } elseif (preg_match('/chrome/i', $userAgent)) {
        return "Chrome";
    } elseif (preg_match('/safari/i', $userAgent)) {
        return "Safari";
    } else {
        return "Unknown Browser";
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/SignIn.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/nav1.css">
    <script defer src="../js/components/nav.js"></script>
    <link rel="stylesheet" href="../css/footer.css">
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
    <script src="../js/signin.js"></script>
    <script>
        function redirectToHome() {
            window.location.href = "../guest.php";
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
                    <a href="../components/about-us.php" class="Navbtn" id="about-us-btn">من نحن ؟</a>
                    <a href="../guest.php #courses " class="Navbtn" id="courses-btn">دوراتنا</a>
                    <a href="../components/Montada.php" class="Navbtn" id="contact-us-btn">المنتدى</a>
                </div>
                <!--Navigation Bar right side-->
                <div class="right-side">
                    <div class="LOG">
                        <a href="../components/SignIn.php" class="Navbtn" id="LogInNavbtn"> <i
                                class="fa-solid fa-arrow-right-to-bracket"></i>تسجيل الدخول</a>
                        <a href="../components/SignUP.php" class="Navbtn" id="SignInNavbtn"><i
                                class="fa-solid fa-user-plus"></i> انشئ حسابك الآن </a>
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
                <a href="../components/SignIn.php" class="on-media-btns" dir="rtl">&nbsp;&nbsp;تسجيل الدخول<i
                        class="fas fa-sign-in-alt"></i></a>
                <a href="../components/SignUP.php" class="on-media-btns" dir="rtl">&nbsp;&nbsp; انشئ حسابك الآن <i
                        class="fa-solid fa-user"></i></a>
                <a href="../guest.php" class="on-media-btns">دوراتنا</a>
                <a href="../components/about-us.php" class="on-media-btns">من نحن ؟</a>
                <a href="../components/Montada.php" class="on-media-btns">المنتدى</a>
            </div>
            </div>
        </nav>

<div class="SI-container">
    <div class="SI-left-side">
        <div class="SI-SIForm">
            <div class="SI-HeaderFormText">
                <span id="t1"> ! تسجيل الدخول</span><br><span id="t2" dir="ltr"> . للوصول إلى حسابك، أدخل رقم الهاتف وكلمة السر المستخدمة عند التسجيل </span>
            </div>
            <form action="" id="SI-form" method="POST">
                <div class="SI-Inputs">
                    <div class="email-input">
                        <input class="SI-input-field" type="text" placeholder="البريد الإلكتروني" id="SI-Email" name="email">
                    </div>
                    <div class="password-input">
                        <input class="SI-input-field" type="password" placeholder="كلمة السر " id="SI-Password" name="password">
                        <p class="SI-error"><?php 
                            if(isset($_SESSION["sign_in_error"])){
                                echo $_SESSION["sign_in_error"];
                                unset($_SESSION["sign_in_error"]);
                            } 
                        ?></p>
                    </div>
                    <input type="submit" id="SI-SignInbtn" value="تسجيل الدخول">
                </div>
            </form>
            <div class="SI-FooterFormText" style="display:flex; flex-direction:column;">
                <span id="t3" dir="rtl"> نسيت كلمة المرور؟<a href="resetPass.php">اعِد تعيينها !</a></span>
                <br>
                <span id="t3" dir="rtl"> ليس لديك حساب ؟ <a href="../components/SignUP.php"> انشئ حسابك الآن !</a></span>
            </div>
        </div>
    </div>

    <div class="SI-right-side"></div>
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
