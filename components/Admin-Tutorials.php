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
    <title>Admin Manage Courses</title>
    <link rel="stylesheet" href="../css/Admin-Tutorials.css">
</head>

<body>
    <h1>Admin - Manage Courses</h1>

    <?php
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'bassetdb');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete course
    if (isset($_POST['delete'])) {
        $CourseID = intval($_POST['CourseID']);
        if ($CourseID > 0) {
            $deleteQuery = "DELETE FROM Course WHERE CourseID = ?";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param("i", $CourseID);
            $stmt->execute();
            $stmt->close();
            
            // Show alert and refresh
            echo "<script>alert('Course deleted successfully.'); window.location.href = window.location.href;</script>";
        } else {
            echo "<p>Invalid CourseID.</p>";
        }
    }

    // Update course
    if (isset($_POST['update'])) {
        $courseID = $_POST['CourseID'];
        $title = $_POST['Course_title'];
        $description = $_POST['Course_description'];
        $semester = $_POST['semester'];
        $price = $_POST['price'];
        $image = $_FILES['Course_image']['name'];
        $imagePath = null;

        if (!empty($title) && !empty($semester) && is_numeric($price)) {
            if (!empty($image)) {
                $targetDir = "uploads/";
                $imagePath = $targetDir . basename($image);
                if (!move_uploaded_file($_FILES['Course_image']['tmp_name'], $imagePath)) {
                    echo "<p>Error uploading image.</p>";
                    return;
                }
            }

            $query = "UPDATE Course SET Course_title = ?, Course_description = ?, semester = ?, price = ?";
            $params = [$title, $description, $semester, $price];
            if ($imagePath) {
                $query .= ", Course_image = ?";
                $params[] = $imagePath;
            }

            $query .= " WHERE CourseID = ?";
            $params[] = $courseID;

            $stmt = $conn->prepare($query);
            if ($stmt) {
                $stmt->bind_param(str_repeat("s", count($params) - 1) . "i", ...$params);
                if ($stmt->execute()) {
                    // Show alert and refresh
                    echo "<script>alert('Course updated successfully.'); window.location.href = window.location.href;</script>";
                } else {
                    echo "<p>Error updating course: " . $stmt->error . "</p>";
                }
                $stmt->close();
            } else {
                echo "<p>Error preparing update statement: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Please ensure all fields are filled out correctly.</p>";
        }
    }

    // Fetch courses
    $result = $conn->query("SELECT * FROM Course");

    // Handle delete summary action
    if (isset($_POST['delete_summary'])) {
        $summarizeID = intval($_POST['summarizeID']);
        $query = "SELECT summary_content FROM CourseSummarize WHERE summarizeID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $summarizeID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $filePath = $row['summary_content'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $deleteQuery = "DELETE FROM CourseSummarize WHERE summarizeID = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $summarizeID);
            $deleteStmt->execute();
            $deleteStmt->close();
            
            // Show alert and refresh
            echo "<script>alert('Summary deleted successfully.'); window.location.href = window.location.href;</script>";
        } else {
            echo "<p>Summary not found.</p>";
        }
    }

    // Handle add summary action
    if (isset($_POST['add_summary'])) {
        $courseID = intval($_POST['CourseID']);
        $summaryContent = $_FILES['summary_file']['name'];

        $targetDir = "upload/summaries/";
        $targetFile = $targetDir . basename($summaryContent);

        if (!empty($_FILES['summary_file']['tmp_name'])) {
            if (move_uploaded_file($_FILES['summary_file']['tmp_name'], $targetFile)) {
                $query = "INSERT INTO CourseSummarize (summary_content, CourseID) VALUES (?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("si", $targetFile, $courseID);
                $stmt->execute();
                $stmt->close();
                
                // Show alert and refresh
                echo "<script>alert('Summary added successfully.'); window.location.href = window.location.href;</script>";
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
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Semester</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><img src="<?php echo $row['Course_image']; ?>" alt="Course Image"></td>
                        <td><?php echo $row['Course_title']; ?></td>
                        <td><?php echo $row['Course_description']; ?></td>
                        <td><?php echo $row['semester']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td class="table-actions">
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="CourseID" value="<?php echo $row['CourseID']; ?>">
                                <button type="button" class="button"
                                    onclick="showEditForm(<?php echo $row['CourseID']; ?>)">Edit</button>
                            </form>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="CourseID" value="<?php echo $row['CourseID']; ?>">
                                <button type="submit" class="button delete-button" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <tr id="edit-form-<?php echo $row['CourseID']; ?>" class="edit-form">
                        <td colspan="6">
                            <form method="post" enctype="multipart/form-data">
                                <input type="hidden" name="CourseID" value="<?php echo $row['CourseID']; ?>">
                                <div class="form-container">
                                    <input type="text" name="Course_title" value="<?php echo $row['Course_title']; ?>"
                                        placeholder="Title" required>
                                    <input type="text" name="Course_description"
                                        value="<?php echo $row['Course_description']; ?>" placeholder="Description">
                                    <select name="semester">
                                        <option value="S1" <?php if ($row['semester'] == 'S1') echo 'selected'; ?>>S1</option>
                                        <option value="S2" <?php if ($row['semester'] == 'S2') echo 'selected'; ?>>S2</option>
                                        <option value="S3" <?php if ($row['semester'] == 'S3') echo 'selected'; ?>>S3</option>
                                    </select>
                                    <input type="number" name="price" value="<?php echo $row['price']; ?>" placeholder="Price">
                                    <label>Change Image:</label>
                                    <input type="file" name="Course_image">
                                </div>
                                <button type="submit" class="button" name="update">Update Course</button>
                            </form>

                            <!-- Summary Management Section -->
                            <div class="edit-section">
                                <h3>Manage Summaries</h3>
                                <?php
                                $courseID = $row['CourseID'];
                                $summaries = $conn->query("SELECT * FROM CourseSummarize WHERE CourseID = $courseID");
                                ?>
                                <ul>
                                    <?php while ($summary = $summaries->fetch_assoc()): ?>
                                        <li>
                                            <a href="<?php echo $summary['summary_content']; ?>" target="_blank">View Summary</a>
                                            <form method="post" style="display:inline;">
                                                <input type="hidden" name="summarizeID"
                                                    value="<?php echo $summary['summarizeID']; ?>">
                                                <button type="submit" class="button delete-button"
                                                    name="delete_summary">Delete Summary</button>
                                            </form>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="CourseID" value="<?php echo $courseID; ?>">
                                    <label>Add Summary:</label>
                                    <input type="file" name="summary_file" required>
                                    <button type="submit" class="button" name="add_summary">Add Summary</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No courses available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        function showEditForm(courseID) {
            var form = document.getElementById('edit-form-' + courseID);
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'table-row' : 'none';
        }
    </script>

</body>

</html>
