<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: SignIn.php");
    exit();
}

$user_id = $_SESSION['user']['UserID'];

$servername = "localhost";
$username = "root";
$password = "";
$database = "bassetdb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amountError = '';
    $receiptError = '';

    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_INT, [
        'options' => [
            'min_range' => 500
        ]
    ]);

    if ($amount === false) {
        $amountError = 'يرجى إدخال مبلغ صحيح (رقم صحيح موجب أكبر من 500)';
    }

    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] == 0) {
        $file = $_FILES['receipt'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (!in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
            $receiptError = 'نوع الملف غير صالح. يرجى رفع صورة بصيغة JPG أو PNG أو JPEG أو GIF أو BMP.';
        }
    } else {
        $receiptError = 'يرجى تحميل صورة الإيصال.';
    }

    if (!empty($amountError) || !empty($receiptError)) {
        $_SESSION['amountError'] = $amountError;
        $_SESSION['receiptError'] = $receiptError;
        $_SESSION['amount'] = $_POST['amount']; 
        header("Location: ../components/Student-Dashboard.php"); 
        exit();
    }

    if (!empty($file_tmp)) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0777, true)) {
                die('Failed to create directory: ' . $upload_dir);
            }
        }
        $new_name = uniqid() . "." . $file_extension;
        $upload_path = $upload_dir . $new_name;

        if (move_uploaded_file($file_tmp, $upload_path)) {
            $admin_id = null;
            $status = 'Pending';
            $payment_date = date('Y-m-d');

            $stmt = $conn->prepare("INSERT INTO Payement (StudentID, Payementvalue, PaymentStatus, AdminID, Payementphoto, payment_date) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissss", $user_id, $amount, $status, $admin_id, $new_name, $payment_date);

            if ($stmt->execute()) {
                $_SESSION['message'] = 'تمت العملية بنجاح';
            } else {
                error_log("Database error: " . $stmt->error . "\n", 3, "error_log.txt");
                $_SESSION['message'] = 'حدث خطأ أثناء معالجة طلبك. يرجى المحاولة مرة أخرى لاحقاً.';
            }
            $stmt->close();
        } else {
            $_SESSION['message'] = 'فشل رفع الملف';
        }
    }

    header("Location: ../components/Student-Dashboard.php"); 
    exit();
}

$conn->close();

?>
