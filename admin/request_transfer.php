<?php
session_start();
require 'dbconfig.php';

//if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    //header("Location: login.php");
    //exit();
//}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacher_id = $_SESSION['user_id'];
    $current_school = $_POST['current_school'];
    $requested_school = $_POST['requested_school'];
    $reason = $_POST['reason'];

    $sql = "INSERT INTO transfer_requests (teacher_id, current_school, requested_school, reason) 
            VALUES ('$teacher_id', '$current_school', '$requested_school', '$reason')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Transfer request submitted successfully!'); window.location.href='teacher_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error submitting request. Try again.');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Transfer</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #1e3c72, #2a5298);
            margin: 0;
            padding: 0;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Form Container */
        .container {
            background: rgba(255, 255, 255, 0.15);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            text-align: center;
            width: 400px;
            animation: fadeIn 0.5s ease-in-out;
        }

        h2 {
            font-size: 28px;
            color: #fff;
            margin-bottom: 15px;
        }

        /* Input Fields */
        input, textarea, button {
            display: block;
            margin: 10px auto;
            padding: 12px;
            width: 90%;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            outline: none;
        }

        input, textarea {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        input::placeholder, textarea::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        textarea {
            height: 120px;
        }

        
        button {
            background: #007bff;
            color: white;
            padding: 0px;
            margin-top: 0px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease-in-out, transform 0.2s;
        }

        button:hover {
            background: #0056b3;
            transform: scale(1.05);
        }

      
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 18px;
            background: #28a745;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.3s ease-in-out, transform 0.2s;
        }

        .back-btn:hover {
            background: #218838;
            transform: scale(1.05);
        }

      
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

       
        @media screen and (max-width: 480px) {
            .container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Request Transfer</h2>
        <form method="POST" action="request_transfer.php">
            <input type="text" name="current_school" placeholder="Current School" required>
            <input type="text" name="requested_school" placeholder="Requested School" required>
            <textarea name="reason" placeholder="Reason for transfer" required></textarea>
            <button type="submit">Submit Request</button>
        </form>
        <a href="teacher.php" class="back-btn">Back to Dashboard</a>
    </div>

</body>
</html>
