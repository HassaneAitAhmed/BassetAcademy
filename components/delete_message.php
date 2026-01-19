<?php
include 'db_connection.php';

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
