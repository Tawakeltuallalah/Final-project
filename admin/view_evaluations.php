<?php
session_start();
require 'dbconfig.php';

// If user is not logged in or not a supervisor, redirect to login
//if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Supervisor') {
   // header("Location: login.php");
   // exit();
//}

 
$evaluations_query = $conn->query("SELECT e.*, s.School_name FROM evaluation e 
                                   JOIN school s ON e.School_id = s.School_id 
                                   ORDER BY e.Rank ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View School Evaluations</title>
    <style>
        
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

        input {
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

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .performance {
            font-weight: bold;
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
    <script>
        function searchSchool() {
            let input = document.getElementById("search").value.toLowerCase();
            let rows = document.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                let schoolName = rows[i].getElementsByTagName("td")[0].textContent.toLowerCase();
                rows[i].style.display = schoolName.includes(input) ? "" : "none";
            }
        }
    </script>
</head>
<body>

    <div class="container">
        <h2>School Evaluations & Rankings</h2>

        <input type="text" id="search" onkeyup="searchSchool()" placeholder="Search by school name...">

        <table>
            <tr>
                <th>Rank</th>
                <th>School Name</th>
                <th>School Type</th>
                <th>Performance Rating</th>
                <th>Comments</th>
            </tr>

            <?php while ($evaluation = $evaluations_query->fetch_assoc()) { ?>
                <tr>
                    <td><?= $evaluation['Rank']; ?></td>
                    <td><?= $evaluation['School_name']; ?></td>
                    <td><?= $evaluation['School_Type']; ?></td>
                    <td class="performance"><?= $evaluation['Performance_rating']; ?></td>
                    <td><?= $evaluation['Comments']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>
