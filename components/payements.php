<?php
include('db_connection.php');

$query = "SELECT * FROM Payement WHERE PaymentStatus = 'pending'"; 
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $payment_id = $row['PayementID'];
        $student_id = $row['StudentID'];
        $amount = $row['Payementvalue'];
        $date = $row['payment_date'];
        $proof = $row['Payementphoto'];

        $student_query = "SELECT User_LastName FROM User WHERE UserID = ?";
        $stmt = $conn->prepare($student_query);
        $stmt->bind_param('i', $student_id);
        $stmt->execute();
        $student_result = $stmt->get_result();
        $student = $student_result->fetch_assoc();
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
