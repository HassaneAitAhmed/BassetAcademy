<?php
if (isset($_POST['userID'])) {
    $userID = $_POST['userID'];

    $conn = new mysqli('localhost', 'root', '', 'bassetdb');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM User WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    
    if ($stmt->execute()) {
        echo 'User deleted successfully';
    } else {
        echo 'Error: ' . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
