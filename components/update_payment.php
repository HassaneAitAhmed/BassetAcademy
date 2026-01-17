<?php
$host = 'localhost';
$dbname = 'bassetdb';
$username = 'root';  
$password = '';  
$conn = new mysqli($host, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['payment_status']) && isset($_POST['payment_id'])) {
        $payment_status = $_POST['payment_status'];
        $payment_id = $_POST['payment_id'];
        
        $get_payment_query = "SELECT StudentID, Payementvalue FROM Payement WHERE PayementID = ?";
        $stmt = mysqli_prepare($conn, $get_payment_query);
        mysqli_stmt_bind_param($stmt, 'i', $payment_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($payment = mysqli_fetch_assoc($result)) {
            $student_id = $payment['StudentID'];
            $payment_value = (int)$payment['Payementvalue'];  
            
            if ($payment_status == 'accepted') {
                $update_points_query = "UPDATE user_point SET points = points + ? WHERE UserID = ?";
                $stmt_update = mysqli_prepare($conn, $update_points_query);
                mysqli_stmt_bind_param($stmt_update, 'ii', $payment_value, $student_id);
                mysqli_stmt_execute($stmt_update);
                
                if (mysqli_affected_rows($conn) > 0) {
                    echo "تم إضافة النقاط بنجاح!";
                } else {
                    echo "حدث خطأ أثناء تحديث النقاط.";
                }
            }
            
            $update_payment_status_query = "UPDATE Payement SET PaymentStatus = ? WHERE PayementID = ?";
            $stmt_status = mysqli_prepare($conn, $update_payment_status_query);
            mysqli_stmt_bind_param($stmt_status, 'si', $payment_status, $payment_id);
            mysqli_stmt_execute($stmt_status);
            
            echo "تم تحديث حالة الدفع إلى " . $payment_status;
        } else {
            echo "لم يتم العثور على الدفع.";
        }
    }
}
?>
