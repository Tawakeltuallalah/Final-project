<?php
session_start();
require 'dbconfig.php';
 

// Check if school_id is set in session
if (!isset($_SESSION['school_id'])) {
    die("Error: School ID is not set in session. Please log in again.");
}

// Get the School ID from session
$school_id = $_SESSION['school_id'];

// Handle Resource Request Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_request'])) {
    $resource_type = $_POST['resource_type'];
    $quantity = intval($_POST['quantity']);
    $status = "Pending"; // Default status

    // Insert request into the database
    $stmt = $conn->prepare("INSERT INTO resource_requests (school_id, resource_type, quantity, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $school_id, $resource_type, $quantity, $status);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Resource request submitted successfully!";
    } else {
        $_SESSION['error'] = "Error submitting request. Try again!";
    }
}

// Fetch all previous resource requests for this school
$requests = $conn->query("SELECT * FROM resource_requests WHERE school_id = $school_id ORDER BY requested_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Resources</title>
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

        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
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

        .message {
            text-align: center;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .success {
            background: #28a745;
            color: white;
        }

        .error {
            background: #dc3545;
            color: white;
        }

        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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

        .status-pending {
            color: orange;
            font-weight: bold;
        }

        .status-approved {
            color: green;
            font-weight: bold;
        }

        .status-rejected {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Request Resources</h2>

        <!-- Display Success/Error Messages -->
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="message success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="message error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php } ?>

        <!-- Resource Request Form -->
        <form action="" method="POST">
            <label for="resource_type">Select Resource Type:</label>
            <select id="resource_type" name="resource_type" required>
                <option value="Textbooks">📚 Textbooks</option>
                <option value="Lab Equipment">🔬 Lab Equipment</option>
                <option value="Stationery">✏️ Stationery</option>
                <option value="Furniture">🪑 Furniture</option>
            </select>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required min="1">

            <button type="submit" name="submit_request" class="btn-submit">Submit Request</button>
        </form>

        <!-- Previous Requests -->
        <h3>Previous Requests</h3>
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Resource Type</th>
                    <th>Quantity</th>
                    <th>Status</th>
                </tr>
                <?php
                if ($requests->num_rows > 0) {
                    while ($row = $requests->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['resource_type']}</td>
                            <td>{$row['quantity']}</td>
                            <td class='" . 
                            ($row['status'] === 'Pending' ? "status-pending" : 
                            ($row['status'] === 'Approved' ? "status-approved" : "status-rejected")) . 
                            "'>{$row['status']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No requests submitted yet.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

</body>
</html>
