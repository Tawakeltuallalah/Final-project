<?php
session_start();
require 'dbconfig.php';

// Ensure school_id exists in session
if (!isset($_SESSION['school_id'])) {
    die("Error: School ID is not set in session. Please log in again.");
}

$school_id = $_SESSION['school_id'];

// Fetch school data for the logged-in school
$query = "SELECT * FROM school WHERE School_id = $school_id";
$result = $conn->query($query);

if (!$result) {
    die("Error: Could not fetch school data. " . $conn->error);
}

$school_data = $result->fetch_assoc();

// Handle update operation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_school'])) {
    $school_name = $_POST['school_name'];
    $school_type = $_POST['school_type'];
    $location = $_POST['location'];

    $update_query = "UPDATE school SET School_name = ?, School_type = ?, Location = ? WHERE School_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssi", $school_name, $school_type, $location, $school_id);

    if ($stmt->execute()) {
        $message = "<p class='success'>School data updated successfully!</p>";
    } else {
        $message = "<p class='error'>Failed to update school data. Please try again.</p>";
    }
}

// Handle delete operation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_school'])) {
    $delete_query = "DELETE FROM school WHERE School_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $school_id);

    if ($stmt->execute()) {
        $message = "<p class='success'>School data deleted successfully!</p>";
    } else {
        $message = "<p class='error'>Failed to delete school data. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage School Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #1e3c72;
            font-size: 22px;
            margin-bottom: 15px;
        }

        .summary-box {
            background: #e3f2fd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: #ffcc00;
            color: #1e3c72;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        .btn-submit:hover {
            background: #e6b800;
            transform: scale(1.05);
        }

        .success {
            background: #28a745;
            color: white;
            padding: 10px;
            text-align: center;
            margin-bottom: 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .error {
            background: #dc3545;
            color: white;
            padding: 10px;
            text-align: center;
            margin-bottom: 10px;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Manage School Data</h2>

        <!-- Success/Error Message -->
        <?= isset($message) ? $message : ''; ?>

        <!-- School Data Form -->
        <form action="" method="POST">
            <div class="summary-box">
                <label for="school_name">School Name:</label>
                <input type="text" name="school_name" id="school_name" value="<?= $school_data['School_name']; ?>" required />
            </div>
            <div class="summary-box">
                <label for="school_type">School Type:</label>
                <select name="school_type" id="school_type" required>
                    <option value="Pre-primary" <?= $school_data['School_type'] === 'Pre-primary' ? 'selected' : ''; ?>>Pre-primary</option>
                    <option value="Primary" <?= $school_data['School_type'] === 'Primary' ? 'selected' : ''; ?>>Primary</option>
                    <option value="Secondary" <?= $school_data['School_type'] === 'Secondary' ? 'selected' : ''; ?>>Secondary</option>
                </select>
            </div>
            <div class="summary-box">
                <label for="location">Location:</label>
                <input type="text" name="location" id="location" value="<?= $school_data['Location']; ?>" required />
            </div>

            <!-- Update School Data -->
            <button type="submit" name="update_school" class="btn-submit">Update School Data</button>
        </form>

        <!-- Delete School Data -->
        <form action="" method="POST">
            <button type="submit" name="delete_school" class="btn-submit" style="background: #dc3545; margin-top: 20px;">Delete School Data</button>
        </form>
    </div>

</body>
</html>
