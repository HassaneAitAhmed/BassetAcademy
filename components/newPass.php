<?php
session_start();

include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['new_password'], $_POST['confirm_password'])) {
        $new_password = trim($_POST['new_password']);
        $confirm_password = trim($_POST['confirm_password']);
        $errors = [];

        // Password validation checks
        if (strlen($new_password) < 8 || 
            !preg_match('/\d/', $new_password) || 
            !preg_match('/[A-Z]/', $new_password) || 
            !preg_match('/[!@$%*#]/', $new_password)) {
            $errors['password'] = "يجب أن تكون كلمة المرور مكونة من أكثر من 8 أحرف، وتحتوي على حرف كبير واحد على الأقل، ورقم واحد على الأقل، ورمز خاص واحد على الأقل";
        }

        // Check if the passwords match
        if ($new_password !== $confirm_password) {
            $errors['confirmPassword'] = "كلمة المرور غير مطابقة";
        }

        // If no errors, proceed to update password
        if (empty($errors)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            if (isset($_SESSION['UserID_resetPass'])) {
                $user_id = $_SESSION['UserID_resetPass'];

                $query = 'UPDATE User SET User_Password = ? WHERE UserID = ?';
                $stmt = $conn->prepare($query);
                $stmt->bind_param('si', $hashed_password, $user_id);
                $stmt->execute();
                header("Location: SignIn.php");
                exit;
            }
        } else {
            // Store errors in session for displaying
            $_SESSION['errors'] = $errors;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Your Password</title>
  <link rel="stylesheet" href="../css/Pass.css">
</head>

<body>
  <div class="container">
    <h2>إعادة تعيين كلمة المرور</h2>
    
    <?php
    if (isset($_SESSION['errors'])) {
        foreach ($_SESSION['errors'] as $error) {
            echo '<p style="color: red; text-align: center;">' . $error . '</p>';
        }
        unset($_SESSION['errors']);
    }
    ?>
    
    <form action="" method="POST">
      <label for="new_password" dir="rtl" style="font-size:2ch;">أدخل كلمة المرور الجديدة</label>
      <input type="password" id="new_password" name="new_password" style="text-align:center;">
      
      <label for="confirm_password" dir="rtl" style="font-size:2ch;">تأكيد كلمة المرور الجديدة</label>
      <input type="password" id="confirm_password" name="confirm_password" style="text-align:center;">
      
      <button type="submit">إعادة تعيين</button>
    </form>
  </div>
</body>
</html>
