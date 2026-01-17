<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bassetdb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT m.MessageID, m.UserName, m.UserEmail, m.MessageContent, m.MessageStatus 
        FROM Message m
        ORDER BY m.MessageID DESC"; 

$result = $conn->query($sql);

if (!$result) {
    die("Error in SQL query: " . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='message-card'>";
        echo "<h3>الاسم: " . htmlspecialchars($row['UserName']) . "</h3>";
        echo "<p>البريد الإلكتروني: " . htmlspecialchars($row['UserEmail']) . "</p>";
        echo "<p>الرسالة:</p>";
        echo "<p>" . nl2br(htmlspecialchars($row['MessageContent'])) . "</p>";
        echo "<div class='messg-options'>";
        echo "<div class='reply'>";
        echo "<a href='mailto:" . htmlspecialchars($row['UserEmail']) . "'>reply</a>";
        echo "</div>";
        echo "<form method='POST' action='delete_message.php' style='display:inline;'>";
        echo "<input type='hidden' name='message_id' value='" . $row['MessageID'] . "'>";
        echo "<button type='submit'>delete</button>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>لا توجد رسائل لعرضها.</p>";
}

$conn->close();
?>
