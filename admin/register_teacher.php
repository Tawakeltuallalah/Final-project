<?php
session_start();
require 'dbconfig.php';

 
$schools_query = $conn->query("SELECT School_id, School_name FROM school ORDER BY School_name ASC");

 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $gender = $_POST['gender'];
    $subject = trim($_POST['subject']);
    $school_id = $_POST['school_id'];
    $age = intval($_POST['age']);
    $phone = trim($_POST['phone']);

    
    if (empty($full_name) || empty($gender) || empty($subject) || empty($school_id) || empty($age) || empty($phone)) {
        $_SESSION['error'] = "All fields are required!";
    } elseif (!preg_match("/^09[0-9]{8}$|^\+2519[0-9]{8}$/", $phone)) {
        $_SESSION['error'] = "Phone number must be 10 digits starting with '09' or use '+251' format!";
    } elseif ($age < 18 || $age > 70) {
        $_SESSION['error'] = "Age must be between 18 and 70!";
    } else {
 
        var_dump($_POST);

        
        $stmt = $conn->prepare("INSERT INTO teacher (Full_name, Gender, Subject, School_id, Age, Phone) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiss", $full_name, $gender, $subject, $school_id, $age, $phone);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Teacher registered successfully!";
        } else {
            $_SESSION['error'] = "Error: " . $stmt->error; // Show SQL error
        }

         
        $stmt->close();
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Teacher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            align-items: center;
            margin-left: 20%;
             
        }

        h2 {
            text-align: center;
            color: #0056b3;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            
            text-align: center;
        }

        button:hover {
            background: #0056b3;
        }

        .message {
            text-align: center;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .success {
            background: #28a745;
            color: white;
        }

        .error {
            background: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Register Teacher</h2>

         
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="message success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="message error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php } ?>

         
        <form action="" method="POST">
            <!--<label for="full_name">Full Name:</label>-->
            <input type="text" id="full_name" name="full_name" placeholder="Enter full name" required>

            <!--label for="gender">Gender:</label>-->
            <select id="gender" name="gender"  required>
                <option value="">-- Select Gender --</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>

            <!--label for="subject">Subject:</label>-->
            <input type="text" id="subject" name="subject" placeholder="Subject" required>

            <!--label for="school_id">Select School:</label>-->
            <select id="school_id" name="school_id" required>
                <option value="">-- Select School type--</option>
                <?php while ($school = $schools_query->fetch_assoc()) { ?>
                    <option value="<?= $school['School_id']; ?>"><?= $school['School_name']; ?></option>
                <?php } ?>
            </select>

            <!--label for="age">Age:</label>-->
            <input type="number" id="age" name="age" placeholder="Age" required>

            <!--label for="phone">Phone Number:</label>-->
            <input type="text" id="phone" name="phone" placeholder="Phone number" required>

            <button type="submit">Register</button>
        </form>
    </div>

</body>
</html>
