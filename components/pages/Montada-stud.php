<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bassetdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/Montada.css">
    <script defer src="../../js/components/Montada-stud.js"></script>
    <link rel="stylesheet" href="../../css/nav-stud.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="../../js/components/nav.js"></script>
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/footer.css">
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
    <title>Document</title>
    <script>
        function redirectToHome() {
            window.location.href = "../../student.php";
        }
    </script>
</head>

<body>

    <nav>
        <div class="container">
            <!--Navigation Bar left side-->
            <div class="left-side">
                <div class="NavLogo"><img src="../../assets/images/Academy.png" alt="Logo" height="150px" width="150px"
                        onclick="redirectToHome()" style="cursor: pointer;"></div>

            </div>
            <!--Navigation Bar middle part-->
            <div class="middle-part">
                <a href="about-us-stud.php" class="Navbtn" id="about-us-btn">من نحن ؟</a>
                <a href="../../student.php #courses " class="Navbtn" id="courses-btn">دوراتنا</a>
                <a href="Montada-stud.php" class="Navbtn" id="contact-us-btn">المنتدى</a>
            </div>
            <!--Navigation Bar right side-->
            <div class="right-side">
                <div class="LOG">
                    <a href="../Student-Dashboard.php" class="Navbtn" id="Acc"></i>حسابي </a>
                    <a href="../Student-Dashboard.php" class="Navbtn" id="points"></i> نقاطي :
                        <?php if(isset($UserPoints)){echo $UserPoints;} ?>
                    </a>
                </div>
                <!-- On media right side-->
                <div class="drop-down">
                    <input type="checkbox" id="drop-down-menu">
                    <label for="drop-down-menu" id="DDM-label"><img src="../../assets/images/DDM.png" alt=""></label>
                </div>
            </div>


        </div>
        <br>
        <!--On media drop-menu-->
        <div class="media-drop-down-btns">
            <a href="../../components/Student-Dashboard.php" class="on-media-btns" dir="rtl">&nbsp;&nbsp;حسابي <i
                    class="fas fa-sign-in-alt"></i></a>
            <a href="" class="on-media-btns" dir="rtl">&nbsp;&nbsp; نقاطي :
                <?php if(isset($UserPoints)){echo $UserPoints;} ?> <i class="fa-solid fa-user"></i>
            </a>
            <a href="../../student.php #courses " class="on-media-btns">دوراتنا</a>
            <a href="about-us-stud.php" class="on-media-btns">من نحن ؟</a>
            <a href="Montada-stud.php" class="on-media-btns">تواصل معنا</a>
        </div>
        </div>
    </nav>

    <div class="ss">



        <div class="hub-header">
            <h2>مرحبا بك في منتدى الطلبة</h2>
        </div>

        <!--Main frame-->
        <div class="post-frame">
            <!--Hub-page left side-->
            <div class="hub-left-side">
                <div class="ul-hub-container">
                    <ul class="hub-student-left-side">
                    <li id="arrange-most-recent-btn">المنشورات الجديدة</li>
                    <li id="arrange-most-liked-btn">أكثر المنشورات إعجاباً</li>
                    </ul>
                </div>
            </div>
            <!-- Hub-PAGE right side (posts) -->
            <div class="hub-right-side">
                <div class="posts">

                </div>
            </div>

        </div>

    </div>


    <div class="post postClone" style="display:none;">
        <div class="post-left-side">
            <div class="post-image">
                <img src="" alt="">
            </div>
        </div>
        <div class="post-right-side">
            <div class="post-text" dir="rtl">
                <p></p>
            </div>
        </div>
        <div class="post-footer">
            <div class="likes">
                <input type="checkbox" id="post-likes1">
                <label for="post-likes1">
                    <i class="fa-solid fa-heart like" id="post-likes-label"><span style="margin-left: 20px;"></span></i>
                </label>
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


</body>


</html>