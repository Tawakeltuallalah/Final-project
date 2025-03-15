<?php
session_start();
require 'dbconfig.php';  

 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacher_name = $_POST['teacher_name'];
    $current_school = $_POST['current_school'];
    $preferred_school = $_POST['preferred_school'];
    $reason = $_POST['reason'];
    $status = "Pending";  

    if (!empty($teacher_name) && !empty($current_school) && !empty($preferred_school) && !empty($reason)) {
        $stmt = $conn->prepare("INSERT INTO transfer_requests (teacher_name, current_school, preferred_school, reason, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $teacher_name, $current_school, $preferred_school, $reason, $status);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Transfer request submitted successfully!";
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again.";
        }
    } else {
        $_SESSION['error'] = "All fields are required!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Request Form</title>
    <style>
 
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #1e3c72, #2a5298);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-top: 20px;
            
        }

        .container {
            width: 700px;
            max-width: 500px;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin: auto;
            
        }

        h2 {
            text-align: center;
            color: #1e3c72;
            font-size: 22px;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #333;
            font-size: 16px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 2px solid #1e3c72;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s ease-in-out;
        }

        input:focus, textarea:focus {
            border-color: #ffcc00;
        }

        textarea {
            resize: none;
        }

        button {
            width: 100%;
            padding: 0px;
            margin-top: 0px;
            background: #ffcc00;
            color: #1e3c72;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        button:hover {
            background:rgb(0, 215, 230);
        
        }

        .message {
            text-align: center;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        .success {
            background: #28a745;
            color: white;
        }

        .error {
            background: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Teacher Transfer Request</h2>

     
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="message success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="message error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php } ?>

       
        <form action="" method="POST">
            <label for="teacher_name">Teacher Name:</label>
            <input type="text" id="teacher_name" name="teacher_name" required>

            <label for="current_school">Current School:</label>
            <input type="text" id="current_school" name="current_school" required>

            <label for="preferred_school">Preferred School:</label>
            <input type="text" id="preferred_school" name="preferred_school" required>

            <label for="reason">Reason for Transfer:</label>
            <textarea id="reason" name="reason" rows="4" required></textarea>

            <button type="submit">Submit Request</button>
        </form>
    </div>

</body>
</html>
