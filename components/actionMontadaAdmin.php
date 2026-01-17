<?php
session_start();
$host = 'localhost';
$dbname = 'bassetdb';
$username = 'root';
$password = '';

@$connection = new mysqli($host,$username,$password,$dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['postText']) && isset($_FILES['postImage'])) {
    
    $filePath = '../assets/images/';
    $fileName = $_FILES['postImage']['name'];
    $fileTmpName = $_FILES['postImage']['tmp_name'];

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $uniqueFileName = uniqid('', true) . '.' . $fileExt;

    $fileDestination = $filePath . $uniqueFileName;

    move_uploaded_file($fileTmpName, $fileDestination);


    $postText = $_POST['postText'];
    $Likes = 0;
    $Status = 'ACTIVE';

    $query = 'INSERT INTO `post` (`PostDescription`, `PostLikesCounter`, `PostStatus`, `PostImage`, `PostPublicationDate`,`UserID`) VALUES (?,?,?,?,CURDATE(),?) ';
    $stmt = $connection->prepare($query);
    $stmt->bind_param('sissi',$postText,$Likes,$Status,$fileDestination,$_SESSION['user']['UserID']);

    $stmt->execute();
    
} 

if (isset($_POST['postToBeDeleted'])) {
    $PID = $_POST['postToBeDeleted'];
    $query = 'DELETE FROM `post` WHERE PostID = ?';
    $stmt = $connection->prepare($query);
    $stmt->bind_param('i', $PID);
    $stmt->execute();
   
}


header("Location: pages/Montada-teacher.php");
$connection->close();
?>