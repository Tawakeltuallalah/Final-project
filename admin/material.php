<?php
session_start();
require 'dbconfig.php';

 

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['file'])) {
    $material_name = trim($_POST['material_name']);
    $file = $_FILES['file'];
    $school_id = intval($_POST['school_id']);
    $subject = trim($_POST['subject']);

    // Validate the uploaded file
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("<p style='color: red;'>Error: File upload failed.</p>");
    }

    // Check file type (you can adjust this as needed)
    $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    if (!in_array($file['type'], $allowed_types)) {
        die("<p style='color: red;'>Error: Only PDF and Word documents are allowed.</p>");
    }

    // Define the upload directory
    $upload_dir = 'uploads/'; // Make sure this directory exists and is writable
    $file_path = $upload_dir . basename($file['name']);

    // Move the uploaded file to the designated directory
    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        // Insert the material information into the database
        $stmt = $conn->prepare("INSERT INTO material (Material_name, File_path, Uploaded_by, School_id, Subject) VALUES (?, ?, ?, ?, ?)");
        $uploaded_by = $_SESSION['user_id']; // Assuming the user ID is stored in the session
        $stmt->bind_param("ssiss", $material_name, $file_path, $uploaded_by, $school_id, $subject);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Material uploaded successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
        }
    } else {
        die("<p style='color: red;'>Error: Failed to move uploaded file.</p>");
    }
}

// Fetch materials from the database
$query = "SELECT m.Material_id, m.Material_name, m.File_path, s.School_name, m.Subject, m.Upload_date 
          FROM material m 
          JOIN school s ON m.School_id = s.School_id 
          ORDER BY m.Upload_date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Materials</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-4">Upload Educational Material</h2>
        <form action="material.php" method="POST" enctype="multipart/form-data">
            <label for="material_name" class="block mb-2">Material Name:</label>
            <input type="text" name="material_name" class="border rounded p-2 mb-4 w-full" required>

            <label for="file" class="block mb-2">Select File:</label>
            <input type="file" name="file" class="border rounded p-2 mb-4 w-full" required>

            <label for="school_id" class="block mb-2">Select School:</label>
            <select name="school_id" class="border rounded p-2 mb-4 w-full" required>
                <option value="">-- Select School --</option>
                <?php
                // Fetch schools from the database
                $schools = $conn->query("SELECT School_id, School_name FROM school");
                while ($school = $schools->fetch_assoc()) {
                    echo "<option value='{$school['School_id']}'>{$school['School_name']}</option>";
                }
                ?>
            </select>

            <label for="subject" class="block mb-2">Subject:</label>
            <input type="text" name="subject" class="border rounded p-2 mb-4 w-full" required>

            <button type="submit" class="bg-blue-500 text-white rounded p-2">Upload</button>
        </form>

        <h2 class="text-2xl font-bold mt-8 mb-4">Uploaded Materials</h2>
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Material Name</th>
                    <th class="py-2 px-4 border-b">School</th>
                    <th class="py-2 px-4 border-b">Subject</th>
                    <th class="py-2 px-4 border-b">Upload Date</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['Material_name']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['School_name']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['Subject']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['Upload_date']); ?></td>
                            <td class="py-2 px-4 border-b">
                                <a href="<?php echo htmlspecialchars($row['File_path']); ?>" class="text-blue-500 hover:underline" download>Download</a>
                                <!-- Add delete or edit actions as needed -->
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="py-2 px-4 border-b text-center">No materials uploaded.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>