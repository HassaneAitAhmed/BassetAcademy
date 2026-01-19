<?php
include 'db_connection.php';

$sql = "SELECT f.FeedbackID, u.UserID, 
               CONCAT(u.User_FirstName, ' ', u.User_LastName) AS Name, 
               f.FeedbackContent, f.Rating, f.FeedbackSendDate 
        FROM Feedback f
        INNER JOIN User u ON f.UserID = u.UserID
        ORDER BY f.FeedbackSendDate DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Error in SQL query: " . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='message-card'>";
        echo "<h3>الاسم: " . htmlspecialchars($row['Name']) . "</h3>";
        echo "<p>الرسالة:</p>";
        echo "<p>" . nl2br(htmlspecialchars($row['FeedbackContent'])) . "</p>";
        echo "<div class='stars'>";
        echo "<p>" . str_repeat("⭐", $row['Rating']) . "</p>";
        echo "</div>";
        echo "<div class='messg-options'>";
        echo "<form method='POST' action='delete_feedback.php'>";
        echo "<input type='hidden' name='feedback_id' value='" . $row['FeedbackID'] . "'>";
        echo "<button type='submit' class='delete-btn'>Delete</button>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>لا توجد تقييمات لعرضها.</p>";
}

$conn->close();
?>
