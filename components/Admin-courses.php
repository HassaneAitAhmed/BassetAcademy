<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Check if the user has the role of Admin
if ($_SESSION['user']['Role'] !== 'Admin') {
    echo "Access denied. You do not have permission to access this page.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Tutorials</title>
    <link rel="stylesheet" href="../css/Admin-Tutorials.css">
</head>

<body>
    <h1>Admin - Manage Tutorials</h1>

    <?php
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'bassetdb');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete tutorial
    if (isset($_POST['delete'])) {
        $tutorialID = intval($_POST['tutorial_ID']);
        if ($tutorialID > 0) {
            $conn->query("DELETE FROM TutorialMaterials WHERE tutorial_ID = $tutorialID");
            $conn->query("DELETE FROM TutorialSummary WHERE tutorial_ID = $tutorialID");
            
            $deleteQuery = "DELETE FROM Tutorials WHERE tutorial_ID = ?";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param("i", $tutorialID);
            $stmt->execute();
            $stmt->close();
            
            echo "<script>alert('Tutorial deleted successfully.'); window.location.href = window.location.href;</script>";
        } else {
            echo "<p>Invalid tutorial ID.</p>";
        }
    }

    // Update tutorial
    if (isset($_POST['update'])) {
        $tutorialID = $_POST['tutorial_ID'];
        $title = $_POST['tutorial_title'];
        $description = $_POST['tutorial_description'];
        $courseID = $_POST['course_ID'];
        $video = $_FILES['tutorial_video']['name'];
        $videoPath = null;

        if (!empty($title) && !empty($description) && !empty($courseID)) {
            if (!empty($video)) {
                $targetDir = "uploads/videos/";
                $videoPath = $targetDir . basename($video);
                if (!move_uploaded_file($_FILES['tutorial_video']['tmp_name'], $videoPath)) {
                    echo "<p>Error uploading video.</p>";
                    return;
                }
            }

            $query = "UPDATE Tutorials SET tutorial_title = ?, tutorial_description = ?, course_ID = ?";
            $params = [$title, $description, $courseID];
            if ($videoPath) {
                $query .= ", tutorial_video = ?";
                $params[] = $videoPath;
            }

            $query .= " WHERE tutorial_ID = ?";
            $params[] = $tutorialID;

            $stmt = $conn->prepare($query);
            if ($stmt) {
                $stmt->bind_param(str_repeat("s", count($params) - 1) . "i", ...$params);
                if ($stmt->execute()) {
                    echo "<script>alert('Tutorial updated successfully.'); window.location.href = window.location.href;</script>";
                } else {
                    echo "<p>Error updating tutorial: " . $stmt->error . "</p>";
                }
                $stmt->close();
            } else {
                echo "<p>Error preparing update statement: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Please ensure all fields are filled out correctly.</p>";
        }
    }

    // Fetch tutorials
    $result = $conn->query("SELECT * FROM Tutorials");

    // Handle delete summary action
    if (isset($_POST['delete_summary'])) {
        $summaryID = intval($_POST['summaryID']);
        $query = "SELECT summary_content FROM TutorialSummary WHERE SummaryID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $summaryID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $filePath = $row['summary_content'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $deleteQuery = "DELETE FROM TutorialSummary WHERE SummaryID = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $summaryID);
            $deleteStmt->execute();
            $deleteStmt->close();
            
            echo "<script>alert('Tutorial Summary deleted successfully.'); window.location.href = window.location.href;</script>";
        } else {
            echo "<p>Summary not found.</p>";
        }
    }

    // Handle add summary action
    if (isset($_POST['add_summary'])) {
        $tutorialID = intval($_POST['tutorial_ID']);
        $summaryContent = $_FILES['summary_file']['name'];

        $targetDir = "uploads/summaries/";
        $targetFile = $targetDir . basename($summaryContent);

        if (!empty($_FILES['summary_file']['tmp_name'])) {
            if (move_uploaded_file($_FILES['summary_file']['tmp_name'], $targetFile)) {
                $query = "INSERT INTO TutorialSummary (summary_content, tutorial_ID) VALUES (?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("si", $targetFile, $tutorialID);
                $stmt->execute();
                $stmt->close();
                
                echo "<script>alert('Summary added successfully.'); window.location.href = window.location.href;</script>";
            } else {
                echo "<p>Error uploading file.</p>";
            }
        } else {
            echo "<p>No file selected. Please choose a file to upload.</p>";
        }
    }

    // Handle delete material action
    if (isset($_POST['delete_material'])) {
        $materialID = intval($_POST['materialID']);
        $query = "SELECT Material_content FROM TutorialMaterials WHERE MaterialID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $materialID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $filePath = $row['Material_content'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $deleteQuery = "DELETE FROM TutorialMaterials WHERE MaterialID = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $materialID);
            $deleteStmt->execute();
            $deleteStmt->close();
            
            echo "<script>alert('Tutorial Material deleted successfully.'); window.location.href = window.location.href;</script>";
        } else {
            echo "<p>Material not found.</p>";
        }
    }

    // Handle add material action
    if (isset($_POST['add_material'])) {
        $tutorialID = intval($_POST['tutorial_ID']);
        $materialContent = $_FILES['material_file']['name'];

        $targetDir = "uploads/materials/";
        $targetFile = $targetDir . basename($materialContent);

        if (!empty($_FILES['material_file']['tmp_name'])) {
            if (move_uploaded_file($_FILES['material_file']['tmp_name'], $targetFile)) {
                $query = "INSERT INTO TutorialMaterials (Material_content, tutorial_ID) VALUES (?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("si", $targetFile, $tutorialID);
                $stmt->execute();
                $stmt->close();
                
                echo "<script>alert('Material added successfully.'); window.location.href = window.location.href;</script>";
            } else {
                echo "<p>Error uploading file.</p>";
            }
        } else {
            echo "<p>No file selected. Please choose a file to upload.</p>";
        }
    }
    ?>

    <table>
        <thead>
            <tr>
                <th>Video</th>
                <th>Title</th>
                <th>Description</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><video width="100" controls><source src="<?php echo $row['tutorial_video']; ?>" type="video/mp4"></video></td>
                        <td><?php echo $row['tutorial_title']; ?></td>
                        <td><?php echo $row['tutorial_description']; ?></td>
                        <td>
                            <?php
                            $courseResult = $conn->query("SELECT Course_title FROM Course WHERE CourseID = " . $row['course_ID']);
                            $course = $courseResult->fetch_assoc();
                            echo $course ? $course['Course_title'] : 'N/A';
                            ?>
                        </td>
                        <td class="table-actions">
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="tutorial_ID" value="<?php echo $row['tutorial_ID']; ?>">
                                <button type="button" class="button"
                                    onclick="showEditForm(<?php echo $row['tutorial_ID']; ?>)">Edit</button>
                            </form>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="tutorial_ID" value="<?php echo $row['tutorial_ID']; ?>">
                                <button type="submit" name="delete" class="button delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <tr id="edit-form-<?php echo $row['tutorial_ID']; ?>" style="display:none;">
                        <td colspan="5">
                            <form method="post" enctype="multipart/form-data">
                                <input type="hidden" name="tutorial_ID" value="<?php echo $row['tutorial_ID']; ?>">
                                <label>Title:</label><input type="text" name="tutorial_title" value="<?php echo $row['tutorial_title']; ?>" required><br>
                                <label>Description:</label><textarea name="tutorial_description" required><?php echo $row['tutorial_description']; ?></textarea><br>
                                <label>Video:</label><input type="file" name="tutorial_video"><br>
                                <label>Course:</label>
                                <select name="course_ID">
                                    <?php
                                    $courseResult = $conn->query("SELECT * FROM Course");
                                    while ($course = $courseResult->fetch_assoc()) {
                                        echo "<option value='" . $course['CourseID'] . "'" . ($course['CourseID'] == $row['course_ID'] ? ' selected' : '') . ">" . $course['Course_title'] . "</option>";
                                    }
                                    ?>
                                </select><br>
                                <button type="submit" name="update" class="button">Update Tutorial</button>
                            </form>
                            <br>
                            <div>
                                <h3>Summaries</h3>
                                <ul>
                                    <?php
                                    $summaryResult = $conn->query("SELECT * FROM TutorialSummary WHERE tutorial_ID = " . $row['tutorial_ID']);
                                    while ($summary = $summaryResult->fetch_assoc()):
                                    ?>
                                        <li>
                                            <a href="<?php echo $summary['summary_content']; ?>" target="_blank">View Summary</a>
                                            <form method="post" style="display:inline;">
                                                <input type="hidden" name="summaryID" value="<?php echo $summary['SummaryID']; ?>">
                                                <button type="submit" name="delete_summary" class="button delete-button">Delete Summary</button>
                                            </form>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="tutorial_ID" value="<?php echo $row['tutorial_ID']; ?>">
                                    <label>Add Summary:</label>
                                    <input type="file" name="summary_file" required>
                                    <button type="submit" class="button" name="add_summary">Add Summary</button>
                                </form>
                                <h3>Materials</h3>
                                <ul>
                                    <?php
                                    $materialResult = $conn->query("SELECT * FROM TutorialMaterials WHERE tutorial_ID = " . $row['tutorial_ID']);
                                    while ($material = $materialResult->fetch_assoc()):
                                    ?>
                                        <li>
                                            <a href="<?php echo $material['Material_content']; ?>" target="_blank">View Material</a>
                                            <form method="post" style="display:inline;">
                                                <input type="hidden" name="materialID" value="<?php echo $material['MaterialID']; ?>">
                                                <button type="submit" name="delete_material" class="button delete-button">Delete Material</button>
                                            </form>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="tutorial_ID" value="<?php echo $row['tutorial_ID']; ?>">
                                    <label>Add Material:</label>
                                    <input type="file" name="material_file" required>
                                    <button type="submit" class="button" name="add_material">Add Material</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No tutorials available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        function showEditForm(tutorialID) {
            var form = document.getElementById('edit-form-' + tutorialID);
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'table-row' : 'none';
        }
    </script>

</body>

</html>
