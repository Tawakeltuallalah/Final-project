<?php
session_start();
require 'dbconfig.php';

//if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    //header("Location: login.php");
    //exit();
//}

 
$sql = "SELECT * FROM announcements ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: #007bff;
            padding: 15px;
            color: white;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .container {
            width: 80%;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .announcement {
            background: #ffffff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .announcement h3 {
            margin: 0;
            color: #007bff;
        }

        .announcement p {
            color: #555;
            font-size: 14px;
        }

        .date {
            font-size: 12px;
            color: gray;
        }

        .back-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            width: 120px;
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>

    <div class="navbar">Announcements</div>

    <div class="container">
        <h2>Latest Announcements</h2>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='announcement'>
                        <h3>{$row['title']}</h3>
                        <p>{$row['content']}</p>
                        <p class='date'>Posted on: {$row['created_at']}</p>
                      </div>";
            }
        } else {
            echo "<p>No announcements available.</p>";
        }
        ?>
        <a href="teacher.php" class="back-btn">Back to Dashboard</a>
    </div>

</body>
</html>
