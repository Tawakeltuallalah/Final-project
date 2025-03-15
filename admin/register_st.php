<?php
session_start();
require 'dbconfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = trim($_POST['student_name']);
    $age = intval($_POST['age']);
    $grade = intval($_POST['grade']);
    $school_id = intval($_POST['school_id']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $enrollment_date = $_POST['enrollment_date'];

  
    if (!preg_match("/^[a-zA-Z]+ [a-zA-Z]+$/", $student_name)) {
        die("<p style='color: red;'>Error: Enter full name (First & Last name).</p>");
    }

 
    if ($age <= 12) {
        die("<p style='color: red;'>Error: Age must be greater than 12.</p>");
    }

 
    if ($grade < 7 || $grade > 12) {
        die("<p style='color: red;'>Error: Grade must be between 7 and 12.</p>");
    }

 
    $school_check = $conn->query("SELECT School_type FROM school WHERE School_id = $school_id");
    if ($school_check->num_rows == 0) {
        die("<p style='color: red;'>Error: Invalid school selection.</p>");
    }
    $school_data = $school_check->fetch_assoc();
    $school_type = $school_data['School_type'];

    if (($grade == 7 || $grade == 8) && $school_type != 'primary') {
        die("<p style='color: red;'>Error: Grade 7-8 must be registered in a Primary School.</p>");
    }

    if (($grade >= 9 && $grade <= 12) && $school_type != 'secondary') {
        die("<p style='color: red;'>Error: Grade 9-12 must be registered in a Secondary School.</p>");
    }

 
    $dob_year = date('Y', strtotime($dob));
    $current_year = date('Y');
    $calculated_age = $current_year - $dob_year;

    if ($calculated_age != $age) {
        die("<p style='color: red;'>Error: Date of birth does not match the age.</p>");
    }

     
    $stmt = $conn->prepare("INSERT INTO student (Student_name, Age, Grade, School_id, Date_of_Birth, Gender, Enrollment_Date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiisss", $student_name, $age, $grade, $school_id, $dob, $gender, $enrollment_date);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Student Registered Successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Student</title>
    <style>
         body {
    font-family: 'Poppins', sans-serif;
    background:  #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 120vh;
    margin: 0;
}

.container {
    width: 100%;
    max-width: 450px;
    background: #ffffff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    text-align: center;
    animation: fadeIn 0.8s ease-in-out;
    margin-left: 20%;
    margin-top: 25%;
}

h2 {
    color: white; 
    background: linear-gradient(to right, #6a11cb, #2575fc);
    font-size: 24px;
    margin-bottom: 20px;
}

label {
    font-weight: 600;
    display: block;
    text-align: left;
    margin: 10px 0 5px;
    color: #444;
}

input, select {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    transition: 0.3s ease-in-out;
    background: #f8f8f8;
}

input:focus, select:focus {
    outline: none;
    border-color: #2575fc;
    box-shadow: 0 0 8px rgba(37, 117, 252, 0.3);
}

button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(to right, #6a11cb, #2575fc);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease-in-out;
 
}

button:hover {
    background: linear-gradient(to right, #2575fc, #6a11cb);
    transform: scale(1.02);
}

 
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

    </style>
</head>
<body>

<div class="container">
    <h2>Student Registration Form</h2>
    <form action="register_st.php" method="POST">
        <label for="student_name">Full Name:</label>
        <input type="text" name="student_name" placeholder="Enter full name" required>

        <label for="age">Age:</label>
        <input type="number" name="age" min="13" required>

        <label for="grade">Grade (7-12):</label>
        <input type="number" name="grade" min="7" max="12" required>

        <label for="school_id">Select School:</label>
        <select name="school_id" required>
            <option value="">-- Select School --</option>
            <?php
            require 'dbconfig.php';
            $schools = $conn->query("SELECT School_id, School_name FROM school");
            while ($school = $schools->fetch_assoc()) {
                echo "<option value='{$school['School_id']}'>{$school['School_name']}</option>";
            }
            ?>
        </select>

        <label for="dob">Date of Birth:</label>
        <input type="date" name="dob" required>

        <label for="gender">Gender:</label>
        <select name="gender" required>
        <option value="">-- Select option --</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          
        </select>

        <label for="enrollment_date">Enrollment Date:</label>
        <input type="date" name="enrollment_date" required>

        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>
