<?php
session_start();
require 'dbconfig.php';

//if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    //header("Location: login.php");
    //exit();
//}

 
$sql = "SELECT * FROM material ORDER BY uploaded_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Materials</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding-top: 25px;
        }

        .container {
            background: linear-gradient(to right,rgb(27, 39, 63), #2a5298);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 700px;
            margin: auto;
        }

        .material-list {
            margin-top: 20px;
        }

        .material-item {
            background: #ffffff;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
        }

        .download-btn {
            padding: 8px 12px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .download-btn:hover {
            background:rgb(0, 179, 54);
        }

        .back-btn {
            display: block;
            margin-top: 20px;
            padding: 10px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Download Teaching Materials</h2>
        <div class="material-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='material-item'>
                            <p><strong>{$row['title']}</strong></p>
                            <a href='{$row['file_path']}' class='download-btn' download>Download</a>
                          </div>";
                }
            } else {
                echo "<p>No materials available.</p>";
            }
            ?>
        </div>
        <a href="teacher.php" class="back-btn">Back to Dashboard</a>
    </div>

</body>
</html>
