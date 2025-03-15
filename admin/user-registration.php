<?php
require 'dbconfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $role = $_POST['role'];

 
    if (!preg_match('/^\S+\s+\S+/', $name)) {
        echo json_encode(["status" => "error", "message" => "Please enter both first and second names."]);
        exit();
    }
 
    if (strlen($password) < 8 || 
        !preg_match('/[A-Z]/', $password) || 
        !preg_match('/[a-z]/', $password) || 
        !preg_match('/[0-9]/', $password) || 
        !preg_match('/[\W]/', $password)) {
        
        echo json_encode(["status" => "error", "message" => "Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character."]);
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    $checkEmail = "SELECT Email FROM user WHERE Email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email already exists"]);
        exit();
    }

     
    $sql = "INSERT INTO user (Name, Email, Phone, Password, Role) 
            VALUES ('$name', '$email', '$phone', '$hashed_password', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Registration successful! Redirecting to login..."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }

    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #1e3c72, #2a5298);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        h2 {
            color: #2a3f54;
            font-size: 24px;
            margin-bottom: 15px;
        }

        input, select, button {
            display: block;
            margin: 12px auto;
            padding: 12px;
            width: 90%;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: all 0.3s ease-in-out;
        }

        input:focus, select:focus {
            border-color: #007bff;
            box-shadow: 0px 0px 8px rgba(0, 123, 255, 0.3);
            outline: none;
        }

        button {
            background: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: 0.3s ease-in-out;
        }

        button:hover {
            background: #0056b3;
            transform: scale(1.05);
        }

        .error, .success {
            font-size: 14px;
            margin-top: 10px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }

        .password-strength {
            font-size: 14px;
            margin-top: 5px;
            text-align: left;
            padding-left: 20px;
            color: red;
        }

        p {
            font-size: 14px;
        }

        p a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        p a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

  
        @media (max-width: 400px) {
            .register-container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>Create an Account</h2>
        <form id="registerForm">
            <input type="text" name="name" id="name" placeholder="Full Name" required>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <input type="text" name="phone" id="phone" placeholder="Phone Number" required pattern="[0-9]{10,15}">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <div class="password-strength" id="password-strength"></div>
            <select name="role" id="role">
            <option value="">Select Role</option>
                <option value="Admin">Admin</option>
                 
            </select>
            <button type="submit">Register</button>
        </form>
        <p class="error" id="error-message"></p>
        <p class="success" id="success-message"></p>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>

    <script>
        document.getElementById('password').addEventListener('input', function() {
            var password = this.value;
            var strengthText = document.getElementById('password-strength');

            if (password.length < 8) {
                strengthText.innerHTML = "Password must be at least 8 characters.";
                strengthText.style.color = "red";
            } else if (!/[A-Z]/.test(password)) {
                strengthText.innerHTML = "Include at least one uppercase letter.";
                strengthText.style.color = "orange";
            } else if (!/[a-z]/.test(password)) {
                strengthText.innerHTML = "Include at least one lowercase letter.";
                strengthText.style.color = "orange";
            } else if (!/[0-9]/.test(password)) {
                strengthText.innerHTML = "Include at least one number.";
                strengthText.style.color = "orange";
            } else if (!/[\W]/.test(password)) {
                strengthText.innerHTML = "Include at least one special character.";
                strengthText.style.color = "orange";
            } else {
                strengthText.innerHTML = "Strong password!";
                strengthText.style.color = "green";
            }
        });

        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch('user-registration.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById(data.status === "success" ? 'success-message' : 'error-message').innerText = data.message;
                if (data.status === "success") setTimeout(() => window.location.href = "login.php", 2000);
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
