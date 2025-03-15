<?php
session_start();
require 'dbconfig.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all users from the database
$sql = "SELECT id, name, email, role FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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

        .card-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .card {
            background: #ffffff;
            width: 250px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: 15px;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            margin: 0;
            color: #007bff;
        }

        .card p {
            color: #555;
            font-size: 14px;
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
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .btn {
            padding: 8px 12px;
            margin: 2px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
            color: white;
        }

        .btn-edit {
            background: #28a745;
        }

        .btn-delete {
            background: #dc3545;
        }

        .btn-role {
            background: #ffc107;
        }

        .logout-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            width: 100px;
            background: red;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
        }

        .logout-btn:hover {
            background: darkred;
        }
    </style>
</head>
<body>

    <div class="navbar">Admin Dashboard</div>

    <div class="container">
        <h2>Welcome, Admin!</h2>
        <p>Manage user accounts, assign roles, and control system settings.</p>

        <div class="card-container">
            <div class="card">
                <h3>Manage Accounts</h3>
                <p>Create, update, delete, activate, or deactivate accounts.</p>
                <a href="manage_users.php">Go</a>
            </div>

            <div class="card">
                <h3>Change Role</h3>
                <p>Modify user roles and permissions.</p>
                <a href="change_role.php">Go</a>
            </div>

            <div class="card">
                <h3>Assign Role</h3>
                <p>Assign specific roles to users.</p>
                <a href="assign_role.php">Go</a>
            </div>

            <div class="card">
                <h3>View Data</h3>
                <p>View registered users.</p>
            </div>
        </div>

        <div class="table-container">
            <h3>Registered Users</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['role']}</td>
                        <td>
                            <a href='edit_user.php?id={$row['id']}' class='btn btn-edit'>Edit</a>
                            <a href='delete_user.php?id={$row['id']}' class='btn btn-delete'>Delete</a>
                            <a href='change_role.php?id={$row['id']}' class='btn btn-role'>Change Role</a>
                        </td>
                    </tr>";
                }
                ?>
            </table>
        </div>

        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

</body>
</html>
