<?php
session_start();
require 'dbconfig.php';

// Ensure school_id exists in session
if (!isset($_SESSION['school_id'])) {
    die("Error: School ID is not set in session. Please log in again.");
}

$school_id = $_SESSION['school_id'];
var_dump($_SESSION['school_id']);
exit; 

 
$query = "SELECT Gender, COUNT(*) as total FROM student WHERE School_id = $school_id GROUP BY Gender";
$student_data = $conn->query($query);

// Check for query execution error
if (!$student_data) {
    die("Could not fetch student data. Error: " . $conn->error);
}

// Get Total Teachers by Gender
$teacher_data = $conn->query("
    SELECT Gender, COUNT(*) as total 
    FROM teacher 
    WHERE School_id = $school_id 
    GROUP BY Gender
");

// Count Total Students & Teachers
$total_students = $conn->query("SELECT COUNT(*) as total FROM student WHERE School_id = $school_id")->fetch_assoc()['total'];
$total_teachers = $conn->query("SELECT COUNT(*) as total FROM teacher WHERE School_id = $school_id")->fetch_assoc()['total'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_report'])) {
    // Submit report to Manager
    $stmt = $conn->prepare("INSERT INTO school_reports (school_id, total_students, total_teachers, submitted_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iii", $school_id, $total_students, $total_teachers);
    
    if ($stmt->execute()) {
        $message = "<p class='success'>Report submitted successfully to the Education Bureau!</p>";
    } else {
        $message = "<p class='error'>Something went wrong. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage School Data</title>
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
            width: 100%;
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #1e3c72;
            font-size: 22px;
            margin-bottom: 15px;
        }

        .summary-box {
            background: #e3f2fd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: #ffcc00;
            color: #1e3c72;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        .btn-submit:hover {
            background: #e6b800;
            transform: scale(1.05);
        }

        .success {
            background: #28a745;
            color: white;
            padding: 10px;
            text-align: center;
            margin-bottom: 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .error {
            background: #dc3545;
            color: white;
            padding: 10px;
            text-align: center;
            margin-bottom: 10px;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Manage School Data</h2>

        <!-- Success/Error Message -->
        <?= isset($message) ? $message : ''; ?>

        <!-- Display Student Summary -->
        <div class="summary-box">Total Students: <?= $total_students; ?></div>
        <?php while ($row = $student_data->fetch_assoc()): ?>
            <div class="summary-box"><?= $row['Gender']; ?>: <?= $row['total']; ?></div>
        <?php endwhile; ?>

        <!-- Display Teacher Summary -->
        <div class="summary-box">Total Teachers: <?= $total_teachers; ?></div>
        <?php while ($row = $teacher_data->fetch_assoc()): ?>
            <div class="summary-box"><?= $row['Gender']; ?>: <?= $row['total']; ?></div>
        <?php endwhile; ?>

        <!-- Submit Report Button -->
        <form action="" method="POST">
            <button type="submit" name="submit_report" class="btn-submit">Submit Report to Education Bureau</button>
        </form>
    </div>

</body>
</html>
