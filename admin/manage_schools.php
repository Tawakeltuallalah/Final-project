<?php
session_start();
require 'dbconfig.php'; // Include database connection

// Ensure only Manager can access
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Manager') {
//    header("Location: login.php");
//    exit();
// }

// Add a new school
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_school'])) {
    $school_code = trim($_POST['school_code']);
    $name = trim($_POST['name']);
    $location = trim($_POST['location']);
    $school_type = trim($_POST['school_type']);
    $school_category = trim($_POST['school_category']);

    // Validation
    if (empty($school_code) || empty($name) || empty($location) || empty($school_type) || empty($school_category)) {
        echo "All fields are required.";
    } elseif (!preg_match('/^\d{2,4}$/', $school_code)) {
        echo "School Code must be a number between 2 to 4 digits.";
    } elseif (!in_array($school_category, ['Private', 'Government'])) {
        echo "Invalid School Category.";
    } else {
        $sql = "INSERT INTO school (School_code, School_name, Location, School_type, School_category) 
                VALUES ('$school_code', '$name', '$location', '$school_type', '$school_category')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_message'] = "School registered successfully!";
            header("Location: manage_schools.php");
            exit();
        } else {
            echo "Error: " . $conn->error;  
        }
    }
}

// Update school details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_school'])) {
    $id = $_POST['id'];
    $school_code = trim($_POST['school_code']);
    $name = trim($_POST['name']);
    $location = trim($_POST['location']);
    $school_type = trim($_POST['school_type']);
    $school_category = trim($_POST['school_category']);

    $sql = "UPDATE school 
            SET School_code='$school_code', School_name='$name', Location='$location', 
                School_type='$school_type', School_category='$school_category' 
            WHERE School_id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_schools.php");
        exit();
    } else {
        echo "Error: " . $conn->error;  
    }
}

// Delete a school
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM school WHERE School_id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: manage_schools.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filter_category = isset($_GET['school_category']) ? trim($_GET['school_category']) : '';

$sql = "SELECT * FROM school WHERE 1";

// Apply search filter
if (!empty($search)) {
    $sql .= " AND (School_name LIKE '%$search%' OR Location LIKE '%$search%' OR School_code LIKE '%$search%')";
}

// Apply category filter
if (!empty($filter_category)) {
    $sql .= " AND School_category = '$filter_category'";
}

$sql .= " ORDER BY School_id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Schools</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <header class="bg-teal-700 text-white py-4">
        <div class="container mx-auto flex justify-between items-center px-6">
            <h1 class="text-xl font-bold">Manage Schools</h1>
            <a href="manager.php" class="bg-gray-300 text-black px-4 py-2 rounded">Back to Dashboard</a>
        </div>
    </header>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="container mx-auto mt-4 bg-green-500 text-white p-4 rounded-lg">
            <?php
            echo $_SESSION['success_message'];
            unset($_SESSION['success_message']);  
            ?>
        </div>
    <?php endif; ?>

    <section class="container mx-auto mt-6 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Register a New School</h2>
        <form method="POST" action="manage_schools.php" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="school_code" placeholder="School Code (2-4 digits)" required pattern="\d{2,4}" title="Enter 2 to 4 digit number" class="p-2 border rounded">
            <input type="text" name="name" placeholder="School Name" required class="p-2 border rounded">
            <input type="text" name="location" placeholder="Location" required class="p-2 border rounded">
            <select name="school_type" required class="p-2 border rounded">
                <option value="">Select School Type</option>
                <option value="pre-primary">Pre-primary</option>
                <option value="primary">Primary</option>
                <option value="secondary">Secondary</option>
            </select>
            <select name="school_category" required class="p-2 border rounded">
                <option value="">Select Category</option>
                <option value="Private">Private</option>
                <option value="Government">Government</option>
            </select>
            <button type="submit" name="add_school" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                Register School
            </button>
        </form>
    </section>
    <!-- Search & Filter Form -->
<section class="container mx-auto mt-6 bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Search & Filter Schools</h2>
    <form method="GET" action="manage_schools.php" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <input type="text" name="search" placeholder="Search by Name, Location, or School Code"
               value="<?php echo htmlspecialchars($search); ?>" class="p-2 border rounded">
        
        <select name="school_category" class="p-2 border rounded">
            <option value="">All Categories</option>
            <option value="Private" <?php if ($filter_category == 'Private') echo 'selected'; ?>>Private</option>
            <option value="Government" <?php if ($filter_category == 'Government') echo 'selected'; ?>>Government</option>
        </select>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
            Search & Filter
        </button>
    </form>
</section>


<!-- School List -->
<section class="container mx-auto mt-6 bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Registered Schools</h2>
    <table class="w-full border-collapse border border-gray-300">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="p-3 border">School Code</th>
                <th class="p-3 border">School Name</th>
                <th class="p-3 border">Location</th>
                <th class="p-3 border">School Type</th>
                <th class="p-3 border">Category</th>
                <th class="p-3 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr class="text-center bg-gray-100">
                    <td class="p-3 border"><?php echo htmlspecialchars($row['School_code']); ?></td>
                    <td class="p-3 border"><?php echo htmlspecialchars($row['School_name']); ?></td>
                    <td class="p-3 border"><?php echo htmlspecialchars($row['Location']); ?></td>
                    <td class="p-3 border"><?php echo htmlspecialchars($row['School_type']); ?></td>
                    <td class="p-3 border"><?php echo htmlspecialchars($row['School_category']); ?></td>
                    <td class="p-3 border">
                        <a href="manage_schools.php?delete=<?php echo $row['School_id']; ?>" 
                           class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>


</body>
</html>
