<?php
if (isset($_POST['userID'])) {
    $userID = $_POST['userID'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $wallet = $_POST['wallet'];

    $conn = new mysqli('localhost', 'root', '', 'bassetdb');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE User SET User_FirstName = ?, User_LastName = ?, User_Email = ?, User_Phone = ?, User_Points = ?, User_Date = ? WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    list($firstName, $lastName) = explode(' ', $name, 2);
    $stmt->bind_param("ssssssi", $firstName, $lastName, $email, $phone, $wallet, $date, $userID);

    if ($stmt->execute()) {
        echo 'Success';
    } else {
        echo 'Error: ' . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
