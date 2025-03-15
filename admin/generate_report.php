<?php
session_start();
require 'dbconfig.php';
require('fpdf/fpdf.php'); // Include FPDF Library

// Ensure only the School Director can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'School Director' || !isset($_SESSION['school_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch total students and teachers
$_SESSION['school_id'] = $row['school_id']; // Ensure this is correctly fetched from the database

$total_students = $conn->query("SELECT COUNT(*) AS total FROM student WHERE School_id = $school_id")->fetch_assoc()['total'];
$total_teachers = $conn->query("SELECT COUNT(*) AS total FROM teacher WHERE School_id = $school_id")->fetch_assoc()['total'];

// Fetch students by gender
$students_by_gender = $conn->query("SELECT Gender, COUNT(*) AS total FROM student WHERE School_id = $school_id GROUP BY Gender");

// Fetch teachers by gender
$teachers_by_gender = $conn->query("SELECT Gender, COUNT(*) AS total FROM teacher WHERE School_id = $school_id GROUP BY Gender");

// Fetch resource requests
$resource_requests = $conn->query("SELECT resource_type, quantity, status FROM resource_requests WHERE school_id = $school_id");

// Generate PDF Report
if (isset($_GET['download'])) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(190, 10, "School Report", 1, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(100, 10, "Total Students: $total_students", 0, 1);
    $pdf->Cell(100, 10, "Total Teachers: $total_teachers", 0, 1);
    $pdf->Ln(5);

    // Students by Gender
    $pdf->Cell(100, 10, "Students by Gender:", 0, 1);
    while ($row = $students_by_gender->fetch_assoc()) {
        $pdf->Cell(100, 10, "{$row['Gender']}: {$row['total']}", 0, 1);
    }
    $pdf->Ln(5);

    // Teachers by Gender
    $pdf->Cell(100, 10, "Teachers by Gender:", 0, 1);
    while ($row = $teachers_by_gender->fetch_assoc()) {
        $pdf->Cell(100, 10, "{$row['Gender']}: {$row['total']}", 0, 1);
    }
    $pdf->Ln(5);

    // Resource Requests
    $pdf->Cell(100, 10, "Resource Requests:", 0, 1);
    while ($row = $resource_requests->fetch_assoc()) {
        $pdf->Cell(100, 10, "{$row['resource_type']} - {$row['quantity']} ({$row['status']})", 0, 1);
    }
    $pdf->Ln(10);

    $pdf->Cell(100, 10, "Generated on: " . date("Y-m-d H:i:s"), 0, 1);
    $pdf->Output();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Report</title>
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
            width: 80%;
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #1e3c72;
            font-size: 24px;
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
        .btn {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn:hover {
            background: #0056b3;
            transform: scale(1.05);
        }
        .back-btn {
            background: #28a745;
        }
        .back-btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Generate School Report</h2>

    <div class="summary-box">Total Students: <?= $total_students; ?></div>
    <?php while ($row = $students_by_gender->fetch_assoc()): ?>
        <div class="summary-box"><?= $row['Gender']; ?>: <?= $row['total']; ?></div>
    <?php endwhile; ?>

    <div class="summary-box">Total Teachers: <?= $total_teachers; ?></div>
    <?php while ($row = $teachers_by_gender->fetch_assoc()): ?>
        <div class="summary-box"><?= $row['Gender']; ?>: <?= $row['total']; ?></div>
    <?php endwhile; ?>

    <h3>Resource Requests</h3>
    <?php while ($row = $resource_requests->fetch_assoc()): ?>
        <div class="summary-box"><?= $row['resource_type']; ?> - <?= $row['quantity']; ?> (<?= $row['status']; ?>)</div>
    <?php endwhile; ?>

    <!-- Download Report Button -->
    <a href="generate_report.php?download=true" class="btn">Download PDF Report</a>
    <a href="director_dashboard.php" class="btn back-btn">Back to Dashboard</a>
</div>

</body>
</html>
