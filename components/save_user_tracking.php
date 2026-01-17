<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'bassetdb';
    $port = 3306;

    @$Connection = new mysqli($servername, $username, $password, $dbname, $port);

    if ($Connection->connect_error) {
        die("Connection failed: " . $Connection->connect_error);
    }

    if (isset($_POST['userID'], $_POST['deviceType'], $_POST['deviceName'], $_POST['deviceOperator'], $_POST['browser'], $_POST['lastActivity'], $_POST['logDate'])) {
        $userID = $_POST['userID'];
        $deviceType = $_POST['deviceType'];
        $deviceName = $_POST['deviceName'];
        $deviceOperator = $_POST['deviceOperator'];
        $browser = $_POST['browser'];
        $lastActivity = $_POST['lastActivity'];
        $logDate = $_POST['logDate'];

        $query = "INSERT INTO StudentSecurity (UserID, devicetype, devicename, deviceoperator, browser, logtime) 
        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $Connection->prepare($query);
        $stmt->bind_param('issssss', $userID, $deviceType, $deviceName, $deviceOperator, $browser, $lastActivity, $logDate);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Data inserted successfully";
        } else {
            echo "No rows affected";
        }

        $stmt->close();
    } else {
        echo "Missing data";
    }

    $Connection->close();
}
