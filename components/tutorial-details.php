<?php
session_start();

$user_id = $_SESSION['user']['UserID'];

$tutorial_ID = isset($_GET['tutorial_ID']) ? $_GET['tutorial_ID'] : 0;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bassetdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM Tutorials WHERE tutorial_ID = ?");
$stmt->bind_param("i", $tutorial_ID);
$stmt->execute();
$tutorial = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$tutorial) {
    die("لم يتم العثور على البرنامج التعليمي.");
}

$course_ID = $tutorial['course_ID'];

$stmt = $conn->prepare("SELECT * FROM StudentCourse WHERE UserID = ? AND CourseID = ? AND `Status` = 'ACTIVE'");
$stmt->bind_param("ii", $user_id, $course_ID);
$stmt->execute();
$courseEnrollment = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$courseEnrollment) {
    ?>
    <div
        style="text-align: center; background-color: #f44336; padding: 20px; border-radius: 8px; max-width: 700px; margin: 40px auto;">
        <p style="font-size: 24px; color: white; font-family: 'Arial', sans-serif;">
        يجب عليك الإشتراك في الدورة من أجل مشاهدة المحتوى
        </p>
    </div>
    <div style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
        <img src="../assets/images/lock.png" alt="Lock Icon"
            style="width: 150px; height: 150px; vertical-align: middle; margin-right: 10px;">
        <a href="pages/Courseframe-stud.php?courseID=<?php echo $course_ID; ?>"
            style="background-color: #007bff; color: white; padding: 15px 30px; border-radius: 5px; font-size: 18px; text-decoration: none; text-align: center; display: inline-block;">
            شراء الدورة
        </a>
    </div>
    <?php
    exit();
}

$stmt = $conn->prepare("SELECT * FROM TutorialMaterials WHERE tutorial_ID = ?");
$stmt->bind_param("i", $tutorial_ID);
$stmt->execute();
$materials = $stmt->get_result();
$stmt->close();

$stmt = $conn->prepare("SELECT * FROM TutorialSummary WHERE tutorial_ID = ?");
$stmt->bind_param("i", $tutorial_ID);
$stmt->execute();
$summaries = $stmt->get_result();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($tutorial['tutorial_title']); ?> - تفاصيل البرنامج التعليمي</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #343a40;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 2.5rem;
            color: #007bff;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.2rem;
            color: #6c757d;
        }

        .content {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .section {
            padding: 15px;
            border: 1px solid #e9ecef;
            border-radius: 5px;
        }

        .section h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #495057;
        }

        .section ul {
            list-style: none;
            padding: 0;
        }

        .section ul li {
            margin-bottom: 10px;
        }

        .section ul li a {
            text-decoration: none;
            color: #007bff;
        }

        .section ul li a:hover {
            text-decoration: underline;
        }

        .cta {
            text-align: center;
            margin-top: 30px;
        }

        .cta a {
            text-decoration: none;
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            border-radius: 5px;
        }

        .cta a:hover {
            background: #0056b3;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            /* 16:9 Aspect Ratio */
            height: 0;
            overflow: hidden;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="header">
            <h1><?php echo htmlspecialchars($tutorial['tutorial_title']); ?></h1>
            <p><?php echo htmlspecialchars($tutorial['tutorial_description']); ?></p>
        </div>

        <div class="content">
            <div class="section">
                <h2>محاضرة الفيديو</h2>
                <div class="video-container">
                    <iframe src="<?php echo htmlspecialchars($tutorial['tutorial_video']); ?>" allowfullscreen></iframe>
                </div>
            </div>

            <div class="section">
                <h2>موراد الدورة</h2>
                <ul>
                    <?php
                    $index = 1;
                    while ($material = $materials->fetch_assoc()): ?>
                        <li>
                            <a href="<?php echo htmlspecialchars($material['Material_content']); ?>" target="_blank">
                                 <?php echo $index; ?> المورد
                            </a>
                        </li>
                        <?php
                        $index++;
                    endwhile; ?>
                </ul>
            </div>

            <div class="section">
                <h2>ملخصات الدورة التعليمي</h2>
                <ul>
                    <?php
                    $index = 1;
                    while ($summary = $summaries->fetch_assoc()): ?>
                        <li>
                            <a href="<?php echo nl2br(htmlspecialchars($summary['summary_content'])); ?>" target="_blank">
                                 <?php echo $index; ?>  الملخص
                            </a>
                        </li>
                        <?php
                        $index++;
                    endwhile; ?>
                </ul>
            </div>

            <!-- Display purchase status -->
            <div class="cta">
                <?php
                if (isset($courseEnrollment) && $courseEnrollment['Status'] === 'ACTIVE') {
                    echo "<p>لقد قمت بشراء هذه الدورة!</p>";
                } else {
                    echo "<p>لم تقم بشراء هذه الدورة بعد.</p>";
                }
                ?>
                <a href="pages/Courseframe-stud.php?courseID=<?php echo urlencode($tutorial['course_ID']); ?>">العودة إلى الدورة</a>
            </div>

        </div>
    </div>
</body>

</html>

<?php
$conn->close();
?>
