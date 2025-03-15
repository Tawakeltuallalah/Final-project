<?php
session_start();
require 'dbconfig.php';

// Ensure school_id exists in session
if (!isset($_SESSION['school_id'])) {
    die("Error: School ID is not set in session. Please log in again.");
}

$school_id = $_SESSION['school_id'];

// Fetch pending student registrations
$student_query = "SELECT * FROM student WHERE School_id = $school_id";
$students = $conn->query($student_query);

// Fetch pending teacher registrations
$teacher_query = "SELECT * FROM teacher WHERE School_id = $school_id";
$teachers = $conn->query($teacher_query);

// Approve Student
if (isset($_GET['approve_student'])) {
    $student_id = intval($_GET['approve_student']);
    $conn->query("UPDATE student SET status='Approved' WHERE Student_id=$student_id");
    header("Location: manage_data.php");
    exit();
}

// Remove Student
if (isset($_GET['delete_student'])) {
    $student_id = intval($_GET['delete_student']);
    $conn->query("DELETE FROM student WHERE Student_id=$student_id");
    header("Location: manage_data.php");
    exit();
}

// Approve Teacher
if (isset($_GET['approve_teacher'])) {
    $teacher_id = intval($_GET['approve_teacher']);
    $conn->query("UPDATE teacher SET status='Approved' WHERE Teacher_id=$teacher_id");
    header("Location: manage_data.php");
    exit();
}

// Remove Teacher
if (isset($_GET['delete_teacher'])) {
    $teacher_id = intval($_GET['delete_teacher']);
    $conn->query("DELETE FROM teacher WHERE Teacher_id=$teacher_id");
    header("Location: manage_data.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 900px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #2a3f54;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #2a3f54;
            color: white;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
            color: white;
            display: inline-block;
        }

        .btn-approve {
            background: #28a745;
        }

        .btn-approve:hover {
            background: #218838;
        }

        .btn-delete {
            background: red;
        }

        .btn-delete:hover {
            background: darkred;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background 0.3s ease-in-out;
        }

        .back-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Student Data</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Grade</th>
            <th>Gender</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $students->fetch_assoc()): ?>
            <tr>
                <td><?= $row['Student_id'] ?></td>
                <td><?= $row['Student_name'] ?></td>
                <td><?= $row['Grade'] ?></td>
                <td><?= $row['Gender'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <?php if ($row['status'] === 'Pending'): ?>
                        <a href="?approve_student=<?= $row['Student_id'] ?>" class="btn btn-approve">Approve</a>
                    <?php endif; ?>
                    <a href="?delete_student=<?= $row['Student_id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Manage Teacher Data</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Subject</th>
            <th>Gender</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $teachers->fetch_assoc()): ?>
            <tr>
                <td><?= $row['Teacher_id'] ?></td>
                <td><?= $row['Full_name'] ?></td>
                <td><?= $row['Subject'] ?></td>
                <td><?= $row['Gender'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <?php if ($row['status'] === 'Pending'): ?>
                        <a href="?approve_teacher=<?= $row['Teacher_id'] ?>" class="btn btn-approve">Approve</a>
                    <?php endif; ?>
                    <a href="?delete_teacher=<?= $row['Teacher_id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="school_director.php" class="back-btn">Back to Dashboard</a>
</div>

</body>
</html>
