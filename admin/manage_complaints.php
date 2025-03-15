<?php
session_start();
require 'dbconfig.php';

// Ensure only Manager can access
//if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Manager') {
//    header("Location: login.php");
//    exit();
//}

// Handle status update (Resolve Complaint)
if (isset($_GET['resolve_id'])) {
    $complaint_id = $_GET['resolve_id'];
    $sql = "UPDATE complaint SET status='Resolved' WHERE id='$complaint_id'";
    $conn->query($sql);
    header("Location: manage_complaints.php");
    exit();
}

 
if (isset($_GET['delete_id'])) {
    $complaint_id = $_GET['delete_id'];
    $sql = "DELETE FROM complaint WHERE id='$complaint_id'";
    $conn->query($sql);
    header("Location: manage_complaints.php");
    exit();
}

 
$sql = "
    SELECT c.id, c.subject, c.message, c.status, c.created_at, 
           'Teacher' AS sender_type, t.Full_name AS sender_name
    FROM complaint c
    JOIN teacher t ON c.teacher_id = t.Teacher_id 
    UNION
    SELECT c.id, c.subject, c.message, c.status, c.created_at, 
           'School Director' AS sender_type, sd.Full_name AS sender_name
    FROM complaint c
    JOIN school_director sd ON c.director_id = sd.Director_id
    ORDER BY created_at DESC";
    
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Complaints</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
        }

        .container {
            width: 90%;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
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
            color: red;
            font-weight: bold;
        }

        .status-resolved {
            color: green;
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

        .btn-resolve {
            background: #28a745;
        }

        .btn-resolve:hover {
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
        <h2>Manage Complaints</h2>
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Sender</th>
                    <th>Role</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['sender_name']}</td>
                            <td>{$row['sender_type']}</td>
                            <td>{$row['subject']}</td>
                            <td>{$row['message']}</td>
                            <td class='" . ($row['status'] === 'Pending' ? "status-pending" : "status-resolved") . "'>{$row['status']}</td>
                            <td>
                                <a href='manage_complaints.php?resolve_id={$row['id']}' class='btn btn-resolve'>Resolve</a>
                                <a href='manage_complaints.php?delete_id={$row['id']}' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this complaint?\");'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No complaints available.</td></tr>";
                }
                ?>
            </table>
        </div>
         
    </div>

</body>
</html>
