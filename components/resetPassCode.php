<?php
session_start();

include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['code'])) {
        $code = trim($_POST['code']);

        $query = 'SELECT * FROM Password_reset_codes WHERE Code = ?';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $code);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION['UserID_resetPass'] = $row['UserID'];

            $query2 = 'DELETE FROM Password_reset_codes WHERE Code = ?';
            $stmt->prepare($query2);
            $stmt->bind_param('i', $code);
            $stmt->execute();
            header("Location: newPass.php");
            exit;
        } else {
            $_SESSION['error'] = "رمز التحقق غير صحيح";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <link rel="stylesheet" href="../css/Pass.css">
</head>
<body>
  <div class="container">
    <h2>أدخل رمز التحقق</h2>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color: red; text-align: center;">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    ?>
    <form action="" method="POST">
      <label for="code" dir="rtl" style="font-size:2ch;">أدخل الرمز المرسل إلى بريدك الإلكتروني</label>
      <input type="text" id="code" name="code" placeholder="الرمز" style="text-align:center;">
      <button type="submit">التحقق</button>
    </form>
  </div>
</body>
</html>
