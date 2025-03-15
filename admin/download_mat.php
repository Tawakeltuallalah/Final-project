<?php
session_start();
require 'dbconfig.php';

// Fetch materials from the database
$query = "SELECT Material_id, Material_name, File_path FROM material";  
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error); // Debugging line
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Materials</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-4">Download Study Materials</h2>
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="py-2 text-green-500 px-4 border-b">Material Name</th>
                    <th class="py-2 text-green-500 px-4 border-b">Download</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="py-2 text-blue-500 px-4 border-b"><?php echo htmlspecialchars($row['Material_name']); ?></td>
                            <td class="py-2 px-4 border-b">
                                <a href="<?php echo htmlspecialchars($row['File_path']); ?>" class="text-blue-500 hover:underline" download>Download</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="py-2 px-4 border-b text-center">No materials available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
