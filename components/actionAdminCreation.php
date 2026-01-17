<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'bassetdb';

@$My_connection = new mysqli ($servername,$username,$password,$dbname);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
if(!isset($_POST['adminLName']) || !isset($_POST['adminFName']) || !isset($_POST['adminEmail']) || !isset($_POST['adminPassword']) || !isset($_POST['adminConfirmPassword'])){
    exit('a Field is not Set');
}

$lastName = $_POST['adminLName'];
$firstName = $_POST['adminFName'];
$email = $_POST['adminEmail'];
$password = $_POST['adminPassword'];
$Role = 'Admin';

$hashedPassword = password_hash($password,PASSWORD_DEFAULT );

$query = 'INSERT INTO `user`  (`User_Email`, `User_Password`, `Role`, `User_FirstName`, `User_LastName`)  VALUES (?,?,?,?,?)';
$stmt = $My_connection->prepare($query);
$stmt->bind_param('sssss',$email,$hashedPassword,$Role,$firstName,$lastName);
$stmt->execute();
$stmt->close();

header('Location: admin_control.php');
}

$My_connection()->close();
?>