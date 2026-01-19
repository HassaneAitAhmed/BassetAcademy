<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Name = trim($_POST['name'] ?? '');
    $Email = trim($_POST['email'] ?? '');
    $Message = trim($_POST['message'] ?? '');
    $Status = 'NOTREAD';
    $user_id = $_SESSION['user']['UserID'] ?? null;
    $errors = [];

    if (empty($Name)) {
        $errors['name'] = "الاسم مطلوب.";
    } elseif (!preg_match("/^[\p{L} ]+$/u", $Name)) {
        $errors['name'] = "الاسم يجب أن يحتوي على أحرف فقط.";
    }

    if (empty($Email)) {
        $errors['email'] = "البريد الإلكتروني مطلوب.";
    } elseif (!preg_match('/^(?!.*\.\.)(?!.*\.$)[A-Za-z0-9._%+-]+@[A-Za-z0-9-]{2,63}\.[A-Za-z]{2,6}$/', $Email)) {
        $errors['email'] = "صيغة البريد الإلكتروني غير صحيحة.";
    } elseif (strlen($Email) > 254 || strpos($Email, '..') !== false) {
        $errors['email'] = "البريد الإلكتروني طويل جدًا أو يحتوي على أخطاء.";
    } elseif (preg_match('/\.[A-Za-z]{7,}$/', $Email)) {
        $errors['email'] = "النطاق يحتوي على امتداد طويل جدًا.";
    }

    if (empty($Message)) {
        $errors['message'] = "الرسالة مطلوبة.";
    }

    if (empty($errors)) {
        require_once 'db_connection.php';

        if ($user_id) {
            $query = 'INSERT INTO `message` (`UserId`, `UserName`, `UserEmail`, `MessageContent`, `MessageStatus`) VALUES (?, ?, ?, ?, ?)';
            $stmt = $conn->prepare($query);
            $stmt->bind_param('issss', $user_id, $Name, $Email, $Message, $Status);
        } else {
            $query = 'INSERT INTO `message` (`UserName`, `UserEmail`, `MessageContent`, `MessageStatus`) VALUES (?, ?, ?, ?)';
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssss', $Name, $Email, $Message, $Status);
        }

        if ($stmt) {
            if ($stmt->execute()) {
                echo "تم إرسال الرسالة بنجاح.";
            } else {
                echo "حدث خطأ أثناء إرسال الرسالة.";
            }
            $stmt->close();
        } else {
            echo "فشل إعداد الطلب.";
        }

        $conn->close();
    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}
?>
