<?php
session_start();
require 'dbconfig.php';
 

 
$schools_query = "SELECT * FROM school";
$schools_result = $conn->query($schools_query);

 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $school_id = $_POST['school_id'];
    $evaluation = $_POST['evaluation'];
    $rating = $_POST['rating'];
    $evaluator_name = $_SESSION['username']; 

    $sql = "INSERT INTO school_evaluations (school_id, evaluation, rating, evaluator_name) 
            VALUES ('$school_id', '$evaluation', '$rating', '$evaluator_name')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Evaluation submitted successfully!'); window.location.href='supervisor_panel.php';</script>";
    } else {
        echo "<script>alert('Error submitting evaluation. Try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluate School</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            padding-top: 50px;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: auto;
        }

        select, textarea, input, button {
            display: block;
            margin: 10px auto;
            padding: 10px;
            width: 90%;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        textarea {
            height: 100px;
        }

        button {
            background: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        button:hover {
            background: #0056b3;
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
        <h2>Evaluate a School</h2>
        <form method="POST" action="evaluate_school.php">
            <select name="school_id" required>
                <option value="">Select a School</option>
                <?php
                while ($row = $schools_result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']} - {$row['location']}</option>";
                }
                ?>
            </select>
            <textarea name="evaluation" placeholder="Enter your evaluation" required></textarea>
            <label for="rating"><b>Rating (1-5 Stars):</b></label>
            <input type="number" name="rating" min="1" max="5" required>
            <button type="submit">Submit Evaluation</button>
        </form>
        <a href="supervisor.php" class="back-btn">Back to Dashboard</a>
    </div>

</body>
</html>
