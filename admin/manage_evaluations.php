<?php
session_start();
require 'dbconfig.php';

 

// Function to assign ranks based on performance rating
function getRank($performance) {
    switch ($performance) {
        case 'Excellent': return 1;
        case 'Good': return 2;
        case 'Average': return 3;
        case 'Poor': return 4;
        default: return 3; // Default rank
    }
}

// Handle Evaluation Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_evaluation'])) {
    $evaluation_id = $_POST['evaluation_id'];
    $performance_rating = $_POST['performance_rating'];
    $comments = $_POST['comments'];

    // Assign new rank
    $rank = getRank($performance_rating);

    // Update database
    $stmt = $conn->prepare("UPDATE evaluation SET Performance_rating = ?, Rank = ?, Comments = ? WHERE Evaluation_id = ?");
    $stmt->bind_param("sisi", $performance_rating, $rank, $comments, $evaluation_id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Evaluation Updated Successfully!";
    } else {
        $_SESSION['error'] = "Error Updating Evaluation!";
    }
}

// Handle Evaluation Deletion
if (isset($_GET['delete_id'])) {
    $evaluation_id = $_GET['delete_id'];
    $conn->query("DELETE FROM evaluation WHERE Evaluation_id = $evaluation_id");
    $_SESSION['success'] = "Evaluation Deleted Successfully!";
}

// Fetch evaluations
$evaluations_query = $conn->query("SELECT e.*, s.School_name FROM evaluation e 
                                   JOIN school s ON e.School_id = s.School_id 
                                   ORDER BY e.Rank ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Evaluations</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h2 {
            color: #0056b3;
        }

        .container {
            width: 90%;
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #0056b3;
            color: white;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .edit-btn, .delete-btn {
            padding: 8px;
            border: none;
            color: white;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
        }

        .edit-btn {
            background: #28a745;
        }

        .edit-btn:hover {
            background: #218838;
        }

        .delete-btn {
            background: #dc3545;
        }

        .delete-btn:hover {
            background: #c82333;
        }

        /* Responsive Design */
        @media screen and (max-width: 600px) {
            table {
                font-size: 14px;
            }

            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Manage School Evaluations</h2>

        <!-- Display success/error messages -->
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="message success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="message error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php } ?>

        <table>
            <tr>
                <th>Rank</th>
                <th>School Name</th>
                <th>Performance Rating</th>
                <th>Comments</th>
                <th>Actions</th>
            </tr>

            <?php while ($evaluation = $evaluations_query->fetch_assoc()) { ?>
                <tr>
                    <td><?= $evaluation['Rank']; ?></td>
                    <td><?= $evaluation['School_name']; ?></td>
                    <td><?= $evaluation['Performance_rating']; ?></td>
                    <td><?= $evaluation['Comments']; ?></td>
                    <td class="actions">
                        <button class="edit-btn" onclick="editEvaluation(<?= $evaluation['Evaluation_id']; ?>, '<?= $evaluation['Performance_rating']; ?>', '<?= $evaluation['Comments']; ?>')">Edit</button>
                        <a href="manage_evaluations.php?delete_id=<?= $evaluation['Evaluation_id']; ?>" class="delete-btn">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="container" style="display: none;">
        <h2>Edit Evaluation</h2>
        <form method="POST" action="manage_evaluations.php">
            <input type="hidden" name="evaluation_id" id="edit_evaluation_id">
            <label for="edit_performance_rating">Performance Rating:</label>
            <select id="edit_performance_rating" name="performance_rating">
                <option value="Excellent">Excellent</option>
                <option value="Good">Good</option>
                <option value="Average">Average</option>
                <option value="Poor">Poor</option>
            </select>

            <label for="edit_comments">Comments:</label>
            <textarea id="edit_comments" name="comments" rows="3"></textarea>

            <button type="submit" name="update_evaluation" class="edit-btn">Update</button>
        </form>
    </div>

    <script>
        function editEvaluation(id, performance, comments) {
            document.getElementById("edit_evaluation_id").value = id;
            document.getElementById("edit_performance_rating").value = performance;
            document.getElementById("edit_comments").value = comments;
            document.getElementById("editModal").style.display = "block";
        }
    </script>

</body>
</html>
