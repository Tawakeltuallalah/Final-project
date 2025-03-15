<?php
session_start();
require 'dbconfig.php';

// Ensure only Manager can access
//if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Manager') {
//    header("Location: login.php");
//    exit();
//}

 
if (isset($_GET['approve_transfer_id'])) {
    $request_id = $_GET['approve_transfer_id'];
    $sql = "UPDATE transfer_requests SET status='Approved' WHERE id='$request_id'";
    $conn->query($sql);
    header("Location: approve_requests.php");
    exit();
}

 
if (isset($_GET['reject_transfer_id'])) {
    $request_id = $_GET['reject_transfer_id'];
    $sql = "UPDATE transfer_requests SET status='Rejected' WHERE id='$request_id'";
    $conn->query($sql);
    header("Location: approve_requests.php");
    exit();
}

 
if (isset($_GET['approve_resource_id'])) {
    $request_id = $_GET['approve_resource_id'];
    $sql = "UPDATE resource_requests SET status='Approved' WHERE id='$request_id'";
    $conn->query($sql);
    header("Location: approve_requests.php");
    exit();
}


if (isset($_GET['reject_resource_id'])) {
    $request_id = $_GET['reject_resource_id'];
    $sql = "UPDATE resource_requests SET status='Rejected' WHERE id='$request_id'";
    $conn->query($sql);
    header("Location: approve_requests.php");
    exit();
}

 
$transfer_sql = "SELECT transfer_requests.*, teacher.Full_name AS teacher_name 
                 FROM transfer_requests 
                 JOIN teacher ON transfer_requests.teacher_id = teacher.Teacher_id 
                 ORDER BY created_at DESC";
$transfer_result = $conn->query($transfer_sql);

 
$resource_sql = "SELECT resource_requests.*, school.School_name AS school_name 
                 FROM resource_requests 
                 JOIN school ON resource_requests.school_id = school.School_id 
                 ORDER BY created_at DESC";
$resource_result = $conn->query($resource_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            width: 90%;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        .table-container {
            margin-top: 20px;
            overflow-x: auto;
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

        .status-pending {
            color: orange;
            font-weight: bold;
        }

        .status-approved {
            color: green;
            font-weight: bold;
        }

        .status-rejected {
            color: red;
            font-weight: bold;
        }

        .btn {
            padding: 8px 12px;
            margin: 2px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
            color: white;
        }

        .btn-approve {
            background: #28a745;
        }

        .btn-approve:hover {
            background: #218838;
        }

        .btn-reject {
            background: red;
        }

        .btn-reject:hover {
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
        <h2>Manage Transfer & Resource Requests</h2>

       
        <h3>Teacher Transfer Requests</h3>
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Teacher Name</th>
                    <th>Current School</th>
                    <th>Requested School</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php
                if ($transfer_result->num_rows > 0) {
                    while ($row = $transfer_result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['teacher_name']}</td>
                            <td>{$row['current_school']}</td>
                            <td>{$row['requested_school']}</td>
                            <td>{$row['reason']}</td>
                            <td class='" . 
                            ($row['status'] === 'Pending' ? "status-pending" : 
                            ($row['status'] === 'Approved' ? "status-approved" : "status-rejected")) . 
                            "'>{$row['status']}</td>
                            <td>";
                        if ($row['status'] === 'Pending') {
                            echo "<a href='approve_requests.php?approve_transfer_id={$row['id']}' class='btn btn-approve'>Approve</a>
                                  <a href='approve_requests.php?reject_transfer_id={$row['id']}' class='btn btn-reject'>Reject</a>";
                        }
                        echo "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No transfer requests available.</td></tr>";
                }
                ?>
            </table>
        </div>

 
        <h3>School Resource Requests</h3>
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>School Name</th>
                    <th>Resource Type</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php
                if ($resource_result->num_rows > 0) {
                    while ($row = $resource_result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['school_name']}</td>
                            <td>{$row['resource_type']}</td>
                            <td>{$row['quantity']}</td>
                            <td class='" . 
                            ($row['status'] === 'Pending' ? "status-pending" : 
                            ($row['status'] === 'Approved' ? "status-approved" : "status-rejected")) . 
                            "'>{$row['status']}</td>
                            <td>";
                        if ($row['status'] === 'Pending') {
                            echo "<a href='approve_requests.php?approve_resource_id={$row['id']}' class='btn btn-approve'>Approve</a>
                                  <a href='approve_requests.php?reject_resource_id={$row['id']}' class='btn btn-reject'>Reject</a>";
                        }
                        echo "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No resource requests available.</td></tr>";
                }
                ?>
            </table>
        </div>

        <a href="manager.php" class="back-btn">Back to Dashboard</a>
    </div>

</body>
</html>
