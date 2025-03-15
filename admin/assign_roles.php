<?php
session_start();
require 'dbconfig.php';

// Debugging: Check database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Success message initialization
$success_message = null;
$error_message = null;

// Update role logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['role'];

    $sql = "UPDATE user SET Role='$new_role' WHERE UserID='$user_id'";
    if ($conn->query($sql) === TRUE) {
        // Set success message
        $success_message = "Role updated successfully!";
        header("Location: assign_roles.php"); // Reload the page to reflect changes
        exit();
    } else {
        $error_message = "Error updating role: " . $conn->error;
    }
}

// Fetch users
$sql = "SELECT UserID, Name, Email, Role FROM user";
$result = $conn->query($sql);
if (!$result) {
    die("Query Failed: " . $conn->error);
}

$selected_user = null;
if (isset($_GET['edit'])) {
    // Show the selected user info to edit
    $user_id = $_GET['edit'];
    $user_sql = "SELECT UserID, Name, Role FROM user WHERE UserID = '$user_id'";
    $user_result = $conn->query($user_sql);
    if ($user_result->num_rows > 0) {
        $selected_user = $user_result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Roles</title>
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

        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: green;
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

        .btn-edit {
            padding: 8px 12px;
            background: orange;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-edit:hover {
            background: darkorange;
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

        /* Style for the Update form */
        .update-form {
            margin-top: 20px;
            text-align: left;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        select, input[type="submit"] {
            padding: 8px;
            margin-top: 5px;
            width: 100%;
        }

        /* Style for the success/error message */
        .message {
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .success-message {
            background-color: #28a745;
            color: white;
        }

        .error-message {
            background-color: #dc3545;
            color: white;
        }

       /* Button Styles for Update and Cancel */
.btn-update, .btn-cancel {
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    width: 48%; /* Ensures both buttons fit side by side */
    display: inline-block; /* Aligns buttons horizontally */
    margin-right: 6%; /* Adds a small gap between the two buttons */
    box-sizing: border-box; /* Prevents overflow */
}

.btn-update:hover {
    background-color: #0056b3;
}

.btn-cancel {
    background-color: #dc3545;
}

.btn-cancel:hover {
    background-color: #c82333;
}
    </style>
</head>
<body>

    <div class="container">
        <h2>Assign or Change Roles</h2>

        <!-- Display success or error messages -->
        <?php if (isset($success_message)): ?>
            <div class="message success-message">
                <strong><?php echo $success_message; ?></strong>
            </div>
        <?php elseif (isset($error_message)): ?>
            <div class="message error-message">
                <strong><?php echo $error_message; ?></strong>
            </div>
        <?php endif; ?>

        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Current Role</th>
                    <th>Change Role</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['UserID']}</td>
                            <td>{$row['Name']}</td>
                            <td>{$row['Email']}</td>
                            <td>{$row['Role']}</td>
                            <td>
                                <a href='assign_roles.php?edit={$row['UserID']}' class='btn-edit'>Change Role</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No users available.</td></tr>";
                }
                ?>
            </table>
        </div>

        <!-- Show the update form when a user is selected for editing -->
        <?php if ($selected_user): ?>
        <div class="update-form">
            <h3>Update User Role</h3>

            <form method="POST" action="assign_roles.php">
                <input type="hidden" name="user_id" value="<?php echo $selected_user['UserID']; ?>">
                <p><strong>Name:</strong> <?php echo $selected_user['Name']; ?></p>
                <label for="role">Select New Role:</label>
                <select name="role" required>
                    <option value="Admin" <?php echo ($selected_user['Role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="Manager" <?php echo ($selected_user['Role'] == 'Manager') ? 'selected' : ''; ?>>Manager</option>
                    <option value="Teacher" <?php echo ($selected_user['Role'] == 'Teacher') ? 'selected' : ''; ?>>Teacher</option>
                    <option value="School Director" <?php echo ($selected_user['Role'] == 'School Director') ? 'selected' : ''; ?>>School Director</option>
                </select>
                <br><br>
                <input type="submit" name="update_role" class="btn-update" value="Update Role">
                <a href="assign_roles.php" class="btn-cancel">Cancel</a>
            </form>
        </div>
        <?php endif; ?>

        <a href="admin-panel.php" class="back-btn">Back to Dashboard</a>
    </div>

</body>
</html>
