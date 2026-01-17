<?php
session_start();

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'bassetdb';
$port = 3306;

$connection = new mysqli($servername, $username, $password, $dbname, $port);

$courseID = isset($_GET['courseID']) ? intval(value: $_GET['courseID']) : 0;

$sql = "SELECT * FROM course WHERE CourseID = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $courseID);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $_SESSION['Course'] = $result->fetch_assoc();
} else {
    echo "No course found with CourseID: " . $courseID;
}

if (isset($_SESSION['Course'])) {
    $Course_id = $_SESSION['Course']['CourseID'];
    $Course_title = $_SESSION['Course']['Course_title'];
    $Course_description = $_SESSION['Course']['Course_description'];
    $Course_image = $_SESSION['Course']['Course_image'];
    $Course_Price = $_SESSION['Course']['price'];

    $query1 = '
        SELECT tm.*
        FROM TutorialMaterials tm
        INNER JOIN Tutorials t ON tm.tutorial_ID = t.tutorial_ID
        WHERE t.course_ID = ?
    ';

    $query2 = '
        SELECT ts.*
        FROM TutorialSummary ts
        INNER JOIN Tutorials t ON ts.tutorial_ID = t.tutorial_ID
        WHERE t.course_ID = ?
    ';

    $query3 = 'SELECT * FROM `Tutorials` WHERE `course_ID` = ?';

    if (!$stmt1 = $connection->prepare($query1)) {
        die('Query 1 preparation failed: ' . $connection->error);
    }
    if (!$stmt2 = $connection->prepare($query2)) {
        die('Query 2 preparation failed: ' . $connection->error);
    }
    if (!$stmt3 = $connection->prepare($query3)) {
        die('Query 3 preparation failed: ' . $connection->error);
    }


    $stmt1->bind_param('i', $Course_id);
    $stmt2->bind_param('i', $Course_id);
    $stmt3->bind_param('i', $Course_id);


    $stmt1->execute();
    $materials = $stmt1->get_result();
    $stmt2->execute();
    $materialssummaries = $stmt2->get_result();
    $stmt3->execute();
    $tutorials = $stmt3->get_result();

    $stmt1->close();
    $stmt2->close();
    $stmt3->close();

}

if (isset($_POST['Pay'])) {
    $CourseToBuy_id = $_SESSION['Course']['CourseID'];
    $userBuyingIt_id = $_SESSION['user']['UserID'];
    $state = 'ACTIVE';

    $query = "INSERT INTO studentcourse (CourseID, UserID, Status) VALUES (?, ?, ?)";
    $stmt4 = $connection->prepare($query);
    if (!$stmt4) {
        die("Error preparing statement: " . $connection->error);
    }
    $stmt4->bind_param('iis', $CourseToBuy_id, $userBuyingIt_id, $state);
    $stmt4->execute();
    $stmt4->close();

    $newBalance = $_POST['Pay'];
    $query = "UPDATE user SET User_Points = ? WHERE UserID = ?";
    $stmt5 = $connection->prepare($query);
    if (!$stmt5) {
        die("Error preparing statement: " . $connection->error);
    }
    $stmt5->bind_param('ii', $newBalance, $userBuyingIt_id);
    $stmt5->execute();
    $stmt5->close();
    $_SESSION['user']['User_Points'] = $connection->query("SELECT User_Points FROM user WHERE UserID = {$_SESSION['user']['UserID']}")->fetch_object()->User_Points;
}

function replaceNewlineWithBr($text)
{
    return str_replace("\n", "<br>", $text);
}

