<?php
session_start();
require 'dbconfig.php';
 

// Fetch teachers
$query = "SELECT Teacher_id, Full_name FROM teacher";
$result = $conn->query($query);

// Handle evaluation submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teacher_id = $_POST['teacher_id'];
    $evaluation_score = $_POST['evaluation_score'];
    $comments = $_POST['comments'];
    $evaluator_id = $_SESSION['user_id']; // Logged-in supervisor

    // Insert evaluation into teacher_evaluations table
    $insert_query = "INSERT INTO teacher_evaluations (teacher_id, evaluation_score, comments, evaluator_id) 
                     VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("iisi", $teacher_id, $evaluation_score, $comments, $evaluator_id);

    if ($stmt->execute()) {
        // Rank teachers from highest to lowest average score
        $update_rank_query = "
            SET @rank = 0;
            UPDATE teacher AS t
            JOIN (
                SELECT teacher_id, AVG(evaluation_score) AS avg_score,
                @rank := @rank + 1 AS Rank
                FROM teacher_evaluations
                GROUP BY teacher_id
                ORDER BY avg_score DESC
            ) AS avg_scores
            ON t.Teacher_id = avg_scores.teacher_id
            SET t.Rank = avg_scores.Rank;
        ";

        if ($conn->multi_query($update_rank_query)) {
            $message = "Teacher evaluated and ranks updated successfully!";
        } else {
            $message = "Error updating rank.";
        }
    } else {
        $message = "Error evaluating teacher.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluate Teacher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-size: 18px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Evaluate Teacher</h2>

    <?php if (isset($message)) { echo "<div class='message'>$message</div>"; } ?>

    <form method="POST" action="evaluate_teacher.php">
        <label for="teacher_id">Select Teacher</label>
        <select name="teacher_id" id="teacher_id" required>
            <option value="">--Select Teacher--</option>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <option value="<?php echo $row['Teacher_id']; ?>"><?php echo $row['Full_name']; ?></option>
            <?php } ?>
        </select>

        <label for="evaluation_score">Evaluation Score (1-10)</label>
        <input type="number" name="evaluation_score" id="evaluation_score" min="1" max="10" required>

        <label for="comments">Comments</label>
        <textarea name="comments" id="comments" rows="4"></textarea>

        <button type="submit">Submit Evaluation</button>
    </form>
</div>

</body>
</html>
