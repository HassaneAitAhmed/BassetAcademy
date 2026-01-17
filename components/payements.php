<?php
include('db_connection.php');

$query = "SELECT * FROM Payement WHERE PaymentStatus = 'pending'"; 
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $payment_id = $row['PayementID'];
        $student_id = $row['StudentID'];
        $amount = $row['Payementvalue'];
        $date = $row['payment_date'];
        $proof = $row['Payementphoto'];

        $student_query = "SELECT User_LastName FROM User WHERE UserID = ?";
        $stmt = mysqli_prepare($conn, $student_query);
        mysqli_stmt_bind_param($stmt, 'i', $student_id);
        mysqli_stmt_execute($stmt);
        $student_result = mysqli_stmt_get_result($stmt);
        $student = mysqli_fetch_assoc($student_result);
        $student_name = $student['User_LastName'];

        $image_path = "../components/uploads/$proof";

        echo "<tr data-id='$payment_id'>";
        echo "<td>$student_name</td>";
        echo "<td>$amount</td>";
        echo "<td>$date</td>";

        echo "<td><a href='$image_path' target='_blank'><img src='$image_path' alt='Proof of payment' width='50' /></a></td>";

        echo "<td><button class='accept-btn' onclick='showPaymentDetails(\"$amount\", \"$date\", \"$proof\", this.closest(\"tr\"))'>تفاصيل الدفع</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No pending payments found</td></tr>";
}
?>
