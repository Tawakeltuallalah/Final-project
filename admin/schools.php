<?php
require 'admin-auth.php';
require 'dbconfig.php';

// Handle school operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_school'])) {
        $name = $conn->real_escape_string($_POST['name']);
        $type = $conn->real_escape_string($_POST['type']);
        $location = $conn->real_escape_string($_POST['location']);

        $conn->query("INSERT INTO school (School_name, School_type, Location) 
                     VALUES ('$name', '$type', '$location')");
    }
    
    if (isset($_POST['delete_school'])) {
        $id = intval($_POST['school_id']);
        $conn->query("DELETE FROM school WHERE School_id = $id");
    }
}

$schools = $conn->query("SELECT * FROM school");
?>
<!DOCTYPE html>
<html>
<head>
    <title>School Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'admin-nav.php'; ?>
    
    <div class="container mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>School Management</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSchoolModal">
                    Add New School
                </button>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>School Name</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($school = $schools->fetch_assoc()): ?>
                        <tr>
                            <td><?= $school['School_name'] ?></td>
                            <td><?= ucfirst($school['School_type']) ?></td>
                            <td><?= $school['Location'] ?></td>
                            <td>
                                <a href="edit-school.php?id=<?= $school['School_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="school_id" value="<?= $school['School_id'] ?>">
                                    <button type="submit" name="delete_school" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add School Modal -->
    <div class="modal fade" id="addSchoolModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New School</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>School Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>School Type</label>
                            <select name="type" class="form-select" required>
                                <option value="primary">Primary School</option>
                                <option value="secondary">Secondary School</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Location</label>
                            <textarea name="location" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add_school" class="btn btn-primary">Add School</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>