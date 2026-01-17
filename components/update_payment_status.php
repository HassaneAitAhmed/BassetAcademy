<?php
include('db_connection.php');

if (isset($_POST['payment_id']) && isset($_POST['status']) && isset($_POST['payment_value'])) {
    $payment_id = $_POST['payment_id'];
    $status = $_POST['status'];
    $payment_value = $_POST['payment_value'];

    if (!is_numeric($payment_value) || $payment_value <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid payment value']);
        exit();
    }

    $query = "UPDATE Payement SET PaymentStatus = ? WHERE PayementID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $status, $payment_id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        if ($status === 'accepted') {
            $query = "SELECT StudentID FROM Payement WHERE PayementID = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'i', $payment_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $payment = mysqli_fetch_assoc($result);
            $student_id = $payment['StudentID'];

            $query = "UPDATE User SET User_Points = User_Points + ? WHERE UserID = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'di', $payment_value, $student_id);
            $points_result = mysqli_stmt_execute($stmt);

            if (!$points_result) {
                echo json_encode(['success' => false, 'message' => 'Failed to update user points']);
                exit();
            }
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update payment status']);
    }

    mysqli_stmt_close($stmt);
}
?>
