<?php

session_start();

include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    // Check if user is signed in
    $user_id = $_SESSION['user']['UserID'] ?? null;
    if (!$user_id) {
        echo json_encode(value: ['success' => false, 'errors' => ['general' => 'session']]);
        exit();
    }

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $course_id = isset($_POST['course_id']) ? (int)$_POST['course_id'] : 0;

    // Validation
    if (empty($title)) {
        $errors['title'] = 'العنوان مطلوب.';
    } elseif (strlen($title) <= 5) {
        $errors['title'] = 'العنوان يجب أن يكون أكثر من 5 أحرف.';
    }

    if (empty($description)) {
        $errors['description'] = 'الوصف مطلوب.';
    } elseif (strlen($description) <= 5) {
        $errors['description'] = 'الوصف يجب أن يكون أكثر من 5 أحرف.';
    }

    if (empty($course_id)) {
        $errors['course_id'] = 'يجب اختيار الدورة.';
    }

    if (!isset($_FILES['video']) || $_FILES['video']['error'] !== 0) {
        $errors['video'] = 'يجب تحميل الفيديو.';
    }

    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit();
    }

    // Handle video upload
    $video_tmp_name = $_FILES['video']['tmp_name'];
    $video_name = basename($_FILES['video']['name']);
    $video_upload_path = "uploads/videos/" . $video_name;

    if (!move_uploaded_file($video_tmp_name, $video_upload_path)) {
        echo json_encode(['success' => false, 'errors' => ['video' => 'فشل في رفع الفيديو.']]);
        exit();
    }

    // Insert tutorial
    $tutorial_sql = "INSERT INTO Tutorials (tutorial_title, tutorial_description, course_ID, tutorial_video, UserID)
                     VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($tutorial_sql);
    $stmt->bind_param("ssisi", $title, $description, $course_id, $video_upload_path, $user_id);


    if ($stmt->execute()) {
        $tutorial_id = $conn->insert_id;

        // Handle materials upload
        if (isset($_FILES['materials'])) {
            foreach ($_FILES['materials']['tmp_name'] as $index => $tmp_name) {
                if ($_FILES['materials']['error'][$index] === 0) {
                    $material_name = basename($_FILES['materials']['name'][$index]);
                    $material_upload_path = "uploads/materials/" . $material_name;
                    if (move_uploaded_file($tmp_name, $material_upload_path)) {
                        $material_sql = "INSERT INTO TutorialMaterials (Material_content, tutorial_ID)
                                         VALUES (?, ?)";
                        $material_stmt = $conn->prepare($material_sql);
                        $material_stmt->bind_param("si", $material_upload_path, $tutorial_id);
                        $material_stmt->execute();
                        $material_stmt->close();
                    }
                }
            }
        }

        // Handle summaries upload
        if (isset($_FILES['summaries'])) {
            foreach ($_FILES['summaries']['tmp_name'] as $index => $tmp_name) {
                if ($_FILES['summaries']['error'][$index] === 0) {
                    $summary_name = basename($_FILES['summaries']['name'][$index]);
                    $summary_upload_path = "uploads/summaries/" . $summary_name;
                    if (move_uploaded_file($tmp_name, $summary_upload_path)) {
                        $summary_sql = "INSERT INTO TutorialSummary (summary_content, tutorial_ID)
                                        VALUES (?, ?)";
                        $summary_stmt = $conn->prepare($summary_sql);
                        $summary_stmt->bind_param("si", $summary_upload_path, $tutorial_id);
                        $summary_stmt->execute();
                        $summary_stmt->close();
                    }
                }
            }
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'errors' => ['general' => 'حدث خطأ أثناء إنشاء الدورة.']]);
    }
    $stmt->close();
}

$conn->close();


?>
