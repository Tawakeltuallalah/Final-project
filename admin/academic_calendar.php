<?php
session_start();
require 'dbconfig.php';

//if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
   // header("Location: login.php");
    //exit();
//}

// Handle event addition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_title = $_POST['event_title'];
    $event_date = $_POST['event_date'];
    $description = $_POST['description'];

    $sql = "INSERT INTO academic_calendar (event_title, event_date, description) 
            VALUES ('$event_title', '$event_date', '$description')";
    $conn->query($sql);
    header("Location: academic_calendar.php");
    exit();
}

// Handle event deletionphp -v

if (isset($_GET['delete_id'])) {
    $event_id = $_GET['delete_id'];
    $sql = "DELETE FROM academic_calendar WHERE id='$event_id'";
    $conn->query($sql);
    header("Location: academic_calendar.php");
    exit();
}

// Fetch all academic events
$sql = "SELECT * FROM academic_calendar ORDER BY event_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Calendar</title>
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

        .form-container {
            margin: 20px auto;
            padding: 20px;
            background: #e9ecef;
            border-radius: 10px;
            width: 50%;
        }

        input, textarea, button {
            display: block;
            margin: 10px auto;
            padding: 10px;
            width: 90%;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background: #007bff;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }

        button:hover {
            background: #0056b3;
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

        .btn-delete {
            padding: 8px 12px;
            background: red;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-delete:hover {
            background: darkred;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background 0.3s ease-in-out;
        }

        .back-btn:hover {
            background: #218838;
        }

        @media screen and (max-width: 768px) {
            .form-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Academic Calendar</h2>

        <!-- Add Event Form -->
        <div class="form-container">
            <h3>Add New Event</h3>
            <form method="POST" action="academic_calendar.php">
                <input type="text" name="event_title" placeholder="Event Title" required>
                <input type="date" name="event_date" required>
                <textarea name="description" placeholder="Event Description" required></textarea>
                <button type="submit">Add Event</button>
            </form>
        </div>

        <!-- Display Events -->
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Event Title</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['event_title']}</td>
                            <td>{$row['event_date']}</td>
                            <td>{$row['description']}</td>
                            <td>
                                <a href='academic_calendar.php?delete_id={$row['id']}' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this event?\");'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No academic events available.</td></tr>";
                }
                ?>
            </table>
        </div>

        <a href="manager.php" class="back-btn">Back to Dashboard</a>
    </div>

</body>
</html>
