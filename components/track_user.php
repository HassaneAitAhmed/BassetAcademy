<?php
session_start();
if (isset($_POST['user_id']) && isset($_POST['device_type']) && isset($_POST['device_name']) && isset($_POST['device_operator']) && isset($_POST['browser'])) {
    $userID = $_POST['user_id'];
    $deviceType = $_POST['device_type'];
    $deviceName = $_POST['device_name'];
    $deviceOperator = $_POST['device_operator'];
    $browser = $_POST['browser'];

    $currentDate = date("Y-m-d"); // Get current date for logdate and lastactivity

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'bassetdb';
    $port = 3306;

    $Connection = new mysqli($servername, $username, $password, $dbname, $port);

    if ($Connection->connect_error) {
        die("Connection failed: " . $Connection->connect_error);
    }

    $stmt = $Connection->prepare("INSERT INTO StudentSecurity (UserID, devicetype, devicename, deviceoperator, browser, lastactivity, logdate) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('issssss', $userID, $deviceType, $deviceName, $deviceOperator, $browser, $currentDate, $currentDate);
    
    if ($stmt->execute()) {
        echo "Tracking information saved successfully.";
    } else {
        echo "Error saving tracking information: " . $stmt->error;
    }

    $stmt->close();
    $Connection->close();
}
?>
