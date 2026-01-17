<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "bassetdb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback_id'])) {
    $feedback_id = intval($_POST['feedback_id']);

    $sql = "DELETE FROM Feedback WHERE FeedbackID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $feedback_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Feedback deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting feedback: " . $conn->error;
    }

    $stmt->close();
} else {
    $_SESSION['message'] = "No feedback ID provided.";
}

$conn->close();

header("Location: Admin-Dashboard.php"); // Redirect to a success page or the same page
exit();
?>
