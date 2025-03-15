<?php
session_start();
require 'dbconfig.php';

//if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    //header("Location: login.php");
    //exit();
//}

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $title = $_POST['title'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO resources (title, file_path) VALUES ('$title', '$target_file')";
        $conn->query($sql);
        header("Location: resource_management.php");
        exit();
    } else {
        echo "<script>alert('File upload failed.');</script>";
    }
}

// Handle file deletion
if (isset($_GET['delete_id'])) {
    $resource_id = $_GET['delete_id'];

    // Fetch file path from database
    $sql = "SELECT file_path FROM resources WHERE id='$resource_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $file_path = $row['file_path'];

    // Delete file from directory
    if (file_exists($file_path)) {
        unlink($file_path);
    }

    // Delete record from database
    $sql = "DELETE FROM resources WHERE id='$resource_id'";
    $conn->query($sql);
    header("Location: resource_management.php");
    exit();
}

// Fetch all uploaded resources
$sql = "SELECT * FROM resources ORDER BY uploaded_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Management</title>
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

        .btn-download {
            padding: 8px 12px;
            background: green;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-download:hover {
            background: darkgreen;
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
        <h2>Resource Management</h2>

        <!-- Upload Resource Form -->
        <div class="form-container">
            <h3>Upload New Resource</h3>
            <form method="POST" action="resource_management.php" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Resource Title" required>
                <input type="file" name="file" required>
                <button type="submit">Upload</button>
            </form>
        </div>

        <!-- Display Resources -->
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Uploaded At</th>
                    <th>Actions</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['title']}</td>
                            <td>{$row['uploaded_at']}</td>
                            <td>
                                <a href='{$row['file_path']}' class='btn-download' download>Download</a>
                                <a href='resource_management.php?delete_id={$row['id']}' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this resource?\");'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No resources available.</td></tr>";
                }
                ?>
            </table>
        </div>

        <a href="manager.php" class="back-btn">Back to Dashboard</a>
    </div>

</body>
</html>
