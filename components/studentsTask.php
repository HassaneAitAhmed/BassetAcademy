

<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Check if the user has the role of Admin
if ($_SESSION['user']['Role'] !== 'Admin') {
    echo "Access denied. You do not have permission to access this page.";
    exit();
}

require_once 'db_connection.php';

$courses = [];
$tasks = [];
$filter_course = '';
$filter_status = '';
$search_term = '';

$stmt = $conn->prepare("SELECT CourseID, Course_title FROM Course");
if ($stmt->execute()) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filter_course = $_POST['courseFilter'] ?? '';
    $filter_status = $_POST['statusFilter'] ?? '';
    $search_term = $_POST['search'] ?? '';

    $query = "SELECT 
                st.TaskID, 
                st.stud_solution, 
                u.User_FirstName, 
                u.User_LastName, 
                t.Task_title, 
                st.AssessmentStatus, 
                st.AssessmentScore, 
                c.Course_title 
              FROM StudentTasks st
              INNER JOIN Tasks t ON st.TaskID = t.TaskID
              INNER JOIN User u ON st.StudentID = u.UserID
              INNER JOIN Course c ON t.course_ID = c.CourseID
              WHERE 1=1";

    if (!empty($filter_course)) {
        $query .= " AND c.CourseID = ?";
    }
    if (!empty($filter_status)) {
        $query .= " AND st.AssessmentStatus = ?";
    }
    if (!empty($search_term)) {
        $query .= " AND (u.User_FirstName LIKE ? OR u.User_LastName LIKE ? OR t.Task_title LIKE ?)";
    }

    $stmt = $conn->prepare($query);

    $bind_types = '';
    $bind_values = [];

    if (!empty($filter_course)) {
        $bind_types .= 'i';
        $bind_values[] = $filter_course;
    }
    if (!empty($filter_status)) {
        $bind_types .= 's';
        $bind_values[] = $filter_status;
    }
    if (!empty($search_term)) {
        $search_like = "%$search_term%";
        $bind_types .= 'sss';
        $bind_values = array_merge($bind_values, [$search_like, $search_like, $search_like]);
    }

    if (!empty($bind_values)) {
        $stmt->bind_param($bind_types, ...$bind_values);
    }

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
    } else {
        echo "Error fetching tasks: " . $stmt->error;
    }
    $stmt->close();
} else {
    $query = "SELECT 
                st.TaskID, 
                st.stud_solution, 
                u.User_FirstName, 
                u.User_LastName, 
                t.Task_title, 
                st.AssessmentStatus, 
                st.AssessmentScore, 
                c.Course_title 
              FROM StudentTasks st
              INNER JOIN Tasks t ON st.TaskID = t.TaskID
              INNER JOIN User u ON st.StudentID = u.UserID
              INNER JOIN Course c ON t.course_ID = c.CourseID";

    $result = $conn->query($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
    }
}

// Handle task update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editTask'])) {
    $taskID = $_POST['editTaskID'];
    $score = $_POST['score'];
    $status = $_POST['status'];

    if (!empty($score)) {
        $status = 'Graded';
    }

    $stmt = $conn->prepare("UPDATE StudentTasks SET AssessmentStatus = ?, AssessmentScore = ? WHERE TaskID = ?");
    $stmt->bind_param("sii", $status, $score, $taskID);

    if ($stmt->execute()) {
        $message = "Task updated successfully.";
    } else {
        $message = "Error updating task: " . $stmt->error;
    }
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Student Tasks</title>
    <link rel="stylesheet" href="styles.css">

    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(to right, #007bff, #0056b3);
            color: white;
            border-radius: 8px;
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        form {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            align-items: center;
        }

        form input[type="text"],
        form select {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        form button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        form button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        table thead {
            background-color: #007bff;
            color: white;
        }

        table th,
        table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        table td select,
        table td input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .edit-btn {
            background-color: #28a745;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .edit-btn:hover {
            background-color: #218838;
        }

        @media (max-width: 768px) {
            form {
                flex-direction: column;
                gap: 10px;
            }

            table th,
            table td {
                padding: 10px;
            }
        }
    </style>

    <style>
        .custom-select {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .custom-select select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #fff url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M6 8L1 3h10z" fill="%23333"/></svg>') no-repeat right 10px center;
            background-size: 12px 12px;
            cursor: pointer;
        }

        .custom-select select:hover {
            border-color: #007bff;
        }

        .custom-select select:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            border-color: #007bff;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Student Task Management</h1>
        </header>

        <form method="POST" action="">
            <input type="text" name="search" placeholder="Search by Student Name or Task Title"
                value="<?= htmlspecialchars($search_term) ?>">
            <select name="courseFilter">
                <option value="">All Courses</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?= $course['CourseID'] ?>" <?= $filter_course == $course['CourseID'] ? 'selected' : '' ?>>
                        <?= $course['Course_title'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <select name="statusFilter">
                <option value="">All Statuses</option>
                <option value="Pending" <?= $filter_status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Graded" <?= $filter_status == 'Graded' ? 'selected' : '' ?>>Graded</option>
            </select>
            <button type="submit">Apply Filters</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Student Solution</th>
                    <th>Student</th>
                    <th>Task Title</th>
                    <th>Course</th>
                    <th>Status</th>
                    <th>Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tasks)): ?>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><a href="<?= htmlspecialchars($task['stud_solution']) ?>" target="_blank">Student Answer 📃</a>
                            </td>
                            <td><?= htmlspecialchars($task['User_FirstName'] . " " . $task['User_LastName']) ?></td>
                            <td><?= htmlspecialchars($task['Task_title']) ?></td>
                            <td><?= htmlspecialchars($task['Course_title']) ?></td>
                            <td><?= htmlspecialchars($task['AssessmentStatus']) ?></td>
                            <td><?= htmlspecialchars($task['AssessmentScore']) ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="editTaskID" value="<?= $task['TaskID'] ?>">
                                    <div class="custom-select">
                                        <select name="status">
                                            <option value="Pending" <?= $task['AssessmentStatus'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="Graded" <?= $task['AssessmentStatus'] == 'Graded' ? 'selected' : '' ?>>
                                                Graded</option>
                                        </select>
                                    </div>
                                    <input type="number" name="score" min="0" max="100"
                                        value="<?= htmlspecialchars($task['AssessmentScore']) ?>" required>
                                    <button type="submit" name="editTask" class="edit-btn">Save</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">No tasks found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>