<?php
session_start();
require 'dbconfig.php';

// Uncomment this section to restrict access to admin users
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php");
//     exit();
// }

// Handle Role Addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_role'])) {
    $role_name = $_POST['role_name'];

    // Prevent duplicate roles
    $check_sql = "SELECT * FROM roles WHERE role_name=?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $role_name);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows == 0) {
        $sql = "INSERT INTO roles (role_name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $role_name);
        $stmt->execute();
    }

    header("Location: add_role.php");
    exit();
}

// Fetch all roles
$sql = "SELECT * FROM roles ORDER BY role_id DESC"; // Use role_id instead of id
$result = $conn->query($sql);

// Check for errors in the query
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Role</title>
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
            width: 90%;
            margin: auto;
        }

        h2 {
            color: #333;
        }

        .form-container {
            margin: 20px auto;
            padding: 20px;
            background: #e9ecef;
            border-radius: 10px;
            width: 50%;
        }

        input, button {
            display: block;
            margin: 10px auto;
            padding: 10px;
            width: 90%;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
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

        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: green;
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
            .form-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Add New Role</h2>

        <!-- Add New Role Form -->
        <div class="form-container">
            <h3>Create Role</h3>
            <form method="POST" action="add_role.php">
                <input type="text" name="role_name" placeholder="Enter Role Name" required>
                <button type="submit" name="add_role">Add Role</button>
            </form>
        </div>

        <!-- Display Available Roles -->
        <div class="table-container">
            <h3>Available Roles</h3>
            <table>
                <tr>
                    <th>Role ID</th>
                    <th>Role Name</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['role_id']}</td>
                            <td>{$row['role_name']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No roles available.</td></tr>";
                }
                ?>
            </table>
        </div>

        <a href="admin_panel.php" class="back-btn">Back to Dashboard</a>
    </div>

</body>
</html>