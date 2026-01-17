<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bassetdb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['message_id'])) {
    $message_id = $_POST['message_id'];

    $sql = "DELETE FROM Message WHERE MessageID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $message_id);

    if ($stmt->execute()) {
        header("Location: Admin-dashboard.php");
        exit();
    } else {
        header("Location: view_messages.php?message=Error deleting message.");
        exit();
    }
}

$conn->close();
?>
