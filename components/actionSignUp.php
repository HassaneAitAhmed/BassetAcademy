<?php
session_start();
unset($_SESSION["signup_errors"]);

include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['lastName']) || 
        !isset($_POST['firstName']) || 
        !isset($_POST['email']) ||  
        !isset($_POST['phoneNum']) || 
        !isset($_POST['level']) || 
        !isset($_POST['branch']) ||
        !isset($_POST['password']) || 
        !isset($_POST['confirmPassword'])
    ) {
        exit('A field is not set');
    }

    $errors = [];

    $lastName = trim($_POST['lastName']);
    $firstName = trim($_POST['firstName']);
    $email = trim($_POST['email']);
    $phoneNum = trim($_POST['phoneNum']);
    $studyLevel = trim($_POST['level']);
    $branch = trim($_POST['branch']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $Role = 'Student';
    $Points = 0;

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

    if (strlen($password) < 8 || 
        !preg_match('/\d/', $password) || 
        !preg_match('/[A-Z]/', $password) || 
        !preg_match('/[!@$%*#]/', $password)) {
        $errors['password'] = "يجب أن تكون كلمة المرور مكونة من أكثر من 8 أحرف، وتحتوي على حرف كبير واحد على الأقل، ورقم واحد على الأقل، ورمز خاص واحد على الأقل";
    }

    if ($password !== $confirmPassword) {
        $errors['confirmPassword'] = "كلمة المرور غير مطابقة";
    }

    $sql = "SELECT * FROM user WHERE User_Email = ? OR User_Phone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $phoneNum);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['User_Email'] === $email) {
            $errors['email'] = "هذا البريد الإلكتروني مستخدم بالفعل.";
        }
        if ($row['User_Phone'] === $phoneNum) {
            $errors['phoneNum'] = "رقم الهاتف هذا مستخدم بالفعل.";
        }
    }
    $stmt->close();

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = 'INSERT INTO `user` (`User_Email`, `User_Password`, `Role`, `User_FirstName`, `User_LastName`, `User_Phone`, `User_Branch`, `User_Level`, `User_Points`) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssssssi', $email, $hashedPassword, $Role, $firstName, $lastName, $phoneNum, $branch, $studyLevel, $Points);

        if ($stmt->execute()) {
            header('Location: SignIn.php');
            exit();
        } else {
            $_SESSION["signup_errors"] = ["general" => "حدث خطأ أثناء إنشاء الحساب. حاول مرة أخرى."];
        }

        $stmt->close();
    } else {
        $_SESSION["signup_errors"] = $errors;
    }

    header('Location: SignUp.php');
    exit();
}
?>
