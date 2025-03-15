<?php
session_start();
require 'dbconfig.php';

//if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    //header("Location: login.php");
   // exit();
//}

// Handle Add School
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_school'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $principal = $_POST['principal'];
    $contact_info = $_POST['contact_info'];

    $sql = "INSERT INTO schools (name, location, principal, contact_info) 
            VALUES ('$name', '$location', '$principal', '$contact_info')";
    $conn->query($sql);
    header("Location: record_data.php");
    exit();
}

// Handle Delete School
if (isset($_GET['delete_id'])) {
    $school_id = $_GET['delete_id'];
    $sql = "DELETE FROM schools WHERE id='$school_id'";
    $conn->query($sql);
    header("Location: record_data.php");
    exit();
}

// Fetch all school records
$sql = "SELECT * FROM schools ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record School Data</title>
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

        input, button {
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
        <h2>Record School Data</h2>

        <!-- Add School Form -->
        <div class="form-container">
            <h3>Add New School</h3>
            <form method="POST" action="record_data.php">
                <input type="text" name="name" placeholder="School Name" required>
                <input type="text" name="location" placeholder="Location" required>
                <input type="text" name="principal" placeholder="Principal Name" required>
                <input type="text" name="contact_info" placeholder="Contact Information" required>
                <button type="submit" name="add_school">Add School</button>
            </form>
        </div>

        <!-- Display School Records -->
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>School Name</th>
                    <th>Location</th>
                    <th>Principal</th>
                    <th>Contact Info</th>
                    <th>Actions</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['location']}</td>
                            <td>{$row['principal']}</td>
                            <td>{$row['contact_info']}</td>
                            <td>
                                <a href='record_data.php?delete_id={$row['id']}' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this school record?\");'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No school records available.</td></tr>";
                }
                ?>
            </table>
        </div>

        <a href="manager.php" class="back-btn">Back to Dashboard</a>
    </div>

</body>
</html>
