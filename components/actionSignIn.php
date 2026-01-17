#This Code is not being used -check SignIN.php-.
<?php

session_start();

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    exit("Email or password not provided.");
}

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'bassetdb';

@$Connection = new mysqli($servername, $username, $password, $dbname);

if ($Connection->connect_error) {
    die("Connection failed: " . $Connection->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$emailQuery = "SELECT * FROM `user` WHERE User_Email = ?";
$stmt = $Connection->prepare($emailQuery);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($userRow = $result->fetch_assoc()){
        if (password_verify($password, $userRow['User_Password'])) {
            $_SESSION['user'] = $userRow;
            if($userRow['Role'] == 'Student'){
                header("Location: ../student.php");
                exit();
            }
            else if($userRow['Role'] == 'Admin'){
                header("Location: ../admin.php");
                exit();
            }
        } 
    } 

} else {
    echo "Email does not exist.";
}

$stmt->close();
$Connection->close();

?>
