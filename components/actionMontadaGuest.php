<?php
session_start();
require_once 'db_connection.php';

$sql = "SELECT PostID, PostDescription, PostImage, PostLikesCounter,PostPublicationDate FROM post";
$result = $conn->query($sql);


$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
header('Content-Type: application/json');
echo json_encode($data);


?>
