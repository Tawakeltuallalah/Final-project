<?php
require 'dbconfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $grade = $_POST['grade'];
    $school_id = $_POST['school_id'];

    $sql = "INSERT INTO student (Full_name, Gender, Date_of_birth, Grade, School_id) 
            VALUES ('$full_name', '$gender', '$dob', '$grade', '$school_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Student registered successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="register_student.php" method="POST">
    <label>Full Name:</label>
    <input type="text" name="full_name" required>

    <label>Gender:</label>
    <select name="gender">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select>

    <label>Date of Birth:</label>
    <input type="date" name="dob" required>

    <label>Grade:</label>
    <input type="text" name="grade" required>

    <label>School:</label>
    <select name="school_id">
        <?php
        include 'db.php';
        $result = $conn->query("SELECT School_id, School_name FROM school");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['School_id']}'>{$row['School_name']}</option>";
        }
        ?>
    </select>

    <button type="submit">Register Student</button>
</form>

</body>
</html>