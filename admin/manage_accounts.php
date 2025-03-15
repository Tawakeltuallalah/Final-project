<?php
session_start();
require 'dbconfig.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_account'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

      
      if (!preg_match('/^\S+\s+\S+/', $name)) {
        echo json_encode(["status" => "error", "message" => "Please enter both first and second names."]);
        exit();
    }



  
    if (!preg_match('/^(09\d{8}|\+2519\d{8})$/', $phone)) {
        echo "<script>alert('Invalid phone number. Must start with 09 or +251'); window.location.href='manage_accounts.php';</script>";
        exit();
    }
  
    if (strlen($password) < 8 || 
        !preg_match('/[A-Z]/', $password) || 
        !preg_match('/[a-z]/', $password) || 
        !preg_match('/[0-9]/', $password) || 
        !preg_match('/[\W]/', $password)) {
        echo "<script>alert('Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.'); window.location.href='manage_accounts.php';</script>";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (Name, Email, Phone, Password, Role, Status) 
            VALUES ('$name', '$email', '$phone', '$password', '$role', 'Active')";
    $conn->query($sql);
    header("Location: admin-panel.php");
    exit();
}


 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_account'])) {
    $user_id = $_POST['user_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $role = $_POST['role'];

    if (!preg_match('/^(09\d{8}|\+2519\d{8})$/', $phone)) {
        echo "<script>alert('Invalid phone number. Must start with 09 or +251'); window.location.href='manage_accounts.php';</script>";
        exit();
    }


    $sql = "UPDATE user SET Name='$name', Email='$email', Phone='$phone', Role='$role' WHERE UserID='$user_id'";
    $conn->query($sql);
    header("Location: admin-panel.php");
    exit();
}
 
 
if (isset($_GET['toggle_status'])) {
    $user_id = $_GET['toggle_status'];
    $current_status = $_GET['status'];

    $new_status = ($current_status === "Active") ? "Inactive" : "Active";
    $sql = "UPDATE user SET Status='$new_status' WHERE UserID='$user_id'";
    $conn->query($sql);
    header("Location: admin-panel.php");
    exit();
}

 
$sql = "SELECT * FROM user ORDER BY UserID DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User Accounts</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
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

        input, select, button {
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
            display: flex;
            
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
            background-color:rgb(79, 68, 23);
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

        .btn-edit, .btn-status {
            padding: 8px 12px;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-edit {
            background: orange;
        }

        .btn-edit:hover {
            background: darkorange;
        }

        .btn-status {
            background: green;
        }

        .btn-status.inactive {
            background: red;
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
        <h2>Manage User Accounts</h2>

        
        <div class="form-container">
            <h3>Add New User</h3>
            <form method="POST" action="manage_accounts.php">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone" placeholder="Phone Number" required pattern="[0-9]{10,15}">
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="">Select Role</option>
       
                    <option value="Manager">Manager</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="School Director">School Director</option>
                    <option value="Teacher">Teacher</option>
                    <option value="Student">Student</option>
                </select>
                <button type="submit" name="add_account"><a href=" admin-panel.php">Create Account</a></button>
            </form>
        </div>

      
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['UserID'] ?></td>
                        <td><?= $row['Name'] ?></td>
                        <td><?= $row['Email'] ?></td>
                        <td><?= $row['Phone'] ?></td>
                        <td><?= $row['Role'] ?></td>
                        <td><?= $row['Status'] ?></td>
                        <td>
                            <button class='btn-edit' onclick="editAccount(<?= $row['UserID'] ?>, '<?= $row['Name'] ?>', '<?= $row['Email'] ?>', '<?= $row['Phone'] ?>', '<?= $row['Role'] ?>')">Update</button>
                            <a href="manage_accounts.php?toggle_status=<?= $row['UserID'] ?>&status=<?= $row['Status'] ?>" class="btn-status <?= ($row['Status'] == 'Inactive') ? 'inactive' : '' ?>">
                                <?= ($row['Status'] == 'Active') ? 'Deactivate' : 'Activate' ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>

         
    </div>
     
     <div id="editModal" class="container" style="display: none;">
        <h3>Update User Account</h3>
        <form method="POST" action="manage_accounts.php">
            <input type="hidden" name="user_id" id="edit_user_id">
            <input type="text" name="name" id="edit_name" required>
            <input type="email" name="email" id="edit_email" required>
            <input type="text" name="phone" id="edit_phone" required>
            <select name="role" id="edit_role" required>
                <option value="Admin">Admin</option>
                <option value="Manager">Manager</option>
                <option value="Supervisor">Supervisor</option>
                <option value="School Director">School Director</option>
                <option value="Teacher">Teacher</option>

                <option value="Student">Student</option>
            </select>
            <button type="submit" name="update_account">Update Account</button>
        </form>
    </div>

    <script>
        
        function editAccount(id, name, email, phone, role) {
            document.getElementById("edit_user_id").value = id;
            document.getElementById("edit_name").value = name;
            document.getElementById("edit_email").value = email;
            document.getElementById("edit_phone").value = phone;
            document.getElementById("edit_role").value = role;
            document.getElementById("editModal").style.display = "block";
        }
    </script>


</body>
</html>
