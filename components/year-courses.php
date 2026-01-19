<?php

    session_start();
    
    $year = isset($_GET['year']) ? $_GET['year'] : 1;

    require_once 'db_connection.php';

    $semester = '';
    if ($year == 1) {
        $semester = 'S1';
    } elseif ($year == 2) {
        $semester = 'S2';
    } elseif ($year == 3) {
        $semester = 'S3';
    }

    $stmt = $conn->prepare("SELECT * FROM Course WHERE semester = ?");
    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param("s", $semester);
    if (!$stmt->execute()) {
        die('Error executing query: ' . $stmt->error);
    }

    $result = $stmt->get_result();

    if(isset($_SESSION['user'])){
        $query = 'SELECT User_Points FROM user WHERE UserID = ? ';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i',$_SESSION['user']['UserID']);
        $stmt->execute();
        $stmt->bind_result($UserPoints);
        $stmt->fetch();
        $stmt->close();
    }
    ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/Tutorials.css" />
    <title>Courses</title>
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/nav-stud.css">
    <script>
        function redirectToHome() {
            window.location.href = "../student.php";
        }
    </script>
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
                <a href="Student-Dashboard.php"  class="Navbtn" id="points"></i> نقاطي : <?php if(isset($UserPoints)){echo $UserPoints;} ?> </a>
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
        <a href="Student-Dashboard.php" class="on-media-btns" dir="rtl">&nbsp;&nbsp;حسابي <i class="fas fa-sign-in-alt"></i></a>
        <a href="" class="on-media-btns" dir="rtl">&nbsp;&nbsp;  نقاطي : <?php if(isset($UserPoints)){echo $UserPoints;} ?> <i class="fa-solid fa-user"></i></a>
        <a href="../student.php #courses " class="on-media-btns">دوراتنا</a>
        <a href="pages/about-us-stud.php" class="on-media-btns">من نحن ؟</a>
        <a href="pages/Montada-stud.php" class="on-media-btns">تواصل معنا</a>
    </div>
    </div>
</nav>

    <div class="semesters" id="semesters-year<?php echo $year; ?>">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="semester card">

                    <a style="text-decoration: none;" href="pages/Courseframe-stud.php?courseID=<?php echo htmlspecialchars($row['CourseID']); ?>"
                        class="course-link">
                        <div class="image_container">
                            <img src="<?php echo htmlspecialchars($row['Course_image']); ?>"
                                alt="Semester <?php echo htmlspecialchars($row['semester']); ?>" width="100%">
                        </div>

                        <h1><?php echo htmlspecialchars($row['Course_title']); ?></h1>
                        <hr>
                        <p>: عند اشتراكك في هذه الدورة ستجد</p>
                        <ul>
                            <li><i class="fas fa-book"></i> دروس مشروحة وملخصة</li>
                            <li><i class="fas fa-file-pdf"></i> تمارين وملخصات PDF</li>
                            <li><i class="fas fa-chalkboard-teacher"></i> حصص مباشرة</li>
                            <li><i class="fas fa-pencil-alt"></i> مراجعات خاصة</li>
                        </ul>
                    </a>


                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>لا توجد دورات لهذا العام.</p>
        <?php endif; ?>
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

    <?php
    
    ?>

</body>

</html>