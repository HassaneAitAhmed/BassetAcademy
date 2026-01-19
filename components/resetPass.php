<?php
session_start();


require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'db_connection.php';


function getUserByEmail($email) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM User WHERE User_Email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function savePasswordResetCode($userId, $code) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM password_reset_codes WHERE UserID = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO password_reset_codes (UserID, code) VALUES (?, ?)");
    $stmt->bind_param('is', $userId, $code);
    $stmt->execute();
}

function sendEmail($email, $code) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        // TODO: Replace with your own email and password
        $mail->Username = 'your_email@gmail.com'; 
        $mail->Password = 'your_password'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
    
        $mail->setFrom('your_email@gmail.com', 'Basset Academy');
        $mail->addAddress($email);
    
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Code';
    
        $mail->Body = "
        <!DOCTYPE html>
        <html lang='en' style='margin: 0; padding: 0; box-sizing: border-box;'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Password Reset Code</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                }
                .email-container {
                    max-width: 600px;
                    margin: 30px auto;
                    background-color: #ffffff;
                    border: 1px solid #e6e6e6;
                    border-radius: 8px;
                    overflow: hidden;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }
                .email-header {
                    background-color: #0047ab;
                    color: #ffffff;
                    padding: 20px;
                    text-align: center;
                }
                .email-header h1 {
                    margin: 0;
                    font-size: 24px;
                }
                .email-body {
                    padding: 30px;
                    color: #333333;
                }
                .email-body p {
                    margin: 0 0 20px;
                    font-size: 16px;
                    line-height: 1.6;
                }
                .email-body .reset-code {
                    display: inline-block;
                    background-color: #f5f5f5;
                    padding: 15px 20px;
                    font-size: 24px;
                    font-weight: bold;
                    color: #0047ab;
                    border: 1px solid #e6e6e6;
                    border-radius: 4px;
                    margin: 20px 0;
                }
                .email-footer {
                    background-color: #f4f4f4;
                    color: #666666;
                    text-align: center;
                    padding: 15px;
                    font-size: 14px;
                }
                .email-footer a {
                    color: #0047ab;
                    text-decoration: none;
                }
            </style>
        </head>
        <body>
            <div class='email-container'>
                <div class='email-header'>
                    <h1>Basset Academy</h1>
                </div>
                <div class='email-body'>
                    <p>Dear User,</p>
                    <p>We received a request to reset your password. Please use the following code to reset your password:</p>
                    <div class='reset-code'>$code</div>
                    <p>If you did not request a password reset, please ignore this email or contact our support team immediately.</p>
                    <p>Thank you,</p>
                    <p><strong>The Basset Academy Team</strong></p>
                </div>
                <div class='email-footer'>
                    <p>Need help? <a href='mailto:support@bassetacademy.com'>Contact Support</a></p>
                    <p>&copy; 2025 Basset Academy. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>
        ";
    
        $mail->send();
    } catch (Exception $e) {
        throw new Exception("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $user = getUserByEmail($email);

    if ($user) {
        $code = random_int(100000, 999999);
        savePasswordResetCode($user['UserID'], $code);

        try {
            sendEmail($email, $code);
            header("Location: resetPassCode.php");
        } catch (Exception $e) {
            $_SESSION['error'] = "Failed to send email. Please try again.";
        }
    } else {
        $_SESSION['error'] = "لم يتم العثور على البريد الإلكتروني";
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
    <h2>إعادة تعيين كلمة المرور</h2>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color: red; text-align: center;">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    ?>
    <form action="" method="POST">
      <label for="email" dir="rtl" style="font-size:1.7ch;"> أدخل بريدك الإلكتروني</label>
      <input type="email" id="email" name="email" placeholder="البريد الإلكتروني" style="text-align:center;">
      <button type="submit">إرسال رمز التحقق</button>
    </form>
  </div>
</body>
</html>
