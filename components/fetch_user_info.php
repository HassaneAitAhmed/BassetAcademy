<?php
if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];

    $conn = new mysqli('localhost', 'root', '', 'bassetdb');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT UserID, CONCAT(User_FirstName, ' ', User_LastName) AS FullName, User_Email, User_Phone, User_Points 
    FROM User WHERE Role = 'Student' AND (User_FirstName LIKE '%$searchQuery%' OR User_LastName LIKE '%$searchQuery%' OR User_Email LIKE '%$searchQuery%')";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode([]);
    }

    $stmt->close();
    $conn->close();
}
?>
