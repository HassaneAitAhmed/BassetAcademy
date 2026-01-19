<?php

session_start();

include 'db_connection.php';


$response = ['success' => false, 'errors' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate session
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['UserID'])) {
        $response['errors']['general'] = 'session';
        echo json_encode($response);
        exit();
    }

    $user_id = $_SESSION['user']['UserID'];
    $title = trim($_POST['course-title'] ?? '');
    $description = trim($_POST['course-description'] ?? '');
    $semester = $_POST['semester'] ?? '';
    $price = isset($_POST['price']) ? (int)$_POST['price'] : null;

    // Validate input
    if (empty($title)) $response['errors']['course-title'] = 'العنوان مطلوب.';
    if (empty($description)) $response['errors']['course-description'] = 'الوصف مطلوب.';
    if (empty($semester)) $response['errors']['course-semester'] = 'السنة الدراسية مطلوبة.';
    if ($price === null || $price <= 0) $response['errors']['course-price'] = 'يرجى إدخال سعر صالح.';

    if (!empty($response['errors'])) {
        echo json_encode($response);
        exit();
    }

    // Handle image upload
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
        $response['errors']['course-image'] = 'الصورة مطلوبة.';
        echo json_encode($response);
        exit();
    }

    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_name = basename($_FILES['image']['name']);
    $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
    $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array(strtolower($image_ext), $allowed_exts)) {
        $response['errors']['course-image'] = 'تنسيق الصورة غير صالح.';
        echo json_encode($response);
        exit();
    }

    $image_upload_path = "uploads/images/" . uniqid('img_') . ".$image_ext";
    if (!move_uploaded_file($image_tmp_name, $image_upload_path)) {
        $response['errors']['course-image'] = 'فشل تحميل الصورة.';
        echo json_encode($response);
        exit();
    }

    // Insert course
    $stmt = $conn->prepare("INSERT INTO Course (Course_title, Course_description, Course_image, semester, price, UserID) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssii", $title, $description, $image_upload_path, $semester, $price, $user_id);

    if ($stmt->execute()) {
        $course_id = $stmt->insert_id;

        // Handle summaries
        if (isset($_FILES['summarize'])) {
            foreach ($_FILES['summarize']['tmp_name'] as $index => $tmp_name) {
                if ($_FILES['summarize']['error'][$index] === 0) {
                    $summary_name = basename($_FILES['summarize']['name'][$index]);
                    $summary_ext = pathinfo($summary_name, PATHINFO_EXTENSION);

                    if (strtolower($summary_ext) !== 'pdf') continue;

                    $summary_upload_path = "uploads/summaries/" . uniqid('sum_') . ".$summary_ext";
                    if (move_uploaded_file($tmp_name, $summary_upload_path)) {
                        $summary_stmt = $conn->prepare("INSERT INTO CourseSummarize (summary_content, CourseID) VALUES (?, ?)");
                        $summary_stmt->bind_param("si", $summary_upload_path, $course_id);
                        $summary_stmt->execute();
                    }
                }
            }
        }

        $response['success'] = true;
    } else {
        $response['errors']['general'] = 'خطأ أثناء حفظ الدورة.';
    }

    $stmt->close();
} else {
    $response['errors']['general'] = 'طلب غير صالح.';
}

$conn->close();
echo json_encode($response);
?>
