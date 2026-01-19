<?php
session_start();
require_once 'db_connection.php';

$sql = "SELECT PostID, PostDescription, PostImage,PostLikesCounter,PostPublicationDate FROM post";
$result = $conn->query($sql);

$sql2 = "SELECT PostID,UserID FROM studentpost WHERE UserID = ?";
$StudentID = $_SESSION['user']['UserID'];
$stmt = $conn->prepare($sql2);
$stmt->bind_param("i", $StudentID);
$stmt->execute();
$likedResult = $stmt->get_result();

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$likedData = [];
if ($likedResult->num_rows > 0) {
    while ($row = $likedResult->fetch_assoc()) {
        $likedData[] = $row; 
    }
}

$response = [
    'posts' => $data,
    'likedStatus' => $likedData
];

header('Content-Type: application/json');
echo json_encode($response);


if(isset($_POST['LikedpostID'])){
    $PostID = $_POST['LikedpostID'];
    $query1 = 'UPDATE post SET PostLikesCounter = PostLikesCounter + 1 WHERE PostID = ?';
    $stmt = $conn->prepare($query1);
    $stmt->bind_param('i',$PostID);
    $stmt->execute();
    $stmt->close();

    $query2 = 'INSERT INTO studentpost (PostID,UserID) VALUES (?,?)';
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param('ii',$PostID,$StudentID);
    $stmt2->execute();
    $stmt->close();
}elseif (isset($_POST['UnLikedpostID'])) {
    $PostID = $_POST['UnLikedpostID'];
    $query1 = 'UPDATE post SET PostLikesCounter = PostLikesCounter - 1 WHERE PostID = ?';
    $stmt = $conn->prepare($query1);
    $stmt->bind_param('i', $PostID);
    $stmt->execute();
    $stmt->close();

    $query2 = 'DELETE FROM studentpost WHERE PostID = ? AND UserID = ?';
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param('ii', $PostID, $StudentID);
    $stmt2->execute();
    $stmt2->close();
}



?>