if(isset($_SESSION['user'])){
    $query = 'SELECT User_Points FROM user WHERE UserID = ? ';
    $stmt = $connection->prepare($query);
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
    <title>Course</title>
    <link rel="stylesheet" href="../../css/nav-stud.css">
    <script defer src="../../js/components/nav.js"></script>
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
    <script>
        function redirectToHome() {
            window.location.href = "../../student.php";
        }
    </script>
    <link rel="stylesheet" href="../../css/course-info.css">
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
    <script defer src="../../js/components/course-info.js"></script>
    <link rel="stylesheet" href="../../css/detail.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/ContentCourse.css">
    <link rel="stylesheet" href="../../css/footer.css">
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>

    <style>
        .mainPage {
            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25'%3E%3Cdefs%3E%3ClinearGradient id='a' gradientUnits='userSpaceOnUse' x1='0' x2='0' y1='0' y2='100%25' gradientTransform='rotate(78,960,455)'%3E%3Cstop offset='0' stop-color='%23ffffff'/%3E%3Cstop offset='1' stop-color='%23767AFF'/%3E%3C/linearGradient%3E%3Cpattern patternUnits='userSpaceOnUse' id='b' width='356' height='296.7' x='0' y='0' viewBox='0 0 1080 900'%3E%3Cg fill-opacity='0.09'%3E%3Cpolygon fill='%23444' points='90 150 0 300 180 300'/%3E%3Cpolygon points='90 150 180 0 0 0'/%3E%3Cpolygon fill='%23AAA' points='270 150 360 0 180 0'/%3E%3Cpolygon fill='%23DDD' points='450 150 360 300 540 300'/%3E%3Cpolygon fill='%23999' points='450 150 540 0 360 0'/%3E%3Cpolygon points='630 150 540 300 720 300'/%3E%3Cpolygon fill='%23DDD' points='630 150 720 0 540 0'/%3E%3Cpolygon fill='%23444' points='810 150 720 300 900 300'/%3E%3Cpolygon fill='%23FFF' points='810 150 900 0 720 0'/%3E%3Cpolygon fill='%23DDD' points='990 150 900 300 1080 300'/%3E%3Cpolygon fill='%23444' points='990 150 1080 0 900 0'/%3E%3Cpolygon fill='%23DDD' points='90 450 0 600 180 600'/%3E%3Cpolygon points='90 450 180 300 0 300'/%3E%3Cpolygon fill='%23666' points='270 450 180 600 360 600'/%3E%3Cpolygon fill='%23AAA' points='270 450 360 300 180 300'/%3E%3Cpolygon fill='%23DDD' points='450 450 360 600 540 600'/%3E%3Cpolygon fill='%23999' points='450 450 540 300 360 300'/%3E%3Cpolygon fill='%23999' points='630 450 540 600 720 600'/%3E%3Cpolygon fill='%23FFF' points='630 450 720 300 540 300'/%3E%3Cpolygon points='810 450 720 600 900 600'/%3E%3Cpolygon fill='%23DDD' points='810 450 900 300 720 300'/%3E%3Cpolygon fill='%23AAA' points='990 450 900 600 1080 600'/%3E%3Cpolygon fill='%23444' points='990 450 1080 300 900 300'/%3E%3Cpolygon fill='%23222' points='90 750 0 900 180 900'/%3E%3Cpolygon points='270 750 180 900 360 900'/%3E%3Cpolygon fill='%23DDD' points='270 750 360 600 180 600'/%3E%3Cpolygon points='450 750 540 600 360 600'/%3E%3Cpolygon points='630 750 540 900 720 900'/%3E%3Cpolygon fill='%23444' points='630 750 720 600 540 600'/%3E%3Cpolygon fill='%23AAA' points='810 750 720 900 900 900'/%3E%3Cpolygon fill='%23666' points='810 750 900 600 720 600'/%3E%3Cpolygon fill='%23999' points='990 750 900 900 1080 900'/%3E%3Cpolygon fill='%23999' points='180 0 90 150 270 150'/%3E%3Cpolygon fill='%23444' points='360 0 270 150 450 150'/%3E%3Cpolygon fill='%23FFF' points='540 0 450 150 630 150'/%3E%3Cpolygon points='900 0 810 150 990 150'/%3E%3Cpolygon fill='%23222' points='0 300 -90 450 90 450'/%3E%3Cpolygon fill='%23FFF' points='0 300 90 150 -90 150'/%3E%3Cpolygon fill='%23FFF' points='180 300 90 450 270 450'/%3E%3Cpolygon fill='%23666' points='180 300 270 150 90 150'/%3E%3Cpolygon fill='%23222' points='360 300 270 450 450 450'/%3E%3Cpolygon fill='%23FFF' points='360 300 450 150 270 150'/%3E%3Cpolygon fill='%23444' points='540 300 450 450 630 450'/%3E%3Cpolygon fill='%23222' points='540 300 630 150 450 150'/%3E%3Cpolygon fill='%23AAA' points='720 300 630 450 810 450'/%3E%3Cpolygon fill='%23666' points='720 300 810 150 630 150'/%3E%3Cpolygon fill='%23FFF' points='900 300 810 450 990 450'/%3E%3Cpolygon fill='%23999' points='900 300 990 150 810 150'/%3E%3Cpolygon points='0 600 -90 750 90 750'/%3E%3Cpolygon fill='%23666' points='0 600 90 450 -90 450'/%3E%3Cpolygon fill='%23AAA' points='180 600 90 750 270 750'/%3E%3Cpolygon fill='%23444' points='180 600 270 450 90 450'/%3E%3Cpolygon fill='%23444' points='360 600 270 750 450 750'/%3E%3Cpolygon fill='%23999' points='360 600 450 450 270 450'/%3E%3Cpolygon fill='%23666' points='540 600 630 450 450 450'/%3E%3Cpolygon fill='%23222' points='720 600 630 750 810 750'/%3E%3Cpolygon fill='%23FFF' points='900 600 810 750 990 750'/%3E%3Cpolygon fill='%23222' points='900 600 990 450 810 450'/%3E%3Cpolygon fill='%23DDD' points='0 900 90 750 -90 750'/%3E%3Cpolygon fill='%23444' points='180 900 270 750 90 750'/%3E%3Cpolygon fill='%23FFF' points='360 900 450 750 270 750'/%3E%3Cpolygon fill='%23AAA' points='540 900 630 750 450 750'/%3E%3Cpolygon fill='%23FFF' points='720 900 810 750 630 750'/%3E%3Cpolygon fill='%23222' points='900 900 990 750 810 750'/%3E%3Cpolygon fill='%23222' points='1080 300 990 450 1170 450'/%3E%3Cpolygon fill='%23FFF' points='1080 300 1170 150 990 150'/%3E%3Cpolygon points='1080 600 990 750 1170 750'/%3E%3Cpolygon fill='%23666' points='1080 600 1170 450 990 450'/%3E%3Cpolygon fill='%23DDD' points='1080 900 1170 750 990 750'/%3E%3C/g%3E%3C/pattern%3E%3C/defs%3E%3Crect x='0' y='0' fill='url(%23a)' width='100%25' height='100%25'/%3E%3Crect x='0' y='0' fill='url(%23b)' width='100%25' height='100%25'/%3E%3C/svg%3E");
            background-attachment: fixed;
            background-size: cover;
        }
    </style>

    <style>
        /* Basic styling for accordion */
        .accordion {
            margin: 20px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }

        .accordion-header {
            background-color: #f4f4f4;
            padding: 15px;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .accordion-header i {
            transition: transform 0.3s;
        }

        .accordion.active .accordion-header i {
            transform: rotate(180deg);
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            background-color: #fff;
            padding: 0 15px;
        }

        .accordion-content ul {
            margin: 15px 0;
            padding: 0;
            list-style: none;
        }

        .accordion-content ul li {
            margin: 10px 0;
        }

        .accordion-content ul li a {
            color: #007bff;
            text-decoration: none;
        }

        .accordion-content ul li a:hover {
            text-decoration: underline;
        }
    </style>

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

    <div class="mainPage">
        <div class="course-info-container">
            <div class="stats">
                <div class="number-videos stat-number">
                    <div class="stat-left-side"><span>تمارين و ملفات</span></div>
                    <div class="stat-right-side video-num"><span>
                            <?php if (isset($materials)) {
                                echo "$materials->num_rows";
                            } ?>
                        </span><i class="fa-solid fa-plus"></i></div>
                </div>
                <div class="number-files stat-number">
                    <div class="stat-left-side"><span>ملخصات</i></span></div>
                    <div class="stat-right-side files-num"><span>
                            <?php if (isset($materialssummaries)) {
                                echo "$materialssummaries->num_rows";
                            } ?>
                        </span><i class="fa-solid fa-plus"></i></div>
                </div>
                <div class="number-homeworks stat-number">
                    <div class="stat-left-side"><span>فيديوهات</span></div>
                    <div class="stat-right-side homeworks-num"><span>
                            <?php if (isset($tutorials)) {
                                echo "$tutorials->num_rows";
                            } ?>
                        </span><i class="fa-solid fa-plus"></i></div>
                </div>

            </div>

            <div class="course-name">
                <h4 style="background-color: blue; padding: 10px 10px; border-radius : 20%; margin-bottom:10px;">
                    <?php if (isset($Course_title)) {
                        echo "دورة $Course_title";
                    } ?>
                </h4>
            </div>
            <div class="course-info">
                <?php if (isset($Course_description)) {
                    echo replaceNewlineWithBr($Course_description);
                } ?>
            </div>

            <div class="course-creation-date" dir="rtl">
                <div class="creation-date-text">
                    <span> تاريخ انشاء الدورة :</span>
                </div>

                <div class="creation-date"> 2024/5/23</div>
            </div>

        </div>
        <div>
            <div class="main-course">
                <div class="course-card-section">
                    <div class="course-image">
                        <img src="<?php if (isset($Course_image)) {
                            echo "../" . "$Course_image";
                        } ?>" alt="math Course">
                    </div>
                    <?php
                    $query6 = 'SELECT * FROM studentcourse WHERE CourseID = ? && UserID = ?';
                    $stmt6 = $connection->prepare($query6);
                    $stmt6->bind_param('ii', $Course_id, $_SESSION['user']['UserID']);
                    $stmt6->execute();
                    $result = $stmt6->get_result();

                    if ($result->num_rows > 0) {
                        echo '<div class="course-price">
                                <button class="price-amount" id="openbuy_popup2" style="font-size:2.5ch;"> يمكنكم متابعة محتوى الدورة <i class="fa fa-arrow-down"></i></button>
                                </div>';
                    } else if ($Course_Price <= $UserPoints) {
                        echo '<div class="course-price">
                                <button class="price-amount" id="openbuy_popup" style="font-size:2.5ch;">اشتري الدورة من هنا</button>
                                </div>';
                    } else if ($Course_Price > $UserPoints) {
                        echo "<div class='course-price'>
                            <button class='price-amount' id='openbuy_popup3' style='font-size:2.5ch;'> الرجاء شحن حسابك لشراء الدورة (سعر الدورة : $Course_Price نقطة)</button>
                            </div>";

                    }
                    ?>
                </div>
                <div class="video">
                    <iframe src="https://www.youtube.com/embed/7UnrsB6iPyY"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </div>


        <form id="buy_popup" method="POST" action="">
            <p style="font-size: 5ch; color: white; font-weight:bold;">شراء الدورة</p>
            <p style="font-size: 2.5ch; color: black; font-weight:bold;">عنوان الدورة :
                <?php if (isset($Course_title)) {
                    echo $Course_title;
                } ?>
            </p>
            <p>تكلفة الدورة :
                <?php if (isset($Course_Price)) {
                    echo "$Course_Price نقطة";
                } ?>
            </p>
            <p>نقاطي :
                <?php if (isset($UserPoints)) {
                    echo $UserPoints . " نقطة";
                } ?>
            </p>
            <p style="color: red; font-weight:bold;">الرصيد الجديد :
                <?php if (isset($Course_Price) && isset($UserPoints)) {
                    $newPoints = $UserPoints - $Course_Price;
                    echo "$newPoints نقطة";
                } ?>


            </p>
            <label style="font-size:1.7ch; font-weight:bold; text-align:right;">
                <input type="checkbox" id="confirmPurchase" name="confirmPurchase">
                انا متأكد من رغبتي في شراء الدورة و أتحمل مسؤلياتي الكاملة
            </label>
            <p id="error_message" style="color: red; font-size: 1.7ch; font-weight: bold; display: none;">يرجى تأكيد
                شراء الدورة</p>
            <input type="submit" value="اشتري الآن" style="font-size:2ch;" id="SubmitPurchaseBtn">
            <input type="hidden" name="Pay" value="<?php if (isset($Course_Price) && isset($UserPoints)) {
                $newPoints = $UserPoints - $Course_Price;
                echo $newPoints;
            } ?>">
        </form>

        <div id="overlay" class="overlay"></div>
        <div>
        </div>


        </head>



        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bassetdb";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $courseID = isset($_GET['courseID']) ? intval($_GET['courseID']) : 0;
        $userID = $_SESSION['user']['UserID'];
        
        $courseQuery = "SELECT * FROM Course WHERE CourseID = ?";
        $stmt = $conn->prepare($courseQuery);
        $stmt->bind_param("i", $courseID);
        $stmt->execute();
        $course = $stmt->get_result()->fetch_assoc();

        $checkEnrollmentQuery = "SELECT * FROM StudentCourse WHERE CourseID = ? AND UserID = ? AND `Status` = 'ACTIVE'";
        $enrollmentStmt = $conn->prepare($checkEnrollmentQuery);
        $enrollmentStmt->bind_param("ii", $courseID, $userID);
        $enrollmentStmt->execute();
        $enrollmentResult = $enrollmentStmt->get_result();

        if ($enrollmentResult->num_rows === 0) {
            $notPurchasedMessage = "انت غير مشترك في هذه الدورة";
            $showContent = false; 
        } else {
            $notPurchasedMessage = "";
            $showContent = true; 
        }

        if ($showContent) {
            $tutorialQuery = "SELECT * FROM Tutorials WHERE course_ID = ?";
            $tutorialStmt = $conn->prepare($tutorialQuery);
            $tutorialStmt->bind_param("i", $courseID);
            $tutorialStmt->execute();
            $tutorials = $tutorialStmt->get_result();

            $summaryQuery = "SELECT * FROM CourseSummarize WHERE CourseID = ?";
            $summaryStmt = $conn->prepare($summaryQuery);
            $summaryStmt->bind_param("i", $courseID);
            $summaryStmt->execute();
            $summaries = $summaryStmt->get_result();
        }
        ?>

        <?php if ($notPurchasedMessage): ?>
            <p
                style="text-align:center; font-size: 26px; color: #ffffff; background-color: #333333; padding: 20px; border-radius: 8px; max-width: 600px; margin: 40px auto; margin-bottom: 0px; font-family: 'Arial', sans-serif;">
                <?php echo htmlspecialchars($notPurchasedMessage); ?>
            </p>
            <div style="display: flex; justify-content:center; align-items:center;">
                <img src="../../assets/images/lock.png" alt="Lock Icon" style="width: 300px; height: 300px; vertical-align: middle; margin-right: 10px;">
            </div>

        <?php endif; ?>

        <?php if ($showContent): ?>
            <div class="accordion">
                <div class="accordion-header">
                    الفيديوهات
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="accordion-content">
                    <ul>
                        <?php while ($tutorial = $tutorials->fetch_assoc()): ?>
                            <li>
                                <a href="../tutorial-details.php?tutorial_ID=<?php echo $tutorial['tutorial_ID']; ?>">
                                    <?php echo htmlspecialchars($tutorial['tutorial_title']); ?>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>

            <div class="accordion">
                <div class="accordion-header">
                    ملخصات الدورة
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="accordion-content">
                    <ul>
                        <?php
                        $summaryNumber = 1; // Counter for dynamic naming
                        while ($summary = $summaries->fetch_assoc()):
                            $filePath = $summary['summary_content'];
                            $absoluteUrl = "../" . $filePath; // Construct absolute URL
                            ?>
                            <li>
                                <a href="<?php echo htmlspecialchars($absoluteUrl); ?>" target="_blank">
                                     <?php echo $summaryNumber; ?> ملخص
                                </a>
                            </li>
                            <?php
                            $summaryNumber++; // Increment the counter
                        endwhile;
                        ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <?php
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($enrollmentStmt)) {
            $enrollmentStmt->close();
        }
        if (isset($tutorialStmt)) {
            $tutorialStmt->close();
        }
        if (isset($summaryStmt)) {
            $summaryStmt->close();
        }
        $conn->close();
        ?>

    </div>
    <footer>
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
    </footer>


    <script src="../js/main.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const accordions = document.querySelectorAll('.accordion');

            accordions.forEach(accordion => {
                const header = accordion.querySelector('.accordion-header');
                const content = accordion.querySelector('.accordion-content');

                header.addEventListener('click', () => {
                    accordions.forEach(item => {
                        if (item !== accordion) {
                            item.classList.remove('active');
                            const itemContent = item.querySelector('.accordion-content');
                            itemContent.style.maxHeight = null;
                        }
                    });

                    accordion.classList.toggle('active');
                    content.style.maxHeight = accordion.classList.contains('active')
                        ? content.scrollHeight + "px"
                        : null;
                });
            });
        });
    </script>

    <script defer>

        const documentItems = document.querySelectorAll('.document');

        documentItems.forEach(document => {
            document.addEventListener('click', () => {
                const content = document.nextElementSibling;
                document.classList.toggle('active');
                content.style.maxHeight = document.classList.contains('active') ? content.scrollHeight + "px" : null;
            });
        });

        const buy_popup = document.getElementById('buy_popup');
        const overlay = document.getElementById('overlay');
        const openbuy_popupButton = document.getElementById('openbuy_popup');

        openbuy_popupButton.addEventListener('click', () => {
            buy_popup.style.display = 'block';
            overlay.style.display = 'block';
            buy_popup.style.animation = 'slideIn 0.3s ease forwards';
            overlay.style.animation = 'fadeIn 0.3s ease forwards';
        });

        overlay.addEventListener('click', () => {
            buy_popup.style.display = 'none';
            overlay.style.display = 'none';
        });

        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById('buy_popup');
            const checkbox = document.getElementById('confirmPurchase');
            const errorMessage = document.getElementById('error_message');

            form.addEventListener("submit", (e) => {
                if (!checkbox.checked) {
                    e.preventDefault();
                    errorMessage.style.display = 'block';
                } else {
                    errorMessage.style.display = 'none';
                }
            });
        });

    </script>
</body>

</html>