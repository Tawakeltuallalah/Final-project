<?php
session_start();
require 'dbconfig.php';

//if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
   // header("Location: login.php");
   // exit();
//}

 
$total_users_query = "SELECT COUNT(*) AS total_users FROM user";
$total_users_result = $conn->query($total_users_query);
$total_users = $total_users_result->fetch_assoc()['total_users'];

 
$active_users_query = "SELECT COUNT(*) AS active_users FROM user WHERE status='Active'";
$active_users_result = $conn->query($active_users_query);
$active_users = $active_users_result->fetch_assoc()['active_users'];

 
$total_schools_query = "SELECT COUNT(*) AS total_schools FROM school";
$total_schools_result = $conn->query($total_schools_query);
$total_schools = $total_schools_result->fetch_assoc()['total_schools'];

 
$total_evaluations_query = "SELECT COUNT(*) AS total_evaluations FROM evaluation";
$total_evaluations_result = $conn->query($total_evaluations_query);
$total_evaluations = $total_evaluations_result->fetch_assoc()['total_evaluations'];

 
$roles_query = "SELECT role, COUNT(*) AS count FROM user GROUP BY role";
$roles_result = $conn->query($roles_query);
$roles_data = [];
while ($row = $roles_result->fetch_assoc()) {
    $roles_data[] = $row;
}

// Fetch Recent User Activity
$activity_query = "SELECT id, name, role, status, created_at FROM user ORDER BY created_at DESC LIMIT 10";
$activity_result = $conn->query($activity_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View System Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            padding-top: 5px;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            margin: auto;
            
        }

        h2 {
            color: #333;
        }

        .dashboard {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 5px;
            
        }

        .card {
            background: #e9ecef;
            padding: 20px;
            border-radius: 10px;
            width: 250px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
            background-color: #a9a9a9;
            margin-top: 5px;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #DEB887;
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
            .container {
                width: 95%;
            }

            .dashboard {
                flex-direction: column;
                align-items: center;
            }

            .card {
                width: 90%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>System Overview</h2>

        
        <div class="dashboard">
            <div class="card">
                <h3>Total Users</h3>
                <p><?= $total_users ?></p>
            </div>
            <div class="card">
                <h3>Active Users</h3>
                <p><?= $active_users ?></p>
            </div>
            <div class="card">
                <h3>Total Schools</h3>
                <p><?= $total_schools ?></p>
            </div>
            <div class="card">
                <h3>Evaluations</h3>
                <p><?= $total_evaluations ?></p>
            </div>
        </div>

  
        <div class="table-container">
            <h3>User Role Distribution</h3>
            <table>
                <tr>
                    <th>Role</th>
                    <th>Number of Users</th>
                </tr>
                <?php
                if (!empty($roles_data)) {
                    foreach ($roles_data as $role) {
                        echo "<tr>
                            <td>{$role['role']}</td>
                            <td>{$role['count']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No data available.</td></tr>";
                }
                ?>
            </table>
        </div>

         
        <a href="admin_panel.php" class="back-btn">Back to Dashboard</a>
    </div>

</body>
</html>
